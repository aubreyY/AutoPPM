<?php
/**
 * Created by PhpStorm.
 * User: lzm
 * Date: 2018/5/19
 * Time: 16:22
 */

namespace app\index\model;

use think\Exception;
use think\model;
use think\db;

require THINK_PATH . '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Color;
use app\index\model\JsonFileOp as jsonFileOp;

define('RETURN_SUCCESS', 1);
define('RETURN_FAILED', 0);

define('TYPE_STRING', 0);
define('TYPE_IMAGE', 1);

define('FILE_NO_EXIST', '文件不存在！');

class ExcelFileOp extends model
{

    public function loadTemplate($filename)
    {

        $spreadsheet = IOFactory::load($filename);
        return $spreadsheet;
    }

    /*
     * 按照配置文件生成excle文件
     * $srcFileName：模版文件名称（路径）
     * $desFileName：生成文件名称（路径）
     * $confgfileName：配置文件名称（路径）
     * $arrayValue:需填写数据
     * */
    public function createExcelByConfig($desFileName, $srcFileName, $confgfileName, $rowNumber)
    {
        try {
            if (!file_exists($srcFileName)) {
                dump($srcFileName . FILE_NO_EXIST);
                return $srcFileName . FILE_NO_EXIST;
            }

            $dir = iconv("UTF-8", "GBK", $desFileName);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                echo '创建文件夹成功';
            } else {
                echo '需创建的文件夹' . $desFileName . '已经存在';
            }
            $spreadsheet = IOFactory::load($srcFileName);
            $worksheet = $spreadsheet->getActiveSheet();
            $jsonFileOp = new jsonFileOp();
            $arrayData = $jsonFileOp->readJsonFile($confgfileName);
            dump($arrayData);
            foreach ($arrayData["table"] as $key => $value) {
                dump($key);
                dump(is_array($value));
                if ($key == "points" && is_array($value)) {
                    foreach ($value as $key => $value) {
                        dump($value["type"]);
                        dump($value["location"]);
                        switch ($value["type"]) {
                            case 0:
                                $worksheet->setCellValue($value["location"], $this->getValueByLocationFromFile('fileInfoTable.xlsx', $rowNumber, $value["index"]));
                                break;
                            case 1:
                                $this->setImageRes($worksheet, $this->getValueByLocationFromFile('fileInfoTable.xlsx', $rowNumber, $value["index"]));
                                break;
                            default:
                                break;
                        }

                    }
                }
            }

            //通过工厂模式来写内容
            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save($desFileName . $this->getValueByLocationFromFile('fileInfoTable.xlsx', $rowNumber, 0) . '.xlsx');
            return RETURN_SUCCESS;
        } catch (Exception $e) {
            dump($e->getMessage());
            return RETURN_FAILED;
        }

    }
    //生成周转卡
    public function generateZhouZhuanKa($srclist){
        //获取试号的数组
//        $srclist = DB::table('info_table')
//            ->field('it_id')
//            ->select();
        dump($srclist);
        $this->clearDir(OUT_DIR.'ZhouZhuanKa/');
        //递归所有的试号
        foreach ($srclist as $key=>$value){
//            foreach ($item as $db_field=>$value){
                dump($value);
                if ($value){
                    $this->createZhouZhuanKa(OUT_DIR.'ZhouZhuanKa/',TEMPLATE_DIR.'周转卡.xlsx'
                        ,JSON_DIR.'ZhouZhuanKa.json',$value);
                }
//            }
        }
    }

    //生成物料清单,testnum为试号的数组
    public function generateWuLiaoQingDan($testnum){
        $this->clearDir(OUT_DIR.'WuLiaoQingDan/');
        $this->createWuLiaoQingDan(OUT_DIR.'WuLiaoQingDan/',TEMPLATE_DIR.'物料清单.xlsx',JSON_DIR.'WuLiaoQingDan.json',$testnum);
    }
    //生成锻造工艺卡,testnum为试号的数组
    public function generateDuanZhaoGongYiKa($testnum){
        $this->clearDir(OUT_DIR.'DuanZhaoGongYiKa/');
        $this->createDuanZhaoGongYiKa(OUT_DIR.'DuanZhaoGongYiKa/',TEMPLATE_DIR.'锻造工艺卡.xlsx',JSON_DIR.'DuanZhaoGongYiKa.json',$testnum);

    }

    //生成热处理工艺卡,testnum为试号的数组
    public function generateReChuLiYiKa($testnum){
        $this->clearDir(OUT_DIR.'ReChuLiGongYiKa/');
        $this->createReChuLiGongYiKa(OUT_DIR.'ReChuLiGongYiKa/',TEMPLATE_DIR.'热处理工艺卡.xlsx',JSON_DIR.'ReChuLiGongYiKa.json',$testnum);

    }

    //生成合炉清单，testnum：试号的数组
    public function generateHeLuQingDan($testnum){
        $this->clearDir(OUT_DIR.'HeLuQingDan/');
        $this->createHeLuQingDan(OUT_DIR.'HeLuQingDan/',TEMPLATE_DIR.'合炉清单.xlsx',JSON_DIR.'WuLiaoQingDan.json',$testnum);

    }

    /*
 * 按照配置文件生成excle文件 :周转卡
 * $srcFileName：模版文件名称（路径）
 * $desFileName：生成文件名称（路径）
 * $confgfileName：配置文件名称（路径）
 * $rowNumber: 第几行--》序号
 * */
    public function createZhouZhuanKa($desFileName, $srcFileName, $confgfileName, $rowNumber)
    {
        try {
            if (!file_exists($srcFileName)) {
                dump($srcFileName . FILE_NO_EXIST);
                return $srcFileName . FILE_NO_EXIST;
            }
            $dir = iconv("UTF-8", "GBK", $desFileName);

            if (!file_exists($dir)){
                mkdir ($dir,0777,true);
//                echo '创建文件夹成功';
            } else {
//                echo '需创建的文件夹'. $desFileName.'已经存在';
            }
            $spreadsheet = IOFactory::load($srcFileName);
            $worksheet = $spreadsheet->getActiveSheet();
            $jsonFileOp = new jsonFileOp();
            $arrayData = $jsonFileOp->readJsonFile($confgfileName);
            $sourceData = $this->getDataFromInfoTableDb($rowNumber);
            foreach ($arrayData["table"] as $key => $value) {
                if ($key == "points" && is_array($value)) {
                    foreach ($value as $key => $value) {
                        switch ($value["type"]) {
                            case 0:
                                if(null == $sourceData[$value["index"]]){
                                    $worksheet->setCellValue($value["location"], "\\");
                                }else{
                                    $worksheet->setCellValue($value["location"], $sourceData[$value["index"]]);
                                }
                                break;
                            default:
                                break;
                        }

                    }
                }
            }
            if(null!=$sourceData['it_cheminum']&&""!=$sourceData['it_cheminum']&&strlen($sourceData['it_cheminum'])>2){
                $worksheet->setCellValue('A14', '材料进厂化学报告：'. $sourceData['it_cheminum'].'；材料进厂力学报告：'.$sourceData['it_mechnum'] .'；材料进厂金相报告：'.$sourceData['it_metalnum']);
            }else{
//                $worksheet->setCellValue('A14',"材料进厂化学报告：(化）字（      ）第          号；材料进厂力学报告：(力）字（       ）第         号；材料进厂金相报告：(金）字（       ）第         号");
            }
            $worksheet->setCellValue('A19', '下料质量检验单编号：' . $sourceData['it_reportnum'] . '-1');
            $worksheet->setCellValue('A24', '锻造工序产品质量检验单编号：' . $sourceData['it_reportnum'] . '-2');
            $worksheet->setCellValue('A29', '热处理工序产品质量检验单编号：' . $sourceData['it_reportnum'] . '-3');
//            $worksheet->setCellValue('A44', '热处理后化学报告：'. $sourceData['it_cheminum'].' 热处理后力学报告：'.$sourceData['it_mechnum'] );
            //通过工厂模式来写内容
            $writer = IOFactory::createWriter($spreadsheet, 'Xls');

            $writer->save($desFileName.$sourceData["it_reportnum"].'.xls');
//            $writer->save($desFileName.'周转卡'.time().$rowNumber.'.xls');
            return RETURN_SUCCESS;
        } catch (Exception $e) {
            dump($e->getMessage());
            return RETURN_FAILED;
        }

    }

    public function getDataFromInfoTableDb($rowNumber){
        //$res = Db::table("info_table")->where("it_order={$rowNumber}")->find();
        $res = Db::table("info_table")->where("it_id={$rowNumber}")->find();
        return $res;
    }

    public function getDataFromInfoTableDbByTestNum($TestNum)
    {
//        $res = Db::table("info_table")->where("it_testnum={$TestNum}")->select();

        $res = Db::query("select * from info_table where it_testnum=?",[$TestNum]);
        return $res;
    }

    public function getImageNumsFromInfoTableDbByTestNum($TestNum)
    {
        $res = Db::table("info_table")->field("it_imagenum")->where("it_testnum",$TestNum)->select();
        return $res;
    }

    public function getDataFromInfoTableDbByTestNumAndImageNums($imageNum,$TestNum)
    {
        $res = Db::query("select * from info_table where it_imagenum=? and it_testnum=?",[$imageNum,$TestNum]);
        return $res;
    }

    /*
    * 按照配置文件生成excle文件 :物料清单，根据试号列表生成多个文件
    * $srcFileName：模版文件名称（路径）
    * $desFileName：生成文件名称（路径）
    * $confgfileName：配置文件名称（路径）
    * $rowArray: 选择多个不同的试号：要生成表格的试号列表
    * */
    public function createWuLiaoQingDan($desFileName, $srcFileName, $confgfileName, $rowArray)
    {
        try {
            if (!file_exists($srcFileName)) {
                dump($srcFileName . $srcFileName . FILE_NO_EXIST);
                return null;
            }
            $dir = iconv("UTF-8", "GBK", $desFileName);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                echo '创建文件夹成功';
            } else {
                echo '需创建的文件夹' . $desFileName . '已经存在';
            }
//            $jsonFileOp = new jsonFileOp();
//            $arrayData = $jsonFileOp->readJsonFile($confgfileName);
//            dump($arrayData);
//            $startLOC[] = array();
            foreach ($rowArray as $k) {
                echo "<br/> key:".$k;
                $jsonFileOp = new jsonFileOp();
                $arrayData = $jsonFileOp->readJsonFile($confgfileName);
                //dump($arrayData);
                $spreadsheet = IOFactory::load($srcFileName);
                $worksheet = $spreadsheet->getActiveSheet();
                $rowArrayData = $this->getDataFromInfoTableDbByTestNum($k);
//                dump('$rowArrayData length:'.sizeof($rowArrayData));
//                dump($rowArrayData);
                $currentIndex = 5;
                foreach ($rowArrayData as $i => $v) {
                    $repeateCount = 0;
                    if(null != $v["it_sliplen"]){
                        $repeateCount = 2;
                    }else{
                        $repeateCount = 1;
                    }
//                    dump($repeateCount);
                    $isDuankou = false;
                    while ($repeateCount-->0){
//                        dump($repeateCount);
                        foreach ($arrayData["table"] as $key => $value) {
                            if ($key == "points" && is_array($value)) {
//                            dump($value);
                              foreach ($value as $keyIndex => $value) {
//                                dump($value['location']);
//                                dump($currentIndex);
                                  if ("规格1" == $value['description']) {
//                                    dump("规格1" . $value['location']);
                                      $worksheet->setCellValue($value['location'].$currentIndex, "φ");
//                                    $arrayData['table']['points'][$keyIndex]['location'] = ++$value['location'];
                                      continue;
                                  }
                                  if ("下料尺寸1" == $value['description']) {
                                      $worksheet->setCellValue($value['location'].$currentIndex, "×");
//                                    $arrayData['table']['points'][$keyIndex]['location'] = ++$value['location'];
                                       continue;
                                  }
                                  if ("下料尺寸2" == $value['description']) {
                                      $worksheet->setCellValue($value['location'].$currentIndex, $v["it_count"]);
//                                    $worksheet->setCellValue($value['location'].$currentIndex, "1");
//                                    $arrayData['table']['points'][$keyIndex]['location'] = ++$value['location'];
                                      continue;
                                  }
                                  if ("下料尺寸3" == $value['description']) {
                                      $worksheet->setCellValue($value['location'].$currentIndex, "根");
//                                    $worksheet->getStyle($value['location'])->getFont()->getColor()->setARGB(Color::COLOR_RED);
//                                    $arrayData['table']['points'][$keyIndex]['location'] = ++$value['location'];
                                      continue;
                                  }


                                  if ( ("下料尺寸0" == $value['description']) ){
//                                      dump($isDuankou);
                                      if ($isDuankou){
//                                          dump($v["it_sliplen"]);
                                          $worksheet->setCellValue($value['location'].$currentIndex, $v["it_sliplen"]);
                                      }else {
                                          $worksheet->setCellValue($value['location'].$currentIndex, $v[$value["index"]]);
                                      }
                                      continue;
                                  }

                                  if ( ("图号" == $value['description']) ){
                                      if ($isDuankou){
                                          continue;
                                      }
                                  }
                                  if("工件名称"== $value['description']){
                                      if ($isDuankou){
                                          $worksheet->setCellValue($value['location'].$currentIndex, "断口");
                                      }else{
                                          $worksheet->setCellValue($value['location'].$currentIndex, $v[$value["index"]]);
                                      }
                                      continue;
                                  }
                                  if ( ("重量" == $value['description']) ){
                                      $weight = 0.0;
                                      $ρ= 0.0;
                                      if(strpos(CUMATERIAL,$v["it_materialnum"])){
                                          $ρ= 8.9;
                                      }else{
                                          $ρ= 7.85;
                                      }
                                      if ($isDuankou){
                                          $weight = M_PI*pow($v["it_spec"]/2,2)*$v["it_sliplen"]*$ρ/1000000;
                                      }else{
                                          $weight = M_PI*pow($v["it_spec"]/2,2)*$v["it_quantity"]*$ρ/1000000;
                                      }
                                      $worksheet->setCellValue($value['location'].$currentIndex, strval(round($weight,1)));
                                      continue;
                                  }

                                  switch ($value["type"]) {
                                        case 0:
                                            $worksheet->setCellValue($value['location'].$currentIndex, $v[$value["index"]]);
//                                        $arrayData['table']['points'][$keyIndex]['location'] = ++$value['location'];
                                            break;
                                        case 1:
                                            break;
                                        default:
                                            break;
                                   }
                              }
                               ++$currentIndex;
                               $len = $worksheet->getHighestRow();
//                            dump($len);
                                $worksheet->insertNewRowBefore($len - 4);
                                }
                        }
                        $isDuankou = true;
                    }

                }

                //通过工厂模式来写内容
                $writer = IOFactory::createWriter($spreadsheet, 'Xls');
//                $writer->save($desFileName . '物料清单' . $v["it_testnum"] . '-' . $v["it_materialnum"] . '.xls');
                if(null == $k ){
                    $writer->save($desFileName . $rowArrayData[0]["it_routnum"] . '-' . $rowArrayData[0]["it_partnum"] . '.xls');
                }else{
                    $writer->save($desFileName .trim($k ).'.xls');
                }


            }

            return RETURN_SUCCESS;
        } catch (Exception $e) {
            dump($e->getMessage());
            return RETURN_FAILED;
        }

    }

    /*
   * 按照配置文件生成excle文件 :合炉清单，根据试号列表生成多个文件
   * $srcFileName：模版文件名称（路径)和物料清单一样
   * $desFileName：生成文件名称（路径）
   * $confgfileName：配置文件名称（路径）和物料清单一样
   * $rowArray: 选择多个不同的试号：要生成表格的试号列表
   * 多个试号生成一张合炉清单
   * */
    public function createHeLuQingDan($desFileName, $srcFileName, $confgfileName, $rowArray)
    {
        try {
            if (!file_exists($srcFileName)) {
                dump($srcFileName . $srcFileName . FILE_NO_EXIST);
                return null;
            }
            $dir = iconv("UTF-8", "GBK", $desFileName);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                echo '创建文件夹成功';
            } else {
                echo '需创建的文件夹' . $desFileName . '已经存在';
            }
            $jsonFileOp = new jsonFileOp();
            $arrayData = $jsonFileOp->readJsonFile($confgfileName);
            //dump($arrayData);
            $spreadsheet = IOFactory::load($srcFileName);
            $worksheet = $spreadsheet->getActiveSheet();
            $currentIndex = 5;
            foreach ($rowArray as $k) {
                $rowArrayData = $this->getDataFromInfoTableDbByTestNum($k);
//                dump('$rowArrayData length:'.sizeof($rowArrayData));
//                dump($rowArrayData);
                foreach ($rowArrayData as $i => $v) {
                    $repeateCount = 0;
                    if(null != $v["it_sliplen"]){
                        $repeateCount = 2;
                    }else{
                        $repeateCount = 1;
                    }
//                    dump($repeateCount);
                    $isDuankou = false;
                    while ($repeateCount-->0){
//                        dump($repeateCount);
                        foreach ($arrayData["table"] as $key => $value) {
                            if ($key == "points" && is_array($value)) {
//                            dump($value);
                                foreach ($value as $keyIndex => $value) {
//                                dump($value['location']);
//                                dump($currentIndex);
                                    if ("规格1" == $value['description']) {
//                                    dump("规格1" . $value['location']);
                                        $worksheet->setCellValue($value['location'].$currentIndex, "φ");
                                        continue;
                                    }
                                    if ("下料尺寸1" == $value['description']) {
                                        $worksheet->setCellValue($value['location'].$currentIndex, "×");
                                        continue;
                                    }
                                    if ("下料尺寸2" == $value['description']) {
                                        $worksheet->setCellValue($value['location'].$currentIndex, $v["it_count"]);
                                        continue;
                                    }
                                    if ("下料尺寸3" == $value['description']) {
                                        $worksheet->setCellValue($value['location'].$currentIndex, "根");
                                        continue;
                                    }


                                    if ( ("下料尺寸0" == $value['description']) ){
//                                      dump($isDuankou);
                                        if ($isDuankou){
//                                          dump($v["it_sliplen"]);
                                            $worksheet->setCellValue($value['location'].$currentIndex, $v["it_sliplen"]);
                                        }else {
                                            $worksheet->setCellValue($value['location'].$currentIndex, $v[$value["index"]]);
                                        }
                                        continue;
                                    }

                                    if ( ("图号" == $value['description']) ){
                                        if ($isDuankou){
                                            continue;
                                        }
                                    }
                                    if("工件名称"== $value['description']){
                                        if ($isDuankou){
                                            $worksheet->setCellValue($value['location'].$currentIndex, "断口");
                                        }else{
                                            $worksheet->setCellValue($value['location'].$currentIndex, $v[$value["index"]]);
                                        }
                                        continue;
                                    }
                                    if ( ("重量" == $value['description']) ){
                                        $weight = 0.0;
                                        $ρ= 0.0;
                                        if(strpos(CUMATERIAL,$v["it_materialnum"])){
                                            $ρ= 8.9;
                                        }else{
                                            $ρ= 7.85;
                                        }
                                        if ($isDuankou){
                                            $weight = M_PI*pow($v["it_spec"]/2,2)*$v["it_sliplen"]* $ρ/1000000;
                                        }else{
                                            $weight = M_PI*pow($v["it_spec"]/2,2)*$v["it_quantity"]* $ρ/1000000;
                                        }
                                        $worksheet->setCellValue($value['location'].$currentIndex, strval(round($weight,1)));
                                        continue;
                                    }

                                    switch ($value["type"]) {
                                        case 0:
                                            $worksheet->setCellValue($value['location'].$currentIndex, $v[$value["index"]]);
                                            break;
                                        case 1:
                                            break;
                                        default:
                                            break;
                                    }
                                }
                                ++$currentIndex;
                                $len = $worksheet->getHighestRow();
                                $worksheet->insertNewRowBefore($len - 4);
                            }
                        }
                        $isDuankou = true;
                    }
                }
            }

            //通过工厂模式来写内容
            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            if(null == $rowArray ){
                $writer->save($desFileName . $rowArrayData[0]["it_routnum"] . '-' . $rowArrayData[0]["it_partnum"] . '.xls');
            }else{
                $writer->save($desFileName .implode("-",$rowArray).'.xls');
            }
            return RETURN_SUCCESS;
        } catch (Exception $e) {
            dump($e->getMessage());
            return RETURN_FAILED;
        }

    }


    /*
      * 按照配置文件生成excle文件 :锻造工艺卡，根据试号列表生成多个文件
      * $srcFileName：模版文件名称（路径）
      * $desFileName：生成文件名称（路径）
      * $confgfileName：配置文件名称（路径）
      * $rowArray: 选择多个不同的试号：要生成表格的试号列表
      * 文件命名规则：（路线表号+件号）+图号命名
      * */
    public function createDuanZhaoGongYiKa($desFileName, $srcFileName, $confgfileName, $rowArray)
    {
        echo "<br/>  createDuanZhaoGongYiKa";
        try {
            if (!file_exists($srcFileName)) {
                dump($srcFileName . FILE_NO_EXIST);
                return $srcFileName . FILE_NO_EXIST;
            }
            $dir = iconv("UTF-8", "GBK", $desFileName);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                echo '创建文件夹成功';
            } else {
                echo '需创建的文件夹' . $desFileName . '已经存在';
            }
//            $spreadsheet = IOFactory::load($srcFileName);
//            $worksheet = $spreadsheet->getActiveSheet();
            $jsonFileOp = new jsonFileOp();
            $arrayData = $jsonFileOp->readJsonFile($confgfileName);

            $duanZhaoData = $jsonFileOp->readJsonFile(JSON_DIR . 'duanzhaokadata.json');
//            dump($duanZhaoData);
            foreach ($rowArray as $k) {
//                $rowArrayData = $this->getDataFromInfoTableDbByTestNum($k);
//                dump($rowArrayData);
                echo "<br/> k:$k";
                $imageNums = $this->getImageNumsFromInfoTableDbByTestNum($k);
                echo "<br/> imagenums:";
                dump($imageNums);
                $ImgNums = array();
                foreach ($imageNums as $imageNumIndex => $imageNumItem){
                    foreach ($imageNumItem as $field=>$value){
                        array_push($ImgNums,$value);
                    }
                }
//                dump($ImgNums);
                $ImgNumArry = array_unique($ImgNums);
//                dump($ImgNumArry);
                $rowArrayData = null;
                foreach ($ImgNumArry as $ImgNumValue){
                    dump($ImgNumValue);
                    $rowArrayData = $this->getDataFromInfoTableDbByTestNumAndImageNums($ImgNumValue,$k);
                    dump($rowArrayData);
                    $spreadsheet = IOFactory::load($srcFileName);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $luPiHao = "";
                    $reportNums = "";
                    $worksheet->setCellValue('L5', sizeof($rowArrayData));
                    $worksheet->setCellValue('N19', sizeof($rowArrayData));
                    $commonTable = new CommonTable();
                    $zuanData = $commonTable->queryZuanData($ImgNumValue);
                    //锻造尺寸图
                    $imagePath = $commonTable->queryImagePath($ImgNumValue);
                    dump($imagePath);
                    if(null != $imagePath&&file_exists($imagePath[0]["c_image_path"])){
                        $this->setImageRes($worksheet,'B18', $imagePath[0]["c_image_path"],'330','230');
                    }else{
                        $worksheet->setCellValue('B18', "数据库中没有图片数据！");
                    }

                    foreach ($rowArrayData as $i => $v) {
                        foreach ($arrayData["table"] as $key => $value) {
                            if ($key == "points" && is_array($value)) {
                                foreach ($value as $key => $value) {
                                    switch ($value["type"]) {
                                        case 0:

                                            if ("炉批号" == $value["description"]) {
                                                $luPiHao = $luPiHao . $v[$value["index"]] . ',';
                                            } else if("产品" == $value["description"]){
                                                //真实数据
//                                            $routeArray = explode('-',$v[$value["index"]]);
                                                $routeArray = explode('-',$v["it_routnum"]);
                                                //测试数据
//                                                $routeArray = explode('-',"x888-78779-98989");
//                                                dump($routeArray);
                                                if (sizeof($routeArray)>0){
                                                    $worksheet->setCellValue($value["location"],$routeArray[0]);
                                                }else{
                                                    $worksheet->setCellValue($value["location"],"\\");
                                                }
                                            }else {
                                                $worksheet->setCellValue($value["location"], $v[$value["index"]]);
                                            }
                                            break;
                                        default:
                                            break;
                                    }
                                }
                                //编号插入
//                                $worksheet->setCellValue('B2', $v["it_routnum"] . 'D.XXXX');
                            }
                        }
                        $reportNums = $reportNums.$v["it_reportnum"].";";
                    }
                    $lupiSet = array_unique(explode(',',rtrim($luPiHao,',')));
                    $luPiHao = implode(';',$lupiSet);
                    $worksheet->setCellValue('B6', $luPiHao);
                    //锻造比
                    $duanZhaoBi = $commonTable->queryForgingRatio($ImgNumValue);
                    dump($duanZhaoBi);
                    if(null == $duanZhaoBi){
                        $worksheet->setCellValue('E14', "\\");
                    }else{
                        $worksheet->setCellValue('E14', $duanZhaoBi[0]["c_forging_ratio"]);
                    }
                    //试棒方向
                    $testDirection = $commonTable->queryTbDirection($ImgNumValue);
                    dump($testDirection);
                    if(null == $testDirection){
                        $worksheet->setCellValue('B32', "\\");
                    }else{
                        $worksheet->setCellValue('B32', "热处理后将试验棒锯下，取样方向：".$testDirection[0]["c_tb_direction"]);
                    }
                    //断口尺寸
                    $duankouStr = null;
                    if("X25A"==$v["it_materialnum"]){

                        if($v["it_thickness"]<60){
                            $duankouStr = "断口尺寸:\t".$v["it_thickness"]."\t×\t90\t×\t80";
                        }elseif(61<$v["it_thickness"]&&$v["it_thickness"]<90){
                            $duankouStr = "断口尺寸:			".$v["it_thickness"]."		×	100		×	380";
                        }elseif(91<$v["it_thickness"]&&$v["it_thickness"]<120){
                            $duankouStr = "断口尺寸:			".$v["it_thickness"]."		×	120		×	380";
                        }
                    }else{
                        $duankouStr = "\\";
                    }
                    $worksheet->setCellValue('B31', $duankouStr);
                    //物料准备
                    if(null==$v["it_spec"]||$v["it_spec"]<0){
                        $worksheet->setCellValue('R5', NULL);
                        $worksheet->setCellValue('S5', NULL);
                        $worksheet->setCellValue('T5', NULL);
                        $worksheet->setCellValue('U5', NULL);
                        $worksheet->setCellValue('V5', NULL);
                        $worksheet->setCellValue('W5', NULL);
                        $worksheet->setCellValue('X5', NULL);
                        $worksheet->setCellValue('Z5', NULL);
                        $worksheet->setCellValue('AA5', NULL);
                        $worksheet->setCellValue('AB5', NULL);

                        $worksheet->setCellValue('R7', NULL);
                        $worksheet->setCellValue('S7', NULL);
                        $worksheet->setCellValue('T7', NULL);
                        $worksheet->setCellValue('U7', NULL);
                        $worksheet->setCellValue('V7', NULL);
                        $worksheet->setCellValue('W7', NULL);
                        $worksheet->setCellValue('X7', NULL);
                        $worksheet->setCellValue('Z7', NULL);
                        $worksheet->setCellValue('AA7', NULL);
                        $worksheet->setCellValue('AB7', NULL);

                        $worksheet->setCellValue('R8', NULL);
                        $worksheet->setCellValue('S8', NULL);
                        $worksheet->setCellValue('T8', NULL);
                        $worksheet->setCellValue('U8', NULL);
                        $worksheet->setCellValue('V8', NULL);
                        $worksheet->setCellValue('W8', NULL);
                        $worksheet->setCellValue('X8', NULL);
                        $worksheet->setCellValue('Z8', NULL);
                        $worksheet->setCellValue('AA8', NULL);
                        $worksheet->setCellValue('AB8', NULL);
                    }else{
                        if(null!=$v["it_spec"]&&$v["it_spec"]>0){
                            $worksheet->setCellValue('V5', $v["it_spec"]);
                        }
                        if(null!=$v["it_sliplen"]&&$v["it_sliplen"]>0){
                            $worksheet->setCellValue('V7', $v["it_sliplen"]);
                        }
                    }

                    //测试数据
//                    $worksheet->setCellValue('B16',$duanZhaoData["X25"]["装炉温度"]);
//                    $worksheet->setCellValue('E16',$duanZhaoData["X25"]["加热方法"]);
//                    $worksheet->setCellValue('H16',$duanZhaoData["X25"]["始锻温度"]);
//                    $worksheet->setCellValue('M16',$duanZhaoData["X25"]["终锻温度"]);
//                    $worksheet->setCellValue('P16',$duanZhaoData["X25"]["冷却方式"]);

                    //真实数据
                    if(array_key_exists($v['it_materialnum'],$duanZhaoData)){
                        $worksheet->setCellValue('B16',$duanZhaoData[$v["it_materialnum"]]["装炉温度"]);
                        $worksheet->setCellValue('E16',$duanZhaoData[$v["it_materialnum"]]["加热方法"]);
                        $worksheet->setCellValue('H16',$duanZhaoData[$v["it_materialnum"]]["始锻温度"]);
                        $worksheet->setCellValue('M16',$duanZhaoData[$v["it_materialnum"]]["终锻温度"]);
                        $worksheet->setCellValue('P16',$duanZhaoData[$v["it_materialnum"]]["冷却方式"]);
                    }else{
                        $noData = "\\";
                        $worksheet->setCellValue('B16',$noData);
                        $worksheet->setCellValue('E16',$noData);
                        $worksheet->setCellValue('H16',$noData);
                        $worksheet->setCellValue('M16',$noData);
                        $worksheet->setCellValue('P16',$noData);
                    }

                    //备注
                    dump($reportNums);
                    dump($zuanData);
                    if(null!=$zuanData){
                        $remarkStr = "标识：".rtrim($reportNums,';')."\n"."钻φ".$zuanData[0]["c_zuan_data"]."工艺孔";
                    }else{
                        $remarkStr = "标识：".$reportNums."\n"."无钻φ数据";
                    }

                    dump($remarkStr);
                    $worksheet->setCellValue('S35', $remarkStr);
                    //通过工厂模式来写内容
                    $writer = IOFactory::createWriter($spreadsheet, 'Xls');
                    if(null==$v["it_routnum"]){
                        $writer->save($desFileName . $v["it_partnum"] . '-' . $v["it_imagenum"] . '.xls');
                    }else{
                        $writer->save($desFileName . $v["it_routnum"] .'-' . $v["it_partnum"] . '-' . $v["it_imagenum"] . '.xls');
                    }

                }

            }

            return RETURN_SUCCESS;
        } catch (Exception $e) {
            dump($e->getMessage());
            return RETURN_FAILED;
        }

    }

    /*
   * 按照配置文件生成excle文件 :物料清单，根据试号列表生成多个文件
   * $srcFileName：模版文件名称（路径）
   * $desFileName：生成文件名称（路径）
   * $confgfileName：配置文件名称（路径）
   * $rowArray: 选择多个不同的试号：要生成表格的试号列表
   * */
    public function createReChuLiGongYiKa($desFileName, $srcFileName, $confgfileName, $rowArray)
    {
        try {
            if (!file_exists($srcFileName)) {
                dump($srcFileName . $srcFileName . FILE_NO_EXIST);
                return null;
            }

            $dir = iconv("UTF-8", "GBK", $desFileName);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                echo '创建文件夹成功';
            } else {
                echo '需创建的文件夹' . $desFileName . '已经存在';
            }
//            $spreadsheet = IOFactory::load($srcFileName);
//            $worksheet = $spreadsheet->getActiveSheet();
//            $jsonFileOp = new jsonFileOp();
//            $arrayData = $jsonFileOp->readJsonFile($confgfileName);
//
//            $reLuData = $jsonFileOp->readJsonFile(JSON_DIR . 'data.json');
//            $startLOC[] = array();
            $jsonFileOp = new jsonFileOp();
            $arrayData = $jsonFileOp->readJsonFile($confgfileName);
            $reLuData = $jsonFileOp->readJsonFile(JSON_DIR . 'data.json');
            foreach ($rowArray as $k) {
                $spreadsheet = IOFactory::load($srcFileName);
                $worksheet = $spreadsheet->getActiveSheet();
                dump($k);
                $rowArrayData = $this->getDataFromInfoTableDbByTestNum($k);
                dump($rowArrayData);
                $v = $rowArrayData[0];
                //处理依据材料牌号填充的数据
                if(array_key_exists($v['it_materialnum'],$reLuData)){
                    $data = $reLuData[$v['it_materialnum']];
                    dump($data);
                    $worksheet->setCellValue("C10", $data['技术要求']);
                    $worksheet->setCellValue("C11", $data['试验项目']);
                    //真正数据 图片显示
//                dump($data["热处理曲线图"]["图片名称"]);
//                $this->setImageRes($worksheet,'A14', "image/".$data["热处理曲线图"]["图片名称"].".png",'450','350');
                    $rechuluImage = "image/".$data["热处理曲线图"]["图片名称"].".png";
                    dump($rechuluImage);
                    if(file_exists($rechuluImage)){
                        $this->setImageRes($worksheet,'A14', $rechuluImage,'450','350');
                    }else{
                        $worksheet->setCellValue('A14',"没有找到匹配的图片数据");
                    }

                    foreach ($data["热处理曲线图"]["处理方式"] as $key => $value) {
                        if ($key == "正火") {
                            dump("正火：" . $value["保温温度"]);
                            dump("正火：" . $value["保温温度"]);
                        } elseif ($key == "淬火") {
                            dump("淬火：" . $value["保温温度"]);
                            dump("淬火：" . $value["保温温度"]);
                        } elseif ($key == "回火") {
                            dump("回火：" . $value["保温温度"]);
                            dump("回火：" . $value["保温温度"]);
                        }
                    }

                    foreach ($data["工艺规程"] as $key => $value) {
                        if ($key == "内容1") {
                            $worksheet->setCellValue("B28", $value);
                        } elseif ($key == "内容2") {
                            $worksheet->setCellValue("B29", $value);
                        } elseif ($key == "内容3") {
                            $worksheet->setCellValue("B30", $value);
                        } elseif ($key == "内容4") {
                            $worksheet->setCellValue("B31", $value);
                        }
                    }

                    foreach ($data["热处理方式"] as $key => $value) {
                        if ($key == "方式1") {
                            $worksheet->setCellValue("G11", $value);
                        } elseif ($key == "方式2") {
                            $worksheet->setCellValue("G15", $value);
                        } elseif ($key == "方式3") {
                            $worksheet->setCellValue("G23", $value);
                        }
                    }
                }else{
                    $onData = "\\";
                    $worksheet->setCellValue("C10", $onData);
                    $worksheet->setCellValue("C11", $onData);
                    $worksheet->setCellValue('A14',"没有找到匹配的图片数据");
                    $worksheet->setCellValue("B28", $onData);
                    $worksheet->setCellValue("B29", $onData);
                    $worksheet->setCellValue("B30", $onData);
                    $worksheet->setCellValue("B31", $onData);
                    $worksheet->setCellValue("G11", $onData);
                    $worksheet->setCellValue("G15", $onData);
                    $worksheet->setCellValue("G23", $onData);
                }
                $thinkness = $v['it_thickness'];
                dump($thinkness);
                if(null !=$thinkness&&$thinkness>0){
                    $worksheet->setCellValue("E13", "有效壁厚:" . $thinkness . "mm");
                }else{
                    $worksheet->setCellValue("E13", "有效壁厚:/");
                }

                foreach ($arrayData["table"] as $key => $value) {
                    if ($key == "points" && is_array($value)) {
                        foreach ($value as $keyIndex => $value) {
                            dump($value['location']);
                            if ("试棒数量" == $value['description']) {
                                dump("试棒数量" . $value['location']);
                                $worksheet->setCellValue($value['location'], sizeof($rowArrayData));
//                                $arrayData['table']['points'][$keyIndex]['location'] = ++$value['location'];
                                continue;
                            }

                            if ("简介" == $value['description']) {
                                dump("简介" . $value['location']);
                                $worksheet->setCellValue($value['location'], '详见试号为' . $v["it_testnum"] . '的物料清单');
//                                $arrayData['table']['points'][$keyIndex]['location'] = ++$value['location'];
                                continue;
                            }
                            switch ($value["type"]) {
                                case 0:
                                    $worksheet->setCellValue($value['location'], $v[$value["index"]]);
//                                    $arrayData['table']['points'][$keyIndex]['location'] = ++$value['location'];
                                    break;
                                case 1:
                                    break;
                                default:
                                    break;
                            }
                        }

                    }
                }


                //通过工厂模式来写内容
                $writer = IOFactory::createWriter($spreadsheet, 'Xls');
                $writer->save($desFileName .$v["it_testnum"] . '.xls');
            }

            return RETURN_SUCCESS;
        } catch (Exception $e) {
            dump($e->getMessage());
            return RETURN_FAILED;
        }

    }

    public function setImageRes($worksheet, $coord,$imageFilePath,$x,$y)
    {
        $drawing = new Drawing();
        $drawing->setPath($imageFilePath);
//        $drawing->setCoordinates('A14');
        $drawing->setCoordinates($coord);
        $drawing->getShadow()->setVisible(true);
        $drawing->setWorksheet($worksheet);
        $drawing->setOffsetY(5);
        $drawing->setOffsetX(15);
//        $drawing->setWidthAndHeight(450,350);
        $drawing->setWidthAndHeight($x,$y);
    }

//逐行，遍历列获取 整行数据
    public function getValueFromFile($fileName)
    {
        $rows[][] = array();
        try {
            if (!file_exists($fileName)) {
                dump($fileName . FILE_NO_EXIST);
                return null;
            }
            $spreadsheet = IOFactory::load($fileName);
            $worksheet = $spreadsheet->getActiveSheet();
            foreach ($worksheet->getRowIterator() as $key => $row) {
                dump($key);
                $cellIterator = $row->getCellIterator();   //得到所有列
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {  //遍历列
                    if (!is_null($cell)) {  //如果列不给空就得到它的坐标和计算的值
                        $rows[$key][] = $cell->getCalculatedValue();
                    }
                }
            }
            dump($rows);
            return $rows;;
        } catch (Exception $e) {
            dump($e->getMessage());
            return null;
        }
    }

    public function getRowValueFromFile($fileName, $startRowNumber)
    {
        try {
            $rows[] = array();
            if (!file_exists($fileName)) {
                dump($fileName . FILE_NO_EXIST);
                return null;
            }
            $spreadsheet = IOFactory::load($fileName);
            $worksheet = $spreadsheet->getActiveSheet();
            if ($startRowNumber > $worksheet->getHighestRow()) {
                dump('行数超出最大值');
                return null;
            }
            $cellIterator = $worksheet->getRowIterator($startRowNumber)->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach ($cellIterator as $cell) {  //遍历列
                if (!is_null($cell)) {  //如果列不给空就得到它的坐标和计算的值
                    $row[] = $cell->getCalculatedValue();
                }
            }
            dump($row);
            dump($row[0]);
            return $row;
        } catch (Exception $e) {
            dump($e->getMessage());
            return null;
        }


    }

    /*
     * 从信息材料表中获取指定行、指定引索的值
     * $fileName：信息材料表路径
     * $rowNumber：指定行
     * $index：指定行引索值
     * */
    public function getValueByLocationFromFile($fileName, $rowNumber, $index)
    {

        try {
            $rows[] = array();
            if (!file_exists($fileName)) {
                dump($fileName . FILE_NO_EXIST);
                return null;
            }
            $spreadsheet = IOFactory::load($fileName);
            $worksheet = $spreadsheet->getActiveSheet();
            if ($rowNumber > $worksheet->getHighestRow()) {
                dump('行数超出最大值');
                return null;
            }
            $cellIterator = $worksheet->getRowIterator($rowNumber)->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach ($cellIterator as $cell) {  //遍历列
                if (!is_null($cell)) {  //如果列不给空就得到它的坐标和计算的值
                    $row[] = $cell->getCalculatedValue();
                }
            }
//            dump($row);
//            dump($row[$index]);
            return $row[$index];
        } catch (Exception $e) {
            dump($e->getMessage());
            return null;
        }


    }

    public function loadSpreadsheet($filename)
    {
        $spreadsheet = null;
        if (file_exists($filename)) {
            $spreadsheet = IOFactory::load($filename);
        }
        return $spreadsheet;
    }


    //写信息表
    public function writeinfoFile($worksheet)
    {
//        echo "<br/>  writeinfoFile";
        try {
            $info = eval(INFOTABLE);
            $arrayData = DB::table('info_table')->select();
            $arrayLen = sizeof($arrayData);
            foreach ($arrayData as $rowNum=>$rowData){
//                echo "<br/> time1:".microtime();
//                $worksheet->insertNewRowBefore(intval($rowNum) + 2);
//                echo "<br/> time2:".microtime();
//                dump($rowData);

//                if (($rowNum%100)==0)
//                    Db::execute("update process_status set ps_percent=:percent where ps_id =:id ",['percent'=>(30+65*$rowNum/$arrayLen), 'id'=>1]);
                foreach ($rowData as $key => $value) {
                    if (array_key_exists($key, $info)) {
//                        echo "<br/> time3:".microtime();
                        $tmparr = DataExtra::ch2arr($info[$key]);
//                        echo "<br/> time4:".microtime();
                        $pos = $tmparr[0].($tmparr[1]+$rowNum);
//                        echo "<br/> pos:".$pos;
//                        echo "<br/> time5:".microtime();
                        $worksheet->setCellValue($pos,$value);
//                        echo "<br/> time6:".microtime();
                    }
                }
                $worksheet->setCellValue("G".(2+$rowNum), "φ");
                $worksheet->setCellValue("J".(2+$rowNum), "×");
                $worksheet->setCellValue("K".(2+$rowNum), "1");
                $worksheet->setCellValue("L".(2+$rowNum), "根");
            }
            return $arrayData;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updataFinal(){
        Db::execute("update process_status set ps_percent=:percent where ps_id =:id ",['percent'=>100, 'id'=>1]);
    }

    //extra data from string
    public function keywordExtra($inputstring, &$output)
    {
        //dump($outstr);

        //echo $inputstring."<br/>";

        //dump(EXTRASTRING);
        $keywords = eval(EXTRASTRING);
        //dump($keywords);
        //make input string to array of char
        $arr = $this->getchar2arr($inputstring);
        //travelsal the keywords array to match the input string
        foreach ($keywords as $index => $words) {
            $wordsarr = $this->getchar2arr($words);
            $wordsarrcount = 0;
            //echo "words:".$words."<br/>";
            //traversal the char array to find the start of every element
            foreach ($arr as $key => $value) {
                //echo "values".$value."<br/>";
                if ($wordsarr[$wordsarrcount] == $value) {
                    $wordsarrcount++;
                    //echo "wordsarrcount1:".$wordsarrcount."<br/>";
                } else if (($wordsarrcount != 0) & ($wordsarrcount != sizeof($wordsarr))) {
                    //echo "wordsarrcount2:".$wordsarrcount."<br/>";
                    $wordsarrcount = 0;
                }
                if (($wordsarrcount == sizeof($wordsarr))) {
                    //echo "wordsarrcount3:".$wordsarrcount."<br/>";
                    $tmpkey = $key + 1;
                    $tmparr = array();
                    while (($tmpkey != sizeof($arr)) && (strlen($arr[$tmpkey]) != 3)) {
                        array_push($tmparr, $arr[$tmpkey]);
                        //echo "arr[$tmpkey]:".$arr[$tmpkey]."<br/>";
                        $tmpkey++;
                    }

                    $output[$index] = implode("", $tmparr);

                    $arr = array_slice($arr, $tmpkey);
                    //$wordsarrcount = 0;
                    break;
                }
            }
            //dump($output);
        }
        //special operate for special output
        $this->specialOpt($output);
    }

    private function specialOpt(&$data)
    {
        //dump($data);
        $data1 = $data["规格"];
        $data2 = mb_substr($data["备料数量"], 0, -2, 'utf-8');

        $data['规格1'] = mb_substr($data1, 0, 1, 'utf-8');
        $data['规格'] = mb_substr($data1, 1, -2, 'utf-8');


        $data['备料数量1'] = '60';
        $count = strval(intval($data2) / intval($data['备料数量1']));
        //($count);
        $data['备料数量2'] = '×';
        $data['备料数量3'] = $count;
        $data['备料数量'] = '根';


        //dump($data);

    }


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

    private function char2arr($str)
    {
        echo "<br/>start";
        $length = mb_strlen($str, 'utf-8');
        echo "<br/>length : $length";
        $array = [];
        for ($i = 0; $i < $length; $i++)
            $array[] = mb_substr($str, $i, 1, 'utf-8');
        echo "<br/>end";
        return $array;
    }

    /*
     * 删除目录文件
     * $path : 需要删除路径
     */
   public function clearDir($path){
        if(is_dir($path) && (count($p = scandir($path))>2)){
            foreach ($p as $fName){
                if($fName != "." && $fName != ".."){
                    unlink($path.$fName);
                }
            }
        }
    }
}
