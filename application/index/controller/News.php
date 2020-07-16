<?php
namespace app\index\controller;

use app\index\model\Admin;
use app\index\model\NewsModel;
use think\Controller;

class News extends Controller{

    public function getIndex(){

        return $this->fetch('index');
    }

    public function getList(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $total=NewsModel::count();
        $res=NewsModel::limit($offset,$limit)->order('create_time desc')->select();
        if ($res){
            $no=1+intval($offset);
            foreach ($res as $key=>$val){
                $res[$key]['create_time_format']=date('Y-m-d H:i:s',$val['create_time']);
                $res[$key]['admin_name']=Admin::getAdminNameById($val['admin_id']);
                $res[$key]['no']=$no;
                $no++;
            }
        }
        return json(['total'=>$total,'rows'=>$res]);
    }

    public function getAdd(){
        return $this->fetch('add');
    }

    //上传缩略图片
    public function postUpload(){
        $id=input('post.id',0);

        $file = request()->file('myfile');
        if (!empty($file)){
            $info = $file->move( './uploads');
            if($info){
                return json(['code'=>200,'data'=>$info->getSaveName()]);
            }else{
                return json(['code'=>420,'msg'=>$file->getError()]);
            }
        }else{//上传图片为空也返回200
            return json(['code'=>200]);
        }

    }
}