<?php
/**
 * Created by PhpStorm.
 * User: techgroup
 * Date: 2018/5/19
 * Time: 16:13
 */

namespace app\index\model;
use think\Exception;
use think\model;
use think\db;
require THINK_PATH.'../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use app\index\model\JsonFileOp as jsonFileOp;

global $processPercent;
$processPercent = 10;


//$processPercent = 10;

class DataExtra extends Model
{
//    private $processPercent;
    //load sheet of excel
    public function loadSpreadsheet($filename){
        $spreadsheet = null;
        if (file_exists($filename))
        {
            $spreadsheet = IOFactory::load($filename);
        }
        return $spreadsheet;
    }


    public $temp;

    public function getPercent(){
//        global $processPercent;
//        echo $processPercent;
        $res = Db::query('select ps_percent from process_status where ps_id=?',[1]);
//        echo $res[0]['ps_percent'];
//        Db::execute("update process_status set ps_percent=:percent where ps_id =:id ",['percent'=>100, 'id'=>1]);
//        $res = Db::query('select ps_percent from process_status where ps_id=?',[1]);
//        echo $res[0]['ps_percent'];
        return $res[0]['ps_percent'];
    }

     //extra data of input file and write to the info table
    public function doextraData($infiles){
        //删除数据表info_table
        //DB::table("info_table")->where()->delete();
        DB::query('TRUNCATE table `info_table`');
        //将项目清单信息存放到output中
        $count = 1;
//        echo "<br/> extraProjectList";
        $output = $this->extraProjectList();
//        echo "<br/> ";
        $this->storageProjectList($output);
//        echo "<br/> ";

        $this->extraMaterialCertificate();
    }

    public function extraSelected($testarray){
        foreach ($testarray as $key => $value){
            $res = Db::query('select * from info_table where it_testnum=?',$value);
        }
    }
    public function extraTestNum(){
        $srclist = DB::table('info_table')
            ->field('it_testnum')
            ->select();
//        echo "srclist";
//        dump($srclist);

        $deslist = array();

        foreach ($srclist as $key=>$item){
            foreach ($item as $field=>$value){
                array_push($deslist,$value);
            }
        }
        $testnum = array_unique($deslist);
        echo json_encode($testnum);
    }

    public function extraInfoTestNum(){
        $srclist = DB::table('info_table')
            ->field('it_testnum')
            ->select();

        $deslist = array();

        foreach ($srclist as $key=>$item){
            foreach ($item as $field=>$value){
                array_push($deslist,$value);
            }
        }
        $testnum = array_unique($deslist);
        return json_encode($testnum);
    }


    public function doextraInfo(){
         //echo "doextra Info";
        DB::query('TRUNCATE table `info_table`');
        $infotable = eval(INFOTABLE);

        $name = INPUT_DIR.M_FILE;
        //echo "<br/>".$name;
        $spreadsheet = $this->loadInputFile($name);
        $worksheet = $spreadsheet->getActiveSheet();
        if(!empty($spreadsheet)) {
            $line = 2;
            while (($spreadsheet->getActiveSheet()->getCell("D".$line) == "")!=1){
                echo "<br/>".$line;
                $db_field = "";
                $qm_num = "";
                $src = array();
                foreach ($infotable as $key=>$value){
                    $tmparr = DataExtra::ch2arr($value);
                    $pos = $tmparr[0].$line;
                    $tempValue = $worksheet->getCell($pos)->getValue();
                    array_push($src,$tempValue);
                    $db_field = $db_field.$key.",";
                    $qm_num = $qm_num."?,";
                }
                $db_field = mb_substr($db_field,0,-1,"utf-8");
                $qm_num = mb_substr($qm_num,0,-1,"utf-8");
               // echo "<br/>".$db_field;
                //echo "<br/>".$qm_num;
                DB::execute("insert into info_table ($db_field) values ($qm_num)",$src);
                $line++;
            }
        }

    }

    private function storageProjectList($output){

         $reflectarr = eval(MYSQLREFLECT);


         //遍每一行的数据
         $count = 0;
         DB::startTrans();
         foreach ($output as $key=>$row){
//             echo "<br/> count:".$count;
//             $count++;
             //用来拼接sql语句的内容
             $db_field = "";
             //问号的数量
             $qm_num = "";
             $values = array();
             //遍历行中的元素插入到数据库中
             //dump($row);
             foreach ($row as $name=>$value)
             {
                 if (array_key_exists($name,$reflectarr)){
                     $db_field = $db_field.($reflectarr[$name]).",";
                     $qm_num = $qm_num."?,";
                     array_push($values,$value);
                 }
             }
             //dump($values);
             // dump($values);
             $db_field = mb_substr($db_field,0,-1,"utf-8");
             $qm_num = mb_substr($qm_num,0,-1,"utf-8");
             $sql = "insert into info_table ($db_field) values ($qm_num)";
             DB::execute("insert into info_table ($db_field) values ($qm_num)",$values);
         }
         DB::commit();
    }
    public function extraInfo2Database(){

        DB::query('TRUNCATE table `info_table`');
        //echo 'batchnum';
        $files = eval(INFOTABLE);
        //提取自制件验收项目清单的内容
        $filepath = OUT_DIR."CaiLiaoXinXiBiao/".M_FILE;
        //echo "filepath:".$filepath;
        $spreadsheet = $this->loadInputFile($filepath);
        DB::startTrans();
        if(!empty($spreadsheet)) {
            //echo 'batchnum1';
            $line = 2;
            while (($spreadsheet->getActiveSheet()->getCell("O" . $line) == "") != 1) {
                $desStr = array();
                //用来拼接sql语句的内容
                $db_field = "";
                //问号的数量
                $qm_num = "";
                foreach ($files as $key=>$value){
                    $tmparr = DataExtra::ch2arr($value);
                    $pos = $tmparr[0].($tmparr[1]+$line-2);
                    $desc = $spreadsheet->getActiveSheet()->getCell($pos)->getValue();
                    $db_field = $db_field.($key).",";
                    $qm_num = $qm_num."?,";
                    array_push($desStr,$desc);
                }
                $db_field = mb_substr($db_field,0,-1,"utf-8");
                $qm_num = mb_substr($qm_num,0,-1,"utf-8");
                $sql = "insert into info_table ($db_field) values ($qm_num)";
//                echo "<br/> sql: $sql";
//                dump($desStr);
                DB::execute("insert into info_table ($db_field) values ($qm_num)",$desStr);
                $line++;
            }
            DB::commit();
            $arrayData = DB::table('info_table')->select();
            return $arrayData;
        }
    }

    private function extraMaterialCertificate(){

        //echo 'batchnum';
        $files = eval(FILE);
        //提取自制件验收项目清单的内容
        $name = I_FILE1;
        $spreadsheet = $this->loadInputFile(INPUT_DIR.I_FILE1);
        if(!empty($spreadsheet)) {
            //echo 'batchnum1';
            $line = 3;
            while (($spreadsheet->getActiveSheet()->getCell("A" . $line) == "") != 1) {
                //获取到第line行的材质
                $num = $spreadsheet->getActiveSheet()->getCell("C".$line)->getValue();
                //获取到第line行的规格
                $num1 = intval($spreadsheet->getActiveSheet()->getCell("D".$line)->getValue());
                //获取到第line行的批号
                $num2 = $spreadsheet->getActiveSheet()->getCell("E".$line)->getValue();
                //$srcStr = "it_materialnum = $num, it_spec = $num1, it_batchnum = $num2";
                $srcStr = array(
                    "it_materialnum" => $num,
                    "it_spec"=>$num1,
                    "it_batchnum"=>$num2
                );

                //dump($srcStr);
                //$desStr = DB::table('info_table')->where('it_materialnum' ,$num)->select();
                //DB::table('info_table')->where($srcStr)->select();

                //获取到底line行的质量证书编号
                $num3 = $spreadsheet->getActiveSheet()->getCell("J".$line)->getValue();
                //获取到底line行的材质证名单编号
                $num4 = $spreadsheet->getActiveSheet()->getCell("K".$line)->getValue();
                //获取到第line行的化学报告
                $num5 = $spreadsheet->getActiveSheet()->getCell("L".$line)->getValue();
                //获取到第line行的力学报告
                $num6 = $spreadsheet->getActiveSheet()->getCell("N".$line)->getValue();
                //获取到第line行的金相报告
                $num7 = $spreadsheet->getActiveSheet()->getCell("O".$line)->getValue();

                $desStr = array(
                    "it_quaprovenum"=>$num3,
                    "it_metaprovenum"=>$num4,
                    "it_cheminum"=>$num5,
                    "it_mechnum"=>$num6,
                    "it_metalnum"=>$num7
                );

                //dump($desStr);

                DB::table('info_table')->where($srcStr)->update($desStr);

                $line++;
                //echo "<br/> line: $line";
            }
        }


    }


    //解析项目清单
    private function extraProjectList()
    {
        $files = eval(FILE);
        $output = array();
        //提取自制件验收项目清单的内容
        $name = I_FILE0;
//        echo "<br/> infile:".INPUT_DIR.I_FILE0;
        $spreadsheet = $this->loadInputFile(INPUT_DIR.I_FILE0);
        //dump($spreadsheet);
        if(!empty($spreadsheet))
        {
            $params = $files[$name];
            //dump($params);
            $line = 7;
            while (($spreadsheet->getActiveSheet()->getCell("A".$line) == "")!=1){
                $line++;
            }
//            echo "<br/> totalline:".$line;
            //output's line
            $outline = 0;
            for ($i=0;$i<($line-7);$i++){
//                echo "<br/> line:".$i;
//                echo "<br/> time:".time();

                //read one file's information
                foreach ($params as $key=>$param)
                {
                    $tmparr = $this->ch2arr($param);
                    //dump($tmparr);
                    $output[$outline]["报验单号"] = $spreadsheet->getActiveSheet()->getCell("F3")->getValue();
                    $param = $tmparr[0].($tmparr[1]+$i);
                    //echo $param;
                    //is this cell contain multi keywords
                    if (strpos($key,'str')===false){
                        $output[$outline][$key] = $spreadsheet->getActiveSheet()->getCell($param)->getValue();
                    }else{
                        $str1 = $spreadsheet->getActiveSheet()->getCell($param)->getValue();
//                        echo "<br/> str1:".$str1;
                        $num = substr_count($str1,"用料规格及长度");
                        if ($num==0){
                            continue;
                        }
//                        foreach ($arr as $value){
//                            if (($value == 'φ')){
//                                $num++;
//                            }
//                        }
                        $str = array();
                        //coorperate the multiline case copy the line 0 to line1
                        if ($num==2){
                            $output[$outline+1]=$output[$outline];
                            //echo 'str:'.$str1.'<br/>';
                            //将两份关键参数分开
                            $str1 = substr($str1, strpos($str1,"套料信息："));
//                            echo "<br/> str:".$str1;
                            $str[0] = substr($str1,0,strpos($str1,"2、"));
//                            echo "<br/> str0:".$str[0];


                            $str[1] = substr($str1, strpos($str1,"2、"), strlen($str1)-strlen($str[0]));
//                            echo "<br/> str1:".$str[1];
                            //包含两个关键参数的情况，提取名称
                            $output[$outline]["工件名称"] = $this->cut("1、","（",substr($str[0],0,strpos($str[0],"1）")) );
//                            echo "<br/> output0:".$output[$outline]["工件名称"];
                            $output[$outline+1]["工件名称"] = $this->cut("2、","（",substr($str[1],0,strpos($str[1],"1）")) );
//                            echo "<br/> output1:".$output[$outline+1]["工件名称"];
                        }else if ($num == 1){
                            $str[0] = $str1;
                        }


                        foreach ($str as $count=>$substr){
//                            echo "<br/> substr:".$substr;
                            $this->keywordExtra($substr, $output[$outline]);
                            $outline++;
                        }
                    }
                }
            }

        }
//        dump($output);
        return $output;

    }
    /**
     * php截取指定两个字符之间字符串，默认字符集为utf-8 Power by 大耳朵图图
     * @param string $begin  开始字符串
     * @param string $end    结束字符串
     * @param string $str    需要截取的字符串
     * @return string
     */
    function cut($begin,$end,$str){
        $b = mb_strpos($str,$begin) + mb_strlen($begin);
        $e = mb_strpos($str,$end) - $b;

        return mb_substr($str,$b,$e);
    }

    public function loadInputFile($filename)
    {
        $fileInfoTable = new excelFileOp();
        $spreadsheet = $fileInfoTable->loadSpreadsheet($filename);
        return $spreadsheet;
    }


     //extra data from string
    public function keywordExtra($substr, &$output){
        //dump($outstr);

        //echo $inputstring."<br/>";

        //dump(EXTRASTRING);
        $keywords = eval(EXTRASTRING);

        $arr = $this->getchar2arr($substr);
        //travelsal the keywords array to match the input string
         foreach ($keywords as $index=>$words){
            $wordsarr = $this->getchar2arr($words);
            $wordsarrcount = 0;
            //traversal the char array to find the start of every element
//             dump($arr);
            foreach ($arr as $key=>$value){
                //判断开头
                if ($wordsarr[$wordsarrcount] == $value){
                    $wordsarrcount++;
                }else if (($wordsarrcount!=0)&($wordsarrcount!=sizeof($wordsarr))){
                    $wordsarrcount = 0;
                }
                //如果找到了关键字
                if (($wordsarrcount==sizeof($wordsarr))){
                    $tmpkey = $key+1;
                    $tmparr = array();
                    while (($tmpkey!=sizeof($arr))&&(strlen($arr[$tmpkey])!=3))
                    {
                        array_push($tmparr, $arr[$tmpkey]);
                        $tmpkey++;
                    }
                    $output[$index] = implode("", $tmparr);
                    $arr = array_slice($arr,$tmpkey);
                    break;
                }
            }
        }
//        echo "<br/> for special operate:";
//        dump($output);

       //special operate for special output
        $this->specialOpt($output);
   }

    //special for special cell
    private function specialOpt(&$data){
        $quantStr = $data['备料数量'];
//        echo "<br/> quantStr:".$quantStr;
        $factor1 = $this->cut("φ","×",$quantStr);
//        echo "<br/> factor1:".$factor1;
        $factor2 = $this->cut("×", "mm",$quantStr);
//        echo "<br/> factor2:".$factor2;
        $data['备料数量'] = intval($factor2);
//        echo "<br/> quantStr:".$quantStr;
        $data['规格'] = (int)($factor1);
        $data['备料数量1']   = '×';
        //dump($count);
        $data['备料数量2']  = '1';
        $data['备料数量3']  = "根";
        $density = null;
        if (1 == substr_count(CUMATERIAL, $data['材料牌号'])){
            $density = 8.9;
        }else{
            $density = 7.85;
        }
        if (key_exists("断口长度",$data)){
            $sliplenStr = $data['断口长度'];
            $factor2 = $this->cut("×", "mm",$quantStr);
            $data['断口长度'] = intval($factor2);
            $data['备料重'] = M_PI*(intval($data['规格'])/2)*(intval($data['规格'])/2)*($data['备料数量']+$data['断口长度'])*$density/1000000;
        }else{
            $data['备料重'] = M_PI*(intval($data['规格'])/2)*(intval($data['规格'])/2)*($data['备料数量'])*$density/1000000;
        }
        $data['序号'] = random_int(0,1000);
        $data['路线表号'] = random_int(10000,99999);
        $data['件号'] = random_int(1000,9999);
//        dump($data);
    }

    //trans string to array
    private function getchar2arr($input)
    {
        //剪去头部
        //$shortinput = substr($input, strlen($start)+strpos($input, $start));
        //$result = preg_replace('/([\x80-\xff]*)/i','',$input);
        //dump($result);
        $arr1 = $this->ch2arr($input);
        //dump($arr1);
        return $arr1;
    }


    static function ch2arr($str)
    {
        $length = mb_strlen($str, 'utf-8');
        $array = [];
        for ($i=0; $i<$length; $i++)
            $array[] = mb_substr($str, $i, 1, 'utf-8');
        return $array;
    }


}