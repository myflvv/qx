<?php
namespace app\index\controller;

use think\Controller;
class Main extends Controller{

    public function getIndex(){
        return $this->fetch('index');
    }
}