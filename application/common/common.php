<?php
/**
 * Created by PhpStorm.
 * User: techgroup
 * Date: 2018/5/18
 * Time: 14:13
 */
namespace app\index\Controller;

define('I_FILE0','自制件验收项目清单.xlsx');
define('I_FILE1','材质证书 化学 力学 金相.xlsx');
define('I_FILE2','路线表号件号.xlsx');
define('M_FILE','材料信息表.xlsx');


define('JSON_DIR',APP_PATH.'common/tablesConfig/');
define('TEMPLATE_DIR',APP_PATH.'common/templateFiles/');
//define('OUT_DIR',APP_PATH.'common/out/');
//define('OUT_DIR','out/');
define('INPUT_DIR',__DIR__.'/../../public/files/in/');
define('OUT_DIR', __DIR__.'/../../public/files/out/');
define('PUB_DIR', __DIR__.'/../../public/');

//定义输入文件的属性
define('FILEATTR',"return array(
    
    )
");


define('INPUTFILES',"return array(
    '自制件验收项目清单.xlsx'=>array(
            'multiline'=>'true'
    ),
    '路线表号件号.xlsx'=>array(
            'multiline'=>'false'
    ),
    '材质证书 化学 力学 金相.xlsx'=>array(
            'multiline'=>'false'
    )
);");

define('FILES2READ', "return array('FILE0', 'FILE1', FILE2)");
//输入三表
define('FILE', "return array(
    '自制件验收项目清单.xlsx'=>array(
        '报验号'=>'A7',
        '图号'=>'B7',
        '工件名称'=>'C7',
        '材料牌号'=>'D7',
        'str1'=>'K7'
        ),
    '路线表号件号.xlsx'=>array(
        'type1'=>'A6'
    ),
    '力化金.xlsx'=>array(
        'type1'=>'B3'
    )
);");
//物料清单的关键字
define('EXTRASTRING', "return array(
        '备料数量'=>'毛坯：',
        '断口长度'=>'断口：',
        '炉号'=>'炉批号：',
        '试号'=>'试号：',
        '报验号'=>'标识：'
);");
//材料信息表
define('INFO', "return array(
    '序号'=>'A2',
    '路线表号'=>'B2',
    '件号'=>'C2',
    '图号'=>'D2',
    '工件名称'=>'E2',
    '材料牌号'=>'F2',
    '规格1'=>'G2',
    '规格'=>'H2',
    '备料数量'=>'I2',
    '备料数量1'=>'J2',
    '备料数量2'=>'K2',
    '备料数量3'=>'L2',
    '备料重'=>'M2',
    '炉号'=>'N2',
    '报验号'=>'O2',
    '报验单号'=>'P2',
    '试号'=>'Q2',
    '断口长度'=>'T2',
    '质量证书'=>'U2',
    '材质证明单'=>'V2',
    '化学报告'=>'W2',
    '力学报告'=>'X2',
    '金相报告'=>'Y2'
);");

//材料信息表
define('STOCK', "return array(
    '序号'=>'A2',
    '路线表号'=>'B2',
    '件号'=>'C2',
    '图号'=>'D2',
    '工件名称'=>'E2',
    '材料牌号'=>'F2',
    '规格1'=>'G2',
    '规格'=>'H2',
    '备料数量'=>'I2',
    '备料数量1'=>'J2',
    '备料数量2'=>'K2',
    '备料数量3'=>'L2',
    '备料重'=>'M2',
    '炉号'=>'N2',
    '报验号'=>'O2',
    '报验单号'=>'P2',
    '试号'=>'Q2',
    '断口长度'=>'T2',
    '质量证书'=>'U2',
    '材质证明单'=>'V2',
    '化学报告'=>'W2',
    '力学报告'=>'X2',
    '金相报告'=>'Y2'
);");

//材料信息表
define('MYSQLREFLECT', "return array(
    '序号'=>'it_order',
    '路线表号'=>'it_routnum',
    '件号'=>'it_partnum',
    '图号'=>'it_imagenum',
    '工件名称'=>'it_partname',
    '材料牌号'=>'it_materialnum',
    '规格'=>'it_spec',
    '备料数量'=>'it_quantity',
    '备料重'=>'it_weight',
    '炉号'=>'it_batchnum',
    '报验号'=>'it_reportnum',
    '报验单号'=>'it_reportsheetnum',
    '试号'=>'it_testnum',
    '断口长度'=>'it_sliplen',
    '质量证书'=>'it_quaprovenum',
    '材质证明单'=>'it_metaprovenum',
    '化学报告'=>'it_cheminum',
    '力学报告'=>'it_mechnum',
    '金相报告'=>'it_metalnum'
);");
//材料信息表
define('INFOTABLE', "return array(
    'it_order'=>'A2',
    'it_routnum'=>'B2',
    'it_partnum'=>'C2',
    'it_imagenum'=>'D2',
    'it_partname'=>'E2',
    'it_materialnum'=>'F2',
    'it_spec'=>'H2',
    'it_quantity'=>'I2',
    'it_count'=>'K2',
    'it_weight'=>'M2',
    'it_batchnum'=>'N2',
    'it_reportnum'=>'O2',
    'it_reportsheetnum'=>'P2',
    'it_testnum'=>'Q2',
    'it_sliplen'=>'T2',
    'it_quaprovenum'=>'U2',
    'it_metaprovenum'=>'V2',
    'it_cheminum'=>'W2',
    'it_mechnum'=>'X2',
    'it_metalnum'=>'Y2'
);");
define('INDEX', "return array(
    '序号'=>'0',
    '路线表号'=>'1',
    '件号'=>'2',
    '图号'=>'3',
    '工件名称'=>'4',
    '材料牌号'=>'5',
    '规格'=>'7',
    '备料数量型号'=>'8',
    '备料数量个数'=>'10',
    '备料重'=>'12',
    '炉号'=>'13',
    '报验号'=>'14',
    '报验单号'=>'15',
    '试号'=>'16',
    '断口长度'=>'19',
    '质量证书'=>'20',
    '材质证明单'=>'21',
    '化学报告'=>'22',
    '力学报告'=>'23',
    '金相报告'=>'24'
);");

//define('EXTRASTRING', "return array(
//        'type5'=>array('零件由','的'),
//        'type6'=>array('mm的','棒料'),
//        'type7'=>array('，需','，含'),
//        'type8'=>array('断口试样','。'),
//        'type9'=>array('批号为','。 3、'),
//        'type10'=>array('试号为:','。')
//);");

define('CUMATERIAL', 'HPb59-1,H62,HMn58-2,QAL9-2,QAL9-4,HSi80-3');




define('O_FILE0','材料信息表.xlsx');
define('O_FILE1','周转卡.xlsx');
define('O_FILE2','合炉清单.xlsx');
define('O_FILE3','锻造工艺卡.xlsx');
define('O_FILE4','热处理工艺卡.xlsx');
define('O_FILE5','物料清单.xlsx');

