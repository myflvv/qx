<?php
namespace app\index\controller;

use app\index\model\Admin;
use app\index\model\Log;
use app\index\model\NewsModel;
use app\index\model\PicModel;
use think\Controller;

class News extends Controller{

    public function getIndex(){

        return $this->fetch('index');
    }

    public function getList(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $key=input('get.search','');
        $where='';
        if (!empty($key)){
            $where .= " title like '%$key%' ";
        }
        $total=NewsModel::where($where)->count();
        $res=NewsModel::where($where)->limit($offset,$limit)->order('create_time desc')->select();
        if ($res){
            $no=1+intval($offset);
            foreach ($res as $key=>$val){
                $res[$key]['create_time_format']=date('Y-m-d H:i:s',$val['create_time']);
                $res[$key]['admin_name']=Admin::getAdminNameById($val['admin_id']);
                $res[$key]['no']=$no;
                //是否已被推荐,1推荐 0未推荐
                $res[$key]['is_recommend']=PicModel::getIsRecommend('news',$val['id']);
                $no++;
            }
        }
        return json(['total'=>$total,'rows'=>$res]);
    }

    public function getAdd(){
        $id=input('get.id',0);
        if ($id==0){
            $title='';
            $content='';
            $id=0;
        }else{
            $id=intval($id);
            $res=NewsModel::where(['id'=>$id])->find();
            if ($res){
                $title=$res['title'];
                $content=$res['content'];
            }else{
                $title='';
                $content='';
                $id=0;
            }
        }
        $this->assign('id',$id);
        $this->assign('title',$title);
        $this->assign('content',$content);
        return $this->fetch('add');
    }


    public function postDel(){
        $id=input('post.id',0);
        $title=input('post.name','');
        if (empty($id)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        Log::add(session('username').'删除新闻['.$title.']');
        NewsModel::destroy($id);
        return json(['code'=>200]);
    }

    public function postSave(){
        $params=input('post.');
        if (empty($params['id'])){ //添加
            $data=[
                'title'=>$params['title'],
                'content'=>$params['content_textarea'],
                'create_time'=>time(),
                'admin_id'=>session('admin_id')
            ];
            Log::add(session('username').'添加新闻['.$params['title'].']');
            NewsModel::create($data);
        }else{//修改
            $data=[
                'title'=>$params['title'],
                'content'=>$params['content_textarea'],
                'admin_id'=>session('admin_id')
            ];
            Log::add(session('username').'修改新闻['.$params['title'].']');
            NewsModel::where(['id'=>$params['id']])->update($data);
        }

        return json(['code'=>200]);
    }
    //上传编辑器内图片
    public function postTextUpload(){
        $file = request()->file('file');
        if (!empty($file)){
            $info = $file->move( './uploads');
            if($info){
                $path='/uploads/'.$info->getSaveName();
                return json(['code'=>200,'data'=>$path]);
            }else{
                return json(['code'=>420,'msg'=>$file->getError()]);
            }
        }else{//上传图片为空也返回200
            return json(['code'=>200]);
        }
    }

    //上传缩略图片
//    public function postUpload(){
//        $id=input('post.id',0);
//
//        $file = request()->file('myfile');
//        if (!empty($file)){
//            $info = $file->move( './uploads');
//            if($info){
//                return json(['code'=>200,'data'=>$info->getSaveName()]);
//            }else{
//                return json(['code'=>420,'msg'=>$file->getError()]);
//            }
//        }else{//上传图片为空也返回200
//            return json(['code'=>200]);
//        }
//
//    }
}