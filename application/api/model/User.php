<?php
namespace app\api\model;
use think\Model;
class User extends Model
{
    protected $table = "qx_user";

    //根据openid获取user id
    public static function getUserId($openid){
        $res=self::where(['openid'=>$openid])->field('id')->find();
        if ($res){
            return $res['id'];
        }else{
            return '';
        }
    }

    //根据人员服务时长排名
    public static function ranking($duration){
        $res=self::field('duration')->order('duration desc')->select();
        foreach ($res as $key=>$val){
            if ($val['duration']==$duration){
                return $key+1;
            }
        }
    }
}