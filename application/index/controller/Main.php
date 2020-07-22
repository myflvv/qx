<?php
namespace app\index\controller;

use app\index\model\PicModel;
use think\Controller;
class Main extends Controller{

    public function getIndex(){
        return $this->fetch('index');
    }


    public function getPicList(){

    }
}