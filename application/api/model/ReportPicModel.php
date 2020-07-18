<?php
namespace app\api\model;
use think\Model;
class ReportPicModel extends Model
{
    protected $table = "qx_report_pic";

    //获取第一张图片或者所有图片
    public static function getPic($active_id,$num=1){
        $domain=domain().'uploads/';
        if ($num==1){ //获取第一张图片
            $res=self::where(['active_id'=>$active_id])->limit(0,1)->field('path')->order('id asc')->find();
            if ($res){
                return $domain.$res['path'];
            }else{
                return '';
            }
        }else{ //获取所有图片 返回数组
            $res=self::where(['active_id'=>$active_id])->field('path')->order('id asc')->select();
            if ($res){
                foreach ($res as $key=>$val){
                    $res[$key]['path']=$domain.$val['path'];
                }
                return $res;
            }else{
                return '';
            }
        }

    }
}