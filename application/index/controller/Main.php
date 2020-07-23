<?php
namespace app\index\controller;

use app\index\model\ActiveModel;
use app\index\model\Log;
use app\index\model\NewsModel;
use app\index\model\PicModel;
use think\Controller;
class Main extends Controller{

    public function getIndex(){
        return $this->fetch('index');
    }


    public function getPicList(){
        $res=PicModel::order('sort desc')->select();
        if ($res){
            $i=1;
            foreach ($res as $key=>$val){
                if ($val['type']=='news'){
                    if (empty($val['title'])){
                        $newsM=NewsModel::where(['id'=>$val['val_id']])->field('title')->find();
                        $res[$key]['title']=$newsM['title'];
                    }else{
                        $res[$key]['title']=$val['title'];
                    }
                    $res[$key]['type_format']='新闻资讯';
                }
                if ($val['type']=='active'){
                    if (empty($val['title'])){
                        $newsM=ActiveModel::where(['id'=>$val['val_id']])->field('title')->find();
                        $res[$key]['title']=$newsM['title'];
                    }else{
                        $res[$key]['title']=$val['title'];
                    }
                    $res[$key]['type_format']='志愿活动';
                }
                if ($val['type']=='report'){
                    if (empty($val['title'])){
                        $newsM=ActiveModel::where(['id'=>$val['val_id']])->field('title')->find();
                        $res[$key]['title']=$newsM['title'].'-报告';
                    }else{
                        $res[$key]['title']=$val['title'];
                    }
                    $res[$key]['type_format']='活动报告';
                }

                $res[$key]['modify_time_format']=date('Y-m-d H:i:s',$val['modify_time']);
                $res[$key]['no']=$i;
                $i++;
            }
            return json(['total'=>0,'rows'=>$res]);
        }else{ //没有信息返回空
            return json(['total'=>0,'rows'=>'']);
        }
    }

    //上传推荐图片
    public function postUpload(){
        $file = request()->file('homepicfile');
        if (!empty($file)){
            $info = $file->move( './uploads');
            if($info){
                $path='/uploads/'.$info->getSaveName();
                session('up_pic',$path);
                return json(['code'=>200,'data'=>$path]);
            }else{
                return json(['code'=>420,'msg'=>$file->getError()]);
            }
        }else{//上传图片为空也返回200
            return json(['code'=>200]);
        }
    }

    //推荐保存
    public function postRecommendSave(){
        $path=session('up_pic');
        $recommend_title=input('post.recommend_title');
        $recommend_old_title=input('post.recommend_old_title');
        $recommend_id=input('post.recommend_id');
        $recommend_type=input('post.recommend_type');
        $sort=input('post.sort',0);
        if ($recommend_title!=$recommend_old_title){ //如果修改过title则保存，否则title等于空
            $title=$recommend_title;
        }else{
            $title='';
        }
        $data=[
            'title'=>$title,
            'path'=>$path,
            'modify_time'=>time(),
            'type'=>$recommend_type,
            'val_id'=>$recommend_id,
            'sort'=>$sort
        ];
        Log::add('AdminID'.session('admin_id')."推荐 首页幻灯片[".$title."]");
        PicModel::create($data);
        return json(['code'=>200,'data'=>'success']);
    }
    //取消推荐
    public function postRecommendCancel(){
        $id=input('post.id',0);
        $type=input('post.type','');
        $title=input('post.title','');
        Log::add('AdminID'.session('admin_id')."删除 首页幻灯片[".$title."]");
        $res=PicModel::where(['val_id'=>$id,'type'=>$type])->delete();
        return json(['code'=>200,'data'=>$res]);
    }
}

