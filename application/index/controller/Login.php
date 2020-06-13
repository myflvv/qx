<?php
namespace app\index\controller;
use app\index\model\Admin;
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
            session('user',$username);
            return json(['valid'=>true]);
        }else{
            return json(['valid'=>false]);
        }
    }
}