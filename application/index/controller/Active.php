<?php
namespace app\index\controller;

use app\index\model\ActiveModel;
use app\index\model\ActiveType;
use app\index\model\Log;
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
        if (empty($id) || empty($name)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        ActiveType::where(['id'=>$id])->update(['name'=>$name]);
        Log::add('活动管理 活动类型修改-'.$name);
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
        $sql="select act.*,adm.username from qx_active act left join qx_admin adm on act.add_user_id=adm.id where act.id=".$id;
        $res=Db::query($sql);
        if ($res){
            $val=$res[0];
            $val['active_time']=date('Y-m-d H:i',$val['active_start_time'])." ~ ".date('Y-m-d H:i',$val['active_end_time']);
            $val['recruit_time']=date('Y-m-d H:i',$val['recruit_start_time'])." ~ ".date('Y-m-d H:i',$val['recruit_end_time']);
            $val['create_time']=date('Y-m-d H:i:s',$val['create_time']);
            $val['service_time']=$val['service_time']."小时";
            return json(['code'=>200,'data'=>$val]);
        }else{
            return json(['code'=>420,'msg'=>'数据不存在']);
        }
    }
}