<?php
namespace app\index\model;
use think\Model;
class Admin extends Model{
    protected $table="qx_admin";

    //根据ID获取管理员名称
    public static function  getAdminNameById($id){
        $res=self::where(['id'=>$id])->field('username')->find();
        if ($res){
            return $res['username'];
        }else{
            return '--';
        }
    }
}