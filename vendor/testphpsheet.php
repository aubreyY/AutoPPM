<?php
/**
 * Created by PhpStorm.
 * User: lizeming
 * Date: 2018/5/9
 * Time: 15:22
 */



require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'nihaoa !');

$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');

//header('Content-Type : application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器输出07Excel文件
////header(‘Content-Type:application/vnd.ms-excel‘);//告诉浏览器将要输出Excel03版本文件
//        header('Content-Disposition: attachment;filename="hello world.xlsx"');//告诉浏览器输出浏览器名称
//        header('Cache-Control: max-age=0');//禁止缓存
//        $writer = new Xlsx($spreadsheet);
//        $writer->save('php://output');