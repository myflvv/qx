<?php
namespace app\index\controller;
use app\index\model\Admin;
use app\index\model\Log;
use think\Controller;

class Login extends Controller{

    public function index(){
        return $this->fetch('login');
    }

    public function login(){
        $username=input('post.username');
        $password=input('post.password');
        if (empty($username) || empty($password)){
            return json(['valid'=>false]);
        }
        $password=md5_en($password);
        $res =Admin::where(['username'=>$username,'password'=>$password])->find();
        if ($res){
            session('username',$username);
            session('admin_id',$res['id']);
            Log::add('登录');
            return json(['valid'=>true]);
        }else{
            return json(['valid'=>false]);
        }
    }

    public function out(){
        Log::add('退出');
        session('username',null);
        session('admin_id',null);
        return redirect('/');
    }
}