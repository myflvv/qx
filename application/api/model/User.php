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
}