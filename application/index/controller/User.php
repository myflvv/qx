<?php
namespace app\index\controller;

use think\Controller;
class User extends Controller{

    public function getIndex(){
        return $this->fetch('index');
    }

    public function getListData(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $total = \app\index\model\User::count();
        $res = \app\index\model\User::limit($offset,$limit)->order('create_time desc')->select();
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