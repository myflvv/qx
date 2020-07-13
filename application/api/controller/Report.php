<?php
namespace app\api\controller;


use app\api\model\FilterModel;
use app\api\model\ReportModel;
use think\Controller;

class Report extends Controller{

    //添加 修改保存
    public function postSave(){
        $params=input('post.');
        $id=input('post.id',0);
        $active_id=input('post.active_id',0);
        $filter_info=FilterModel::chkFilter($params['info']);
        if (!$filter_info['status']){
            return json(['code'=>420,'msg'=>"内容含有非法关键字[".$filter_info['key']."]"]);
        }
        if ($id==0){ //添加
            ReportModel::create([
                'active_id'=>$active_id,
                'pic'=>$params['pic'],
                'info'=>$params['info'],
                'create_time'=>time(),
                'admin_id'=>$params['admin_id'],
                'update_num'=>3 //默认三次修改机会
            ]);
        }else{//更新
            //验证修改次数
            $res=ReportModel::where(['id'=>$id])->field('update_num')->find();
            if ($res['update_num']<=0){
                return json(['code'=>420,'msg'=>"已超过修改次数"]);
            }
            ReportModel::where(['id'=>$id])->update([
                'pic'=>$params['pic'],
                'info'=>$params['info'],
                'update_time'=>time(),
                'update_num'=>$res['update_num']-1
            ]);
        }
        return json(['code'=>200]);
    }
}