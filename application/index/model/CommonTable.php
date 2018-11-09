<?php
/**
 * Created by PhpStorm.
 * User: lzm
 * Date: 2018/7/10
 * Time: 13:58
 */

namespace app\index\model;


use think\Model;


class CommonTable extends Model
{
    protected function initialize(){
        parent::initialize();
    }
    public function test(){
        dump($this);
        dump($this->data());
    }
    //admin主界面添加model
    public function addCommon($imageNum,$forgingRatio,$direction,$zuanData,$imagePath){
        if(null != $imageNum){
            $this->save([
               "c_image_num"=> $imageNum,
                "c_forging_ratio"=> $forgingRatio,
                "c_tb_direction"=> $direction,
                "c_zuan_data"=> $zuanData,
                "c_image_path"=> $imagePath,
            ]);
        }
    }
    //admin主界面填充model
    public function queryCommon(){
        return $this->query("select *from common_table where 1=1");
    }

    public function queryForgingRatio($ImageNum){
        return $this->query("select c_forging_ratio from common_table where c_image_num=?",[$ImageNum]);
    }

    public function queryTbDirection($ImageNum){
        return $this->query("select c_tb_direction from common_table where c_image_num=?",[$ImageNum]);
    }

    public function queryZuanData($ImageNum){
        return $this->query("select c_zuan_data from common_table where c_image_num=?",[$ImageNum]);
    }

    public function queryImagePath($ImageNum){
        return $this->query("select c_image_path from common_table where c_image_num=?",[$ImageNum]);
    }

    /**
     * @function ：删除一行数据
     * @param $ImageNum：图号
     * @return int 返回数据：>0:成功 or 失败
     */
    public function delectOneRowData($ImageNum){
        $delectImagePath = $this->field("c_image_path")->where('c_image_num',$ImageNum)->find();
        dump($delectImagePath);
        if(null !=$delectImagePath){
            $imagePath = $delectImagePath->getData();
            dump($imagePath);
            if(null!=$imagePath["c_image_path"]&&file_exists($imagePath["c_image_path"])){
                unlink($imagePath["c_image_path"]);
            }
        }

        return  $this->where('c_image_num',$ImageNum)->delete();
    }

    /**
     * @function: 更新一行数据
     * @param $ImageNum: 图号
     * @param $valueArray ：更新的数据数组
     * @return int：返回数据 -1：更新失败，1：更新成功
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function updateOneRowData($ImageNum,$valueArray){
        $data = $this->where('c_image_num',$ImageNum)->find()->getData();
        if(null!=$data&&null!=$valueArray){
            foreach ($valueArray as $key=>$value){
                if("cForgingRatio"==$key&&null!=$value){
                    $this->where('c_image_num',$ImageNum)->update([
                        "c_forging_ratio"=> $value
                    ]);
                }elseif("cTbDirection"==$key&&null!=$value){
                    $this->where('c_image_num',$ImageNum)->update([
                        "c_tb_direction"=> $value
                    ]);
                }elseif("cZuanData"==$key&&null!=$value){
                    $this->where('c_image_num',$ImageNum)->update([
                        "c_zuan_data"=> $value
                    ]);
                }elseif("cImagePath"==$key&&null!=$value){
                    $this->where('c_image_num',$ImageNum)->update([
                        "c_image_path"=> $value
                    ]);
                }
            }
            return 1;
        }
        return -1;
    }
}