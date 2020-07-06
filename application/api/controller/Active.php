<?php
namespace app\api\controller;


use app\api\model\ActiveModel;
use app\api\model\Team;
use app\index\model\Log;
use think\Controller;

class Active extends Controller{

    public function postSave(){
        $params=input('post.data');
        $add_user_id=input('post.add_user_id');
        //毫秒转日期 活动开始时间
        $s=$this->getMsecToMescdate($params['start_time_unix']);
        $start_time=strtotime($s);//日期转时间戳
        //活动结束时间
        $s=$this->getMsecToMescdate($params['end_time_unix']);
        $end_time=strtotime($s);
        //招募开始时间
        $s=$this->getMsecToMescdate($params['recruit_start_time_unix']);
        $recruit_start_time=strtotime($s);

        //招募结束时间
        if(!empty($params['recruit_end_time_unix'])){
            $s=$this->getMsecToMescdate($params['recruit_end_time_unix']);
            $recruit_end_time=strtotime($s);
        }else{
            $recruit_end_time=0;
        }


        $service_time=trim($params['service_time_unix'],"小时");//替换小时
        $data=[
            'title'=>$params['title'],
            'service_type_id'=>$params['service_type_unix'],
            'service_time'=>$service_time,
            'active_start_time'=>$start_time,
            'active_end_time'=>$end_time,
            'recruit_start_time'=>$recruit_start_time,
            'recruit_end_time'=>$recruit_end_time,
            'address'=>$params['address'],
            'info'=>$params['info'],
            'user'=>$params['user'],
            'tel'=>$params['tel'],
            'place_latitude'=>$params['place_latitude'],
            'place_longitude'=>$params['place_longitude'],
            'place_address'=>$params['place_address'],
            'place_name'=>$params['place_name'],
            'create_time'=>time(),
            'add_user_id'=>$add_user_id
        ];
        $r=ActiveModel::create($data);
        if ($r){
            return json(['code'=>200,'msg'=>'success']);
        }else{
            return json(['code'=>420,'msg'=>$r]);
        }
    }
    //毫秒转日期
    private function getMsecToMescdate($msectime)
    {
        $msectime = $msectime * 0.001;
        if (strstr($msectime, '.')) {
            sprintf("%01.3f", $msectime);
            list($usec, $sec) = explode(".", $msectime);
            $sec = str_pad($sec, 3, "0", STR_PAD_RIGHT);
        } else {
            $usec = $msectime;
            $sec = "000";
        }
        $date = date("Y-m-d H:i", $usec);
        return $mescdate = str_replace('x', $sec, $date);
    }

    //我的成员 列表、单位信息、总人数
    public function getMyMember(){
        $admin_team_id=input('get.admin_team_id');
        $list=\app\api\model\User::where(['team_id'=>$admin_team_id])->field('id,real_name')->select();
        $team_name=Team::where(['id'=>$admin_team_id])->field('name')->find();
        return json(['code'=>200,'content'=>$list,'team_name'=>$team_name['name'],'count'=>count($list)]);
    }
    //删除
    public function postDelMember(){
        $id=input('post.id');
        $title=input('post.title');
        $admin_username=input('post.admin_username');
        \app\api\model\User::destroy($id);
        Log::add('我的成员 ['.$admin_username."] 删除 [".$title."]");
        return json(['code'=>200]);
    }

}