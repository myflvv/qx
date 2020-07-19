<?php
namespace app\api\controller;

use app\api\model\NewsModel;
use think\Controller;


class News extends Controller{

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