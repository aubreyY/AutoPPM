<?php
/**
 * Created by PhpStorm.
 * User: lzm
 * Date: 2018/5/20
 * Time: 20:39
 */

namespace app\index\controller;
use app\index\model\CommonTable;
use think\Controller;
use think\Request;
use app\index\model\ExcelFileOp as excelFileOp;
use app\index\model\JsonFileOp as jsonFileOp;

use think\Db;

use app\index\model\InfoTable;

require dirname(__FILE__).'/../../common/common.php';

/* 所有api测试*/
class Test extends controller
{
    public function testReadJsonFile(){
        $jsonFileOp = new jsonFileOp();
        dump($jsonFileOp->readJsonFile());
    }
// 生成表格eg：周转卡
    public function testCreateZhouZhuanKa(){
        $excelFileOp = new excelFileOp();
        $excelFileOp->createZhouZhuanKa(OUT_DIR.'ZhouZhuanKa/',TEMPLATE_DIR.'周转卡.xlsx',JSON_DIR.'ZhouZhuanKa.json',2);
    }

    // 生成表格eg：物料清单
    public function testCreateWuLiaoQingDan(){
        $data = ["D40043","D40044"];//要生成表格的试号列表
//        $data = ["111111"];//要生成表格的试号列表
        $excelFileOp = new excelFileOp();
        $excelFileOp->createWuLiaoQingDan(OUT_DIR.'WuLiaoQingDan/',TEMPLATE_DIR.'物料清单.xlsx',JSON_DIR.'WuLiaoQingDan.json',$data);
    }

    // 生成表格eg：合炉清单，模板和物料清单一样
    public function testCreateHeLuQingDan(){
        $data = ["D40043","D40044"];//要生成表格的试号列表
        $excelFileOp = new excelFileOp();
        $excelFileOp->createHeLuQingDan(OUT_DIR.'HeLuQingDan/',TEMPLATE_DIR.'合炉清单.xlsx',JSON_DIR.'WuLiaoQingDan.json',$data);
    }

    //生成表格eg:锻造工艺卡

    public function testCreateDuanZhaoGongYiKa(){
        $data = ["D40043"];//要生成表格的试号列表
        $excelFileOp = new excelFileOp();
        $excelFileOp->createDuanZhaoGongYiKa(OUT_DIR.'DuanZhaoGongYiKa/',TEMPLATE_DIR.'锻造工艺卡.xlsx',JSON_DIR.'DuanZhaoGongYiKa.json',$data);
    }

    //生成表格eg:热处理工艺卡

    public function testCreateReChuLiGongYiKa(){
        $data = ["2222222"];//要生成表格的试号列表
        $excelFileOp = new excelFileOp();
        $excelFileOp->createReChuLiGongYiKa(OUT_DIR.'ReChuLiGongYiKa/',TEMPLATE_DIR.'热处理工艺卡.xlsx',JSON_DIR.'ReChuLiGongYiKa.json',$data);
    }

//获取所有表格的值
    public function  testGetValueFromFile(){
        $getvalue = new excelFileOp();
        $getvalue->getValueFromFile('fileInfoTable.xlsx');
    }
//获取一行的值
    public function  testGetRowValueFromFile(){
        $getvalue = new excelFileOp();
        $getvalue->getRowValueFromFile('fileInfoTable.xlsx',3);
    }

    //获取指定单元格的值
    public function  testGetValueByLocationFromFile(){
        $getvalue = new excelFileOp();
        $getvalue->getValueByLocationFromFile('fileInfoTable.xlsx',3,5);
    }
    //文件上传页面
    public function add()
    {
        return $this->fetch();
    }
    //上传多个文件
    public function uploads(Request $request)
    {
        //接收用户上传的数据
        $files = $request->file('file');
        dump($files);
        if (array_key_exists(0)) {
            if ($info = $files[0]->move(INPUT_DIR, constant("I_FILE0"))) {
                dump($info->getsaveName());
            }
        }
        if (array_key_exists(1)) {
            if ($info = $files[1]->move(INPUT_DIR, constant("I_FILE1"))) {
                dump($info->getsaveName());
            }
        }
        if (array_key_exists(2)) {
            if ($info = $files[2]->move(INPUT_DIR, constant("I_FILE2"))) {
                dump($info->getsaveName());
            }
        }
    }

    public function testMysql (){
        $db = new Db();
//        dump($db::connect());
        $res = $db::table("info_table")->insert([
            "it_order"=>"10",
            "it_routnum"=>"7",
            "it_partnum"=>"7",
            "it_imagenum"=>"7",
            "it_partname"=>"35",
            "it_materialnum"=>"25",
            "it_spec"=>"47",
            "it_quantity"=>"48",
            "it_weight"=>"49",
            "it_batchnum"=>"10",
            "it_reportnum"=>"11",
            "it_reportsheetnum"=>"12",
            "it_testnum"=>"25",
            "it_thickness"=>"14",
            "it_sliplen"=>"15",
            "it_quaprovenum"=>"16",
            "it_metaprovenum"=>"17",
            "it_cheminum"=>"18",
            "it_mechnum"=>"19",
            "it_metalnum"=>"20"
        ]);
        dump($res);

        dump($db::table("info_table")->where("1=1")->select());

    }

    public function testInfoTable(){
//        $infoTable = new InfoTable();
//        $infoTable->get
        $res  = InfoTable::get(8);
        dump($res);
        dump($res->getdata("it_materialnum"));
    }

    public function testGetRowDATA(){
        $infotable =  new excelFileOp();
        $infotable->getDataFromDb("info_table",2);

    }
    //查询锻造比测试
    public function testCommonTable(){
        $commonTable = new CommonTable();
        $commonTable->test();
    }
    //插入一行数据测试
    public function testCommonTableAdd(){
        $commonTable = new CommonTable();
        $commonTable->addCommon('test','3:1','横向','200','image/test.png');
    }
    //查询所有数据测试
    public function testQueryCommon(){
        $commonTable = new CommonTable();
        $result =  $commonTable->queryCommon();
        dump($result);
    }
    //查询锻造比测试
    public function testQueryForgingRatio(){
    $commonTable = new CommonTable();
    $result =  $commonTable->queryForgingRatio("test");
    dump($result);
    }
    //删除数据测试
    public function testdelectOneRowData(){
    $commonTable = new CommonTable();
    $result =  $commonTable->delectOneRowData("test");
    dump($result);
    }
    //更新数据测试
    public function testUpdateOneRowData(){
        $commonTable = new CommonTable();
        $value = [
            "cForgingRatio" =>"4:1",
            "cTbDirection" =>"横向，纵向",
            "cZuanData" =>300,
            "cImagePath" =>"image/test1.png"
        ];
        $result =  $commonTable->updateOneRowData("test",$value);
        dump($result);
    }

}