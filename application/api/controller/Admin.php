<?php
namespace app\api\controller;

use app\api\model\ActiveModel;
use app\api\model\ActiveType;
use app\api\model\AdminModel;
use think\Controller;
use think\Db;

class Admin extends Controller{

    public function postLogin(){
        $username=input('post.data.username','');
        $password=input('post.data.password','');
        if (empty($username) || empty($password)){
            return json(['code'=>420,'msg'=>'用户名密码不能为空']);
        }
//        $res=AdminModel::where(['username'=>$username,'password'=>md5_en($password),'level'=>3])->field('id,level,team_id,username')->find();
        $res=Db::query("select admin.id,admin.level,admin.team_id,admin.username,team.name from qx_admin admin left join qx_team team on admin.team_id=team.id where admin.username='".$username."' and password='".md5_en($password)."' and admin.level=3 ");
        if ($res){
            return json(['code'=>200,'content'=>$res[0]]);
        }else{
            return json(['code'=>420,'msg'=>'用户名或密码错误']);
        }
    }

    //服务类别
    public function getServiceType(){
        $res=ActiveType::where(['type'=>1])->select();
        $data=[];
        foreach ($res as $key=>$val){
            $data[$key]['id']=$val['id'];
            $data[$key]['text']=$val['name'];
        }
        return json(['code'=>200,'content'=>$data]);
    }

    //服务时长
    public function getServiceTime(){
        $res=ActiveType::where(['type'=>2])->select();
        $data=[];
        foreach ($res as $key=>$val){
            $data[$key]['text']=$val['name']."小时";
        }
        return json(['code'=>200,'content'=>$data]);
    }

    //管理员活动列表
    public function getActiveList(){
        $key=input('get.key','');
        $admin_id=input('get.admin_id',0);
        if ($admin_id==0){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $page=input('get.pageNum',1);
        $offset=20;
        $limit=($page-1)*$offset;
        $where=" act.add_user_id=".$admin_id;
        if (!empty($key)){
            $where .= " and act.title like '%".$key."%'";
        }
//        $res=ActiveModel::where($where)->limit($limit,$offset)->select();
        $sql="select act.*,report.id as report_id,report.update_num from qx_active act left join qx_report report on act.id=report.active_id where $where order by act.create_time desc limit $limit,$offset";
        $res=Db::query($sql);
        if ($res){
            $no=$limit;
            foreach ($res as $key=>$val){
                //活动报告
                if (empty($val['report_id'])){ //没有填写过活动报告
                    $res[$key]['report_button_txt']='填写报告(3次)';
                }else{
                    $res[$key]['report_button_txt']='修改报告('.$val['update_num'].'次)';
                }
                $recruit_end_time=$val['recruit_end_time'];
                if (empty($recruit_end_time)){ //如果招募结束时间为空，则结束时间为活动的开始时间
                    $recruit_end_time=$val['active_start_time'];
                }
                //获取招募及活动状态
                $res[$key]['recruit_status']=recruit_status($val['recruit_start_time'],$recruit_end_time,$val['active_start_time'],$val['active_end_time']);
                $res[$key]['no']=$no;
                $no++;
            }
        }else{ //没有数据返回空
            $res="";
        }
        return json(['code'=>200,'content'=>$res]);
    }
}