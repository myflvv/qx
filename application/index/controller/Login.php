<?php
namespace app\index\controller;
use app\index\model\Admin;
use app\index\model\Log;
use think\Controller;

class Login extends Controller{
    private $salt="wew21dcw542vb";

    public function index(){
        return $this->fetch('login');
    }

    public function login(){
        $username=input('post.username');
        $password=input('post.password');
        if (empty($username) || empty($password)){
            return json(['valid'=>false]);
        }
        $password=md5($password.$this->salt);
        $res =Admin::where(['username'=>$username,'password'=>$password])->count();
        if ($res){
            session('username',$username);
            Log::add('登录');
            return json(['valid'=>true]);
        }else{
            return json(['valid'=>false]);
        }
    }

    public function out(){
        Log::add('退出');
        session('username',null);
        return redirect('/');
    }
}