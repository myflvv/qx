<?php
namespace app\api\controller;

use app\api\model\AdminModel;
use think\Controller;
use think\Db;

class Admin extends Controller{

    public function postLogin(){
        $username=input('post.data.username','');
        $password=input('post.data.password','');
        if (empty($username) || empty($password)){
            return json(['code'=>420,'msg'=>'用户名密码不能为空']);
        }
//        $res=AdminModel::where(['username'=>$username,'password'=>md5_en($password),'level'=>3])->field('id,level,team_id,username')->find();
        $res=Db::query("select admin.id,admin.level,admin.team_id,admin.username,team.name from qx_admin admin left join qx_team team on admin.team_id=team.id where admin.username='".$username."' and password='".md5_en($password)."' and admin.level=3 ");
        if ($res){
            return json(['code'=>200,'content'=>$res[0]]);
        }else{
            return json(['code'=>420,'msg'=>'用户名或密码错误']);
        }
    }

    //服务类别
    public function getServiceType(){
        $data=[
            ['id'=>1,'text'=>'text1'],
            ['id'=>2,'text'=>'text2'],
            ['id'=>3,'text'=>'text3'],
            ['id'=>4,'text'=>'text4'],
        ];
        return json(['code'=>200,'content'=>$data]);
    }

    //服务时长
    public function getServiceTime(){
        $data=[
            ['text'=>'1小时'],
            ['text'=>'1.5小时'],
            ['text'=>'2小时'],
            ['text'=>'2.5小时'],
        ];
        return json(['code'=>200,'content'=>$data]);
    }
}