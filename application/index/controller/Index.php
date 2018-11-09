<?php
namespace app\index\controller;

use app\index\model\DataExtra;
use app\index\model\ExcelFileOp;
use app\index\model\CommonTable;
use think\Controller;
use think\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use think\Db;


require dirname(__FILE__).'/../../common/common.php';
//
//define('I_FILE0','报验清单.xlsx');
//define('I_FILE1','路线表号件号.xlsx');
//define('I_FILE2','力化金.xlsx');
class Index extends Controller
{
    public function index($name = 'AutoPPM')
    {
        $this->assign('name',$name);
        return $this->fetch('Welcome');
    }

    //文件上传页面
    public function add()
    {
        return $this->fetch();
    }

    public function generate()
    {
        return $this->fetch();
    }
	
	public function main()
	{
		return $this->fetch('main');
    }
    
    public function admin()
	{
		return $this->fetch('admin');
	}


    //上传多个文件
    public function uploads(Request $request)
    {
        //接收用户上传的数据
        $files = $request->file('file');
        dump($files);
        if (array_key_exists(0, $files)) {
            if ($info = $files[0]->move(INPUT_DIR, constant("I_FILE0"))) {
                //echo "<br/> uploads1";
                dump($info->getsaveName());
            }
        }
        if (array_key_exists(1, $files)) {
            if ($info = $files[1]->move(INPUT_DIR, constant("I_FILE1"))) {
                //echo "<br/> uploads2";
                dump($info->getsaveName());
            }
        }
        if (array_key_exists(2,$files)) {
            if ($info = $files[2]->move(INPUT_DIR, constant("I_FILE2"))) {
                //echo "<br/> uploads3";
                dump($info->getsaveName());
            }
        }
        //清空材料信息表，准备重新生成。
        $dir = OUT_DIR.'CaiLiaoXinXiBiao/';
        if (is_dir($dir)) {
            $this->clearDir($dir);
            rmdir($dir);
        }
        //echo '上传成功';
        //return "";

        //$this->success();

        //$this->success("","http://localhost/autoppm/public/index/Index/add.html","",0);
    }

    public function inforeupload(Request $request){
        dump($request);
        $file = $request->file('file');
        if (array_key_exists(0, $file)){
            echo "<br/> file exist";
            $info = $file[0]->move(OUT_DIR."CaiLiaoXinXiBiao", constant("M_FILE"));
        }
        echo "<br/> file do not exist";
    }
    public function info2database(){
        $extraInfoTable = new DataExtra();
        $extraInfoTable->extraInfo2Database();
    }

    public function getTestnum()
    {
//        echo "getTestnum";
        $extraInfoTable = new DataExtra();
        return $extraInfoTable->extraTestNum();
    }
    public function getinfoTestnum()
    {
//        echo "getTestnum";
        $extraInfoTable = new DataExtra();
        return $extraInfoTable->extrainfoTestNum();
    }
    public function getPercent()
    {
        $extraInfoTable = new DataExtra();
        echo $extraInfoTable->getPercent();

    }

    public function dataExtra()
    {
        Db::execute("update process_status set ps_percent=:percent where ps_id =:id ",['percent'=>20, 'id'=>1]);
        //创建材料信息表目录
        $dir = OUT_DIR.'CaiLiaoXinXiBiao/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
            //读要取用的列表
            $files = eval(INPUTFILES);
            //dump($filearry);
//            echo "<br/> ";
            $extraInfoTable = new DataExtra();
            $extraInfoTable->doextraData($files);
//            echo "<br/> ";
            Db::execute("update process_status set ps_percent=:percent where ps_id =:id ",['percent'=>20, 'id'=>1]);
            $writeInfoTable = new excelFileOp();
            //dump($data);
            $spreadsheet = IOFactory::load(PUB_DIR.'材料信息表template.xlsx');
            Db::execute("update process_status set ps_percent=:percent where ps_id =:id ",['percent'=>45, 'id'=>1]);
            $worksheet = $spreadsheet->getActiveSheet();


            $arraydata = $writeInfoTable->writeinfoFile($worksheet);
            Db::execute("update process_status set ps_percent=:percent where ps_id =:id ",['percent'=>70, 'id'=>1]);
            //通过工厂模式来写内容
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($dir.'材料信息表.xlsx');
            $result = json_encode($arraydata);
            Db::execute("update process_status set ps_percent=:percent where ps_id =:id ",['percent'=>100, 'id'=>1]);
            echo $result;
        }else{
            $extraInfoTable = new DataExtra();
            $result = $extraInfoTable->extraInfo2Database();
            echo json_encode($result);
        }
    }

    public function generateBaseTestnum(Request $request){
        $testnumlist = $request->param("testli");
        $testArray = json_decode($testnumlist);
        dump($testArray);
    }

    public function infoExtra(){
        $extraInfoTable = new DataExtra();
        $extraInfoTable->doextraInfo();

    }

    public function loadTemplate(){
        $fileInfoTable = new excelFileOp();
        $fileInfoTable->loadTemplate('fileInfoTable.xlsx');
        dump($fileInfoTable);
        dump(json_decode(O_FILE3));
    }

    public function createFileInfoTable(){

        $fileInfoTable = new excelFileOp();

        $fileInfoTable->setDraw('fileInfoTable.xlsx','B26','paid.png');
    }

    //生成周转卡，物料清单，
    public function generate1(Request $request){
        $testnumArray   = null;
        $reportnumArray = null;
        $testnumlist = $request->param("testnumlist");
        $testnumArray = json_decode($testnumlist);
//      $testnumlist = $this->getinfoTestnum();
//      $testnumArray = json_decode($testnumlist);
        $reportnumlist = $request->param("idnumlist");
        $reportnumArray = json_decode($reportnumlist);
        echo "<br/> testnumArray:";
        dump($testnumArray);
        echo "<br/> reportnumArray:";
        dump($reportnumArray);
        $fileInfoTable = new excelFileOp();
         //去重的试号数组
        if (sizeof($testnumArray) != 0){
            $fileInfoTable->generateWuLiaoQingDan($testnumArray);
            $fileInfoTable->generateHeLuQingDan($testnumArray);
            $zip1 = new \ZipArchive();
            if ($zip1->open(OUT_DIR."物料清单.zip", \ZipArchive::OVERWRITE)){
                if ($zip1->open(OUT_DIR."物料清单.zip", \ZipArchive::CREATE))
                {
                    $this->addFileToZip(OUT_DIR.'WuLiaoQingDan/', $zip1);
                }
            }
            $zip1->close();
            $zip2 = new \ZipArchive();
            if ($zip2->open(OUT_DIR."合炉清单.zip", \ZipArchive::OVERWRITE)){
                if ($zip2->open(OUT_DIR."合炉清单.zip", \ZipArchive::CREATE))
                {
                    $this->addFileToZip(OUT_DIR.'HeLuQingDan/', $zip2);
                }
            }
            $zip2->close();
        }
        if (sizeof($reportnumArray) != 0){
            $fileInfoTable->generateZhouZhuanKa($reportnumArray);
            $zip = new \ZipArchive();
            if ($zip->open(OUT_DIR."周转卡.zip", \ZipArchive::OVERWRITE)){
                if ($zip->open(OUT_DIR."周转卡.zip", \ZipArchive::CREATE))
                {
                    $this->addFileToZip(OUT_DIR.'ZhouZhuanKa/', $zip);
                }
            }
            $zip->close();
        }
    }
    //生成锻造工艺卡，热处理工艺卡
    public function generate2(Request $request){
        $fileInfoTable= new excelFileOp();
        $testnumArray   = null;
        //去重的试号数组
        if ($request->has("testnumlist")){
            $testnumlist = $request->param("testnumlist");
            $testnumArray = json_decode($testnumlist);
        }else{
            $testnumlist = $this->getinfoTestnum();
            $testnumArray = json_decode($testnumlist);
        }
        //锻造工艺卡
        $fileInfoTable->generateDuanZhaoGongYiKa($testnumArray);

        $fileInfoTable->generateReChuLiYiKa($testnumArray);
        $zip = new \ZipArchive();
            if ($zip->open(OUT_DIR."锻造工艺卡.zip", \ZipArchive::OVERWRITE)){
                if ($zip->open(OUT_DIR."锻造工艺卡.zip", \ZipArchive::CREATE))
                {
                    //echo 'addFileToZip';
                    $this->addFileToZip(OUT_DIR.'DuanZhaoGongYiKa/', $zip);
                }
            }
        $zip->close();
        $zip1 = new \ZipArchive();
            if ($zip1->open(OUT_DIR."热处理工艺卡.zip", \ZipArchive::OVERWRITE)){
                if ($zip1->open(OUT_DIR."热处理工艺卡.zip", \ZipArchive::CREATE))
                {
                    //echo 'addFileToZip';
                    $this->addFileToZip(OUT_DIR.'ReChuLiGongYiKa/',$zip1);
                }
            }
        $zip1->close();
    }
    private function addFileToZip($path,$zip){
        $handler=opendir($path); //打开当前文件夹由$path指定。
        while(($filename=readdir($handler))!==false){
            if($filename != "." && $filename != ".."){
                //文件夹文件名字为'.'和‘..'，不要对他们进行操作
                //echo 'addFile'.$path;
                $zip->addFile($path."/".$filename);
                $zip->renameName($path."/".$filename, $filename);
            }
        }
        @closedir($path);
    }
    // 生成表格eg：周转卡
    public function generateZhouZhuanKa(){
        $fileInfoTable = new excelFileOp();
        $fileInfoTable->generateZhouZhuanKa();
        //$this->success();
    }

    //生成物料清单
    public function generateWuLiaoQingDan(){
        $fileInfoTable= new excelFileOp();
        //去重的试号数组
        $testnum = $this->getTestnum();
        dump($testnum);
        $fileInfoTable->generateWuLiaoQingDan($testnum);
    }
    //生成锻造工艺卡
    public function generateDuanZhaoGongYiKa(){
        $fileInfoTable= new excelFileOp();
        //去重的试号数组
        $testnum = $this->getTestnum();
        $fileInfoTable->generateDuanZhaoGongYiKa($testnum);
    }
     //生成热处理工艺卡
    public function generateReChuLiGongYiKa(){
        $fileInfoTable= new excelFileOp();
        //去重的试号数组
        $testnum = $this->getTestnum();
        $fileInfoTable->createReChuLiGongYiKa(OUT_DIR.'ReChuLiGongYiKa/',TEMPLATE_DIR.'热处理工艺卡.xlsx',JSON_DIR.'ReChuLiGongYiKa.json',$testnum);
    }

    // 生成表格eg：物料清单
    public function createWuLiaoQingDan(){
        $data = [6];//要生成表格的试号列表
        $fileInfoTable= new excelFileOp();
        $fileInfoTable->createWuLiaoQingDan(OUT_DIR.'WuLiaoQingDan/',TEMPLATE_DIR.'物料清单.xlsx',JSON_DIR.'WuLiaoQingDan.json',$data);
        $this->success();
    }

    //生成表格eg:锻造工艺卡

    public function createDuanZhaoGongYiKa(){
        $data = [6];//要生成表格的试号列表
        $fileInfoTable= new excelFileOp();
        $fileInfoTable->createDuanZhaoGongYiKa(OUT_DIR.'DuanZhaoGongYiKa/',TEMPLATE_DIR.'锻造工艺卡.xlsx',JSON_DIR.'DuanZhaoGongYiKa.json',$data);
        $this->success();
    }
    /*
     * 删除目录文件
     * $path : 需要删除路径
     */
    private function clearDir($path){
        if(is_dir($path) && (count($p = scandir($path))>2)){
            foreach ($p as $fName){
                if($fName != "." && $fName != ".."){
                    unlink($path.$fName);
                }
            }
        }
    }


    /*admin接口*/
    public function adminInit(){
        $commonTable = new CommonTable();
        $result =  $commonTable->queryCommon();
        echo json_encode($result);
    }

    //插入一行数据测试
    public function adminCommonTableAdd(Request $request){
        $imagePath  = null;
        $imageNum = $request->param('sFigure');
        $forgingRatio = $request->param('sForging');
        $direction  = $request->param("sCoupon");
        $zuanData   = $request->param("sDrill");
        $imagefile  = $request->file("sFile");
        echo "<br/> imagefile".$imagefile;
        if ($imagefile){
            $info = $imagefile->move(ROOT_PATH.'public'.DS.'image', $imageNum);
            if ($info){
                $imagePath = "image/".$info->getSaveName();
            }
        }
        $commonTable = new CommonTable();
        $commonTable->addCommon($imageNum,$forgingRatio,$direction,$zuanData,$imagePath);
    }
    //更新数据测试
    public function adminUpdateOneRowData(Request $request){
        $imagePath  = null;
        $imageNum = $request->param('mFigure');
        $forgingRatio = $request->param('mForging');
        $direction  = $request->param("mCoupon");
        $zuanData   = $request->param("mDrill");
        $imagefile  = $request->file("mFile");
        if ($imagefile){
            $info = $imagefile->move(ROOT_PATH.'public'.DS.'image', $imageNum.".png");
            if ($info){
                $imagePath = "image/".$info->getSaveName();
            }
        }
        $commonTable = new CommonTable();
        $value = [
            "cForgingRatio" => $forgingRatio,
            "cTbDirection" => $direction,
            "cZuanData" => $zuanData,
            "cImagePath" => $imagePath
        ];
        dump($value);
        $result =  $commonTable->updateOneRowData($imageNum,$value);
        dump($result);
    }
    //删除数据测试
    public function admindelectOneRowData(Request $request){
        $commonTable = new CommonTable();
        $result =  $commonTable->delectOneRowData($request->param("dtestnum"));
        dump($result);
    }
}
