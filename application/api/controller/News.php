<?php
namespace app\api\controller;

use app\api\model\ActiveModel;
use app\api\model\NewsModel;
use app\api\model\ReportModel;
use app\index\model\PicModel;
use think\Controller;
use think\Db;


class News extends Controller{
    //首页幻灯片推荐
    public function getHomePic(){
        $res=PicModel::order('sort desc')->select();
        if ($res){
            foreach ($res as $key=>$val){
                $res[$key]['src']=domain().$val['path'];
                if ($val['type']=='news'){
                    $res[$key]['url']='/pages/index/news_detail?id='.$val['val_id'];
                    if (empty($val['title'])){
                        $m=NewsModel::where('id='.$val['val_id'])->field('title')->find();
                        $res[$key]['text']=$m['title'];
                    }else{
                        $res[$key]['text']=$val['title'];
                    }
                }
                if ($val['type']=='report'){
                    //活动ID缓存报告表ID
                    $m=ReportModel::where('active_id='.$val['val_id'])->field('id')->find();
                    $res[$key]['url']='/pages/index/info?id='.$m['id'];
                    if (empty($val['title'])){
                        $m=ActiveModel::where('id='.$val['val_id'])->field('title')->find();
                        $res[$key]['text']=$m['title'].'-报告';
                    }else{
                        $res[$key]['text']=$val['title'];
                    }
                }
                if ($val['type']=='active'){
                    $res[$key]['url']='/pages/active/detail?id='.$val['val_id'];
                    if (empty($val['title'])){
                        $m=ActiveModel::where('id='.$val['val_id'])->field('title')->find();
                        $res[$key]['text']=$m['title'];
                    }else{
                        $res[$key]['text']=$val['title'];
                    }
                }

            }
            return json(['code'=>200,'content'=>$res]);
        }else{
            return json(['code'=>200,'content'=>'']);
        }
    }

    public function getList(){
        $page=input('get.pageNum',1);
        $offset=10;
        $limit=($page-1)*$offset;
        $res=NewsModel::field('id,create_time,title,content')->order('create_time desc')->limit($limit,$offset)->select();

        foreach ($res as $key=>$val){
            $res[$key]['first_pic']=$this->getpic($val['content']);
            $res[$key]['create_time_format']=date('Y-m-d',$val['create_time']);
        }
        return json(['code'=>200,'content'=>$res]);
    }

    public function getDetail(){
        $id=input('get.id',0);
        if (empty($id)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $res=NewsModel::where(['id'=>$id])->find();
        if ($res){
         $res['create_time_format']=date('Y-m-d',$res['create_time']);
         $path=domain();
         $res['content']=preg_replace("/(<img .*?src=\")(.*?)(\".*?>)/is","\${1}$path\${2}\${3}",$res['content']);
        }
        return json(['code'=>200,'content'=>$res]);
    }

    //获取内容第一张图片
    private function getpic($str){
        preg_match_all("/<img.*>/isU",$str,$ereg);//正则表达式把图片的整个都获取出来了
        if (!empty($ereg[0])){
            $img=$ereg[0][0];//图片
            $p="#src=('|\")(.*)('|\")#isU";//正则表达式
            preg_match_all ($p, $img, $img1);
            $img_path =$img1[2][0];//获取第一张图片路径
            return domain().$img_path;
        }else{
            return '';
        }

    }
}