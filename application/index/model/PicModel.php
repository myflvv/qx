<?php
namespace app\index\model;
use think\Model;
class PicModel extends Model{
    protected $table="qx_pic";

    //判断是否已经推荐
    public static function getIsRecommend($type,$id){
        $res=self::where(['type'=>$type,'val_id'=>$id])->count();
        if ($res){
            return 1;
        }else{
            return 0;
        }
    }
}