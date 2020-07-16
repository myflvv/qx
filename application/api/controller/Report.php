<?php
namespace app\api\controller;


use app\api\model\FilterModel;
use app\api\model\ReportModel;
use app\api\model\ReportPicModel;
use app\index\model\Duration;
use think\Controller;
use think\Db;

class Report extends Controller{

    //添加 修改保存
    public function postSave(){
        $params=input('post.data');
        $report_id=input('post.report_id',0);
        $active_id=input('post.active_id',0);
        $admin_id=input('post.admin_id',0);

        $filter_info=FilterModel::chkFilter($params['info']);
        if (!$filter_info['status']){
            return json(['code'=>420,'msg'=>"内容含有非法关键字[".$filter_info['key']."]"]);
        }
        if ($report_id==0){ //添加
            ReportModel::create([
                'active_id'=>$active_id,
                'info'=>$params['info'],
                'create_time'=>time(),
                'admin_id'=>$admin_id,
                'update_num'=>3 //默认三次修改机会
            ]);
            //更新人员服务时长
            Duration::computeUserDuration($active_id);
        }else{//更新
            //验证修改次数
            $res=ReportModel::where(['id'=>$report_id])->field('update_num')->find();
            if ($res['update_num']<=0){
                return json(['code'=>420,'msg'=>"已超过修改次数"]);
            }
            ReportModel::where(['id'=>$report_id])->update([
                'info'=>$params['info'],
                'update_time'=>time(),
                'update_num'=>$res['update_num']-1
            ]);
        }
        return json(['code'=>200]);
    }
    //修改获取详细
    public function getInfo(){
        $active_id=input('get.active_id',0);
        if (empty($active_id)){
            return json(['code'=>420,'msg'=>"参数错误"]);
        }
        $res=Db::query("select act.title,act.id as active_id,report.* from qx_active act left join qx_report report on act.id=report.active_id where act.id=".$active_id);
        if ($res){
            $res=$res[0];
            $res['title']=$res['title'].'-报告';
            if (empty($res['id'])){ //如果report id不存在，则说明第一次填写活动报告
                $res['pic']='';
                $res['domain']='';
                $res['info']='';
                $res['report_id']=0;

            }else{
                $res['pic']=ReportPicModel::where(['active_id'=>$res['active_id']])->field('path')->select();
                $res['domain']=domain().'uploads/';
                $res['report_id']=$res['id'];
            }


        }
        return json(['code'=>200,'content'=>$res]);
    }
    //小程序删除图片
    public function postDelPic(){
        $path=input('post.path','');
        if (!empty($path)){
            $domain=domain().'uploads/';
            $picPath=str_replace($domain,'',$path); //去掉图片网址
            ReportPicModel::where(['path'=>$picPath])->delete();
            $serPath=ROOT_PATH.'/uploads/'.$picPath;
            if (file_exists($serPath)) {
                unlink($serPath);
                return json(['code'=>200]);
            }
            return json(['code'=>420,'msg'=>'服务图片不存在']);
        }
        return json(['code'=>420,'msg'=>'参数path为空']);
    }
    //上传图片
    public function postUpload(){
        $active_id=input('post.active_id',0);
        if (empty($active_id)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $file = request()->file('pic');
        if (!empty($file)){
            $info = $file->validate(['ext'=>'jpg,png,gif'])->move( './uploads');
            if($info){
                ReportPicModel::create(['active_id'=>$active_id,'path'=>$info->getSaveName()]);
                return json(['code'=>200,'data'=>$info->getSaveName()]);
            }else{
                return json(['code'=>420,'msg'=>$file->getError()]);
            }
        }else{//上传图片为空也返回200
            return json(['code'=>420,'msg'=>'上传失败']);
        }
    }
}