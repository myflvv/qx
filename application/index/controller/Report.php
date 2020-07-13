<?php
namespace app\index\controller;

use think\Controller;

class Report extends Controller{

    public function getIndex(){
        return $this->fetch('index');
    }
    public function getList(){

    }
}