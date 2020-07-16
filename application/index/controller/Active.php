<?php
namespace app\index\controller;

use app\index\model\ActiveModel;
use app\index\model\ActiveType;
use app\index\model\Admin;
use app\index\model\EnterModel;
use app\index\model\Log;
use app\index\model\ReportModel;
use app\index\model\ReportPicModel;
use think\Controller;
use think\Db;

class Active extends Controller{

    public function getType(){
        $type=1;
        $this->assign('type',$type);
        return $this->fetch('type');
    }

    public function getTime(){
        $type=2;
        $this->assign('type',$type);
        return $this->fetch('type');
    }
    //活动类型及时长列表
    public function getList(){
        $type=input('get.t',1);
        $res=ActiveType::where(['type'=>$type])->select();
        $i=1;
        foreach ($res as $val){
            $val['no']=$i;
            $i++;
        }
        return json($res);
    }

    public function getTypeDel(){
        $id=input('get.id');
        $name=input('get.name');
        if (empty($id) || empty($name)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $res = ActiveType::destroy($id);
        if ($res){
            Log::add('活动管理 活动类型删除-'.$name);
            return json(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json(['code'=>420,'msg'=>'删除错误']);
        }
    }

    public function postTypeSave(){
        $id=input('post.action_id');
        $name=input('post.name');
        if (empty($name)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $active_type=input('post.active_type');//获取是时长还是类型
        if ($active_type==1){
            $title="活动类型";
        }else{
            $title="服务时长";
        }

        if ($id==0){//添加
            Log::add('活动管理 '.$title.'添加');
            ActiveType::create(['name'=>$name,'type'=>$active_type]);
        }else{
            ActiveType::where(['id'=>$id])->update(['name'=>$name]);
            Log::add('活动管理 '.$title.'修改-'.$name);
        }
        return json(['code'=>200,'msg'=>'删除成功']);
    }

    public function getActive(){
        return $this->fetch('active');
    }

    public function getActiveList(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $total = ActiveModel::count();
        $res = ActiveModel::field('id,title,service_time,user,tel,create_time')->limit($offset,$limit)->order('create_time desc')->select();
        $data=[];
        $no=1+intval($offset);
        foreach ($res as $val){
            $val['create_time']=date('Y-m-d H:i:s',$val['create_time']);
            $val['service_time']=$val['service_time']."小时";
            $val['no']=$no;
            $data[]=$val;
            $no++;
        }
        return json(['total'=>$total,'rows'=>$data]);
    }

    //活动详情
    public function getActiveInfo(){
        $id=input('get.id',0);
        if ($id==0){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $sql="select act.*,adm.username,adm.team_id from qx_active act left join qx_admin adm on act.add_user_id=adm.id where act.id=".$id;
        $res=Db::query($sql);
        if ($res){
            $val=$res[0];
            $val['active_time']=date('Y-m-d H:i',$val['active_start_time'])." ~ ".date('Y-m-d H:i',$val['active_end_time']);
            $val['recruit_time']=date('Y-m-d H:i',$val['recruit_start_time'])." ~ ".date('Y-m-d H:i',$val['recruit_end_time']);
            $val['create_time']=date('Y-m-d H:i:s',$val['create_time']);
            $val['service_time']=$val['service_time']."小时";
            $val['service_type']=$this->getActiveType($val['service_type_id']);
            $val['team_name']=$this->getTeamName($val['team_id']);
            return json(['code'=>200,'data'=>$val]);
        }else{
            return json(['code'=>420,'msg'=>'数据不存在']);
        }
    }

    //获取活动类型
    private function getActiveType($id){
        $res=ActiveType::where(['id'=>$id])->find();
        if ($res){
            $name=$res['name'];
        }else{
            $name="--";
        }
        return $name;
    }
    //获取发布单位名称
    private function getTeamName($id){
        $res=\app\index\model\Team::where(['id'=>$id])->find();
        if ($res){
            $name=$res['name'];
        }else{
            $name="--";
        }
        return $name;
    }

    public function getActiveDel(){
        $id=input('get.id');
        $name=input('get.name');
        if (empty($id) || empty($name)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $res = ActiveModel::destroy($id);
        if ($res){
            Log::add('活动管理 活动删除-'.$name);
            return json(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json(['code'=>420,'msg'=>'删除错误']);
        }
    }

    public function getUser(){
        $id=input('get.active_id',0);
        if ($id==0){
            return "参数错误";
        }
        $this->assign('active_title',$this->getActiveTitle($id));
        $this->assign('active_id',$id);
       return $this->fetch('user');
    }

    //活动报名人员列表
    public function getActiveUserList(){
        $id=input('get.active_id',0);
        if ($id==0){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $count=EnterModel::where(['active_id'=>$id])->count();
        $res=Db::query("select ent.*,user.real_name from qx_enter ent left join qx_user user on ent.user_id=user.id where ent.active_id=".$id." order by create_time desc limit $offset,$limit");
        if ($res){
            $no=1+intval($offset);
            foreach ($res as $key=>$val){
                $res[$key]['create_time_format']=date('Y-m-d H:i:s',$val['create_time']);
                if (empty($val['start_dk_time'])){
                    $res[$key]['start_dk_time_format']="未打卡";
                }else{
                    $res[$key]['start_dk_time_format']=date('Y-m-d H:i:s',$val['start_dk_time']);
                }
                if (empty($val['end_dk_time'])){
                    $res[$key]['end_dk_time_format']="未打卡";
                }else{
                    $res[$key]['end_dk_time_format']=date('Y-m-d H:i:s',$val['end_dk_time']);
                }
                $res[$key]['no']=$no;
                $no++;
            }
        }
        return json(['total'=>$count,'rows'=>$res]);

    }

    //获取活动标题
    private function getActiveTitle($id){
        $res=ActiveModel::where(['id'=>$id])->field('title')->find();
        if ($res){
            return $res['title'];
        }else{
            return "--";
        }
    }

    //获取活动报告
    public function getReport(){
        $active_id=input('get.active_id',0);
        if (empty($active_id)){
            return '参数错误';
        }
        $res=Db::query("select report.*,act.title,report.info as report_info,report.create_time as report_create_time from qx_active act left join  qx_report report on act.id=report.active_id where act.id=".$active_id." limit 1");

        if ($res){
            $data=[];
            if (empty($res[0]['create_time'])){ //如果没有报告
                $data=[
                    'title'=>$res[0]['title'].'-报告',
                    'create_time'=>'',
                    'admin_name'=>'',
                    'info'=>'',
                    'is_add'=>0,//是否有内容
                    'id'=>0,
                    'pic'=>[]
                ];
            }else{
                $reportRes=ReportPicModel::where(['active_id'=>$active_id])->select();
                $data=[
                    'title'=>$res[0]['title'].'-报告',
                    'create_time'=>date('Y-m-d H:i:s',$res[0]['report_create_time']),
                    'admin_name'=>Admin::getAdminNameById($res[0]['admin_id']),
                    'info'=>$res[0]['report_info'],
                    'is_add'=>1,//是否有内容
                    'id'=>$res[0]['id'],
                    'pic'=>$reportRes
                ];
            }
            $data['active_id']=$active_id;
            $this->assign('data',$data);
            return $this->fetch('report');
        }else{
            return '无此活动';
        }

    }
    //活动报告上传图片
    public function postUpload(){
        $active_id=input('post.active_id',0);
        if (empty($active_id)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $file = request()->file('myfile');
        if (!empty($file)){ //如果上传图片存在则更新
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->move( './uploads');
            if($info){
                ReportPicModel::create(['active_id'=>$active_id,'path'=>$info->getSaveName()]);
                return json(['code'=>200,'data'=>$info->getSaveName()]);
            }else{
                return json(['code'=>420,'msg'=>$file->getError()]);
            }
        }else{//上传图片为空也返回200
            return json(['code'=>200]);
        }

    }
    //删除图片
    public function postUploadDel(){
        $id=input('post.key',0);
        $this->delUploadPic($id);
        return json(['code'=>200]);
    }
    private function delUploadPic($id){
        if (!empty($id)){
            $res=ReportPicModel::where(['id'=>$id])->field('path')->find();
            if ($res){
                $path=ROOT_PATH.'/uploads/'.$res['path'];
                if (file_exists($path)) {
                    unlink($path);
                }
                ReportPicModel::destroy($id);
            }
        }
    }
    //保存活动报告
    public function postReportSave(){
        $active_id=input('post.active_id');
        $report_id=input('post.report_id');
        $info=input('post.info');
        if (empty($active_id)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        if ($report_id==0){ //添加
            $data=[
                'active_id'=>$active_id,
                'info'=>$info,
                'create_time'=>time(),
                'update_num'=>3,
                'admin_id'=> session("admin_id")
            ];
            Log::add('AdminID'.session('admin_id')." 添加活动报告 ID".$active_id);
            ReportModel::create($data);
        }else{//修改 管理员不修改update_num次数
            $data=[
                'info'=>$info,
                'update_time'=>time(),
                'admin_id'=> session("admin_id")
            ];
            Log::add(session('admin_id')."修改活动报告ID".$active_id);
            ReportModel::where(['id'=>$report_id])->update($data);
        }
        return json(['code'=>200,'msg'=>'success']);
    }
}