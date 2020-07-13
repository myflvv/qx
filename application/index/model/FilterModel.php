<?php
namespace app\index\model;
use think\Model;
class FilterModel extends Model
{
    protected $table = "qx_filter";

    //判断是否存在过滤字符串
    public static function chkFilter($content){
        $res=self::where(['id'=>1])->field('keywords')->find();
        if (empty($res['keywords'])){
            return ['status'=>true];
        }
        $keyArr=explode(',',$res['keywords']);
        for ($i=0;$i<count($keyArr);$i++){
            if (substr_count($content,$keyArr[$i])>0){ //如果出现次数大于0
                return ['status'=>false,'key'=>$keyArr[$i]];//返回出现的关键字
            }
        }
        return ['status'=>true];
    }
}