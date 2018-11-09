<?php
/**
 * Created by PhpStorm.
 * User: lzm
 * Date: 2018/5/20
 * Time: 20:29
 */

namespace app\index\model;


class JsonFileOp
{
    public function readJsonFile($fileName){
        // 从文件中读取数据到PHP变量
        $json_string = file_get_contents($fileName);
        // 用参数true把JSON字符串强制转成PHP数组
        return json_decode(trim($json_string,chr(239).chr(187).chr(191)), true);
    }
}