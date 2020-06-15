<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Team as mTeam;
class Team extends Controller{

    public function getType(){
        $m= new mTeam();
        $data=$m->typeData();
        $this->assign('data',$data);
        return $this->fetch('type');
    }
    public function getIndex(){

        return $this->fetch('index');
    }

    public function getData(){
        $m = new \app\index\model\Team();
        dump($m->listData(0));
//        return json($m->listData(0));
    }

}