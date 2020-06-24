<?php
namespace app\index\controller;

use app\index\model\Log;
use think\Controller;
class Sys extends Controller{

    public function getIndex(){
        return $this->fetch('index');
    }

    public function getLogs(){
        return $this->fetch('logs');
    }

    public function getLogsData(){
//        $page = input('get.page',1);
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $total = Log::count();
        $res = Log::field('id,content,create_time')->limit($offset,$limit)->order('create_time desc')->select();
        $data=[];
        $no=1+intval($offset);
        foreach ($res as $val){
            $val['create_time']=date('Y-m-d H:i:s',$val['create_time']);
            $val['no']=$no;
            $data[]=$val;
            $no++;
        }
        return json(['total'=>$total,'rows'=>$data]);
    }
}