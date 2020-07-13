<?php
namespace app\api\controller;


use app\api\model\ActiveModel;
use app\api\model\ActiveType;
use app\api\model\EnterModel;
use app\api\model\Team;
use app\index\model\Log;
use think\Controller;
use think\Db;

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

    //首页活动
    public function getHomeActiveList(){
        $key=input('get.key','');
        $page=input('get.pageNum',1);
        $offset=10;
        $limit=($page-1)*$offset;
        if (!empty($key)){
            $where = "where act.title like '%".$key."%' or team.name like '%".$key."%'";
        }else{
            $where='';
        }
        $sql="select act.*,team.name from qx_active act left join qx_team team on act.add_user_id=team.id ".$where."  order by act.create_time desc limit $limit,$offset";
        $res=Db::query($sql);
        if ($res){
            foreach ($res as $key=>$val){
                $recruit_end_time=$val['recruit_end_time'];
                if (empty($recruit_end_time)){ //如果招募结束时间为空，则结束时间为活动的开始时间
                    $recruit_end_time=$val['active_start_time'];
                }
                //获取招募及活动状态
                $res[$key]['recruit_status']=recruit_status($val['recruit_start_time'],$recruit_end_time,$val['active_start_time'],$val['active_end_time']);

                if (empty($val['info'])){
                    $res[$key]['info']='无';
                }
            }
        }else{ //没有数据返回空
            $res="";
        }
        return json(['code'=>200,'content'=>$res]);
    }

    //活动详情
    public function getDetail(){
        $id=input('get.id',0);
        $openid=input('get.openid','');
        if ($id==0){
            return json(['code'=>420,'msg'=>'ID不存在']);
        }
        $res=Db::query("select act.*,team.name from qx_active act left join qx_team team on act.add_user_id=team.id where act.id=".$id);
        if ($res){
            $res=$res[0];
//            $res['team_name']=$this->getTeamName($res['team_id']);
            $res['team_name']=$res['name'];
            if (empty($res['info'])){
                $res['info']='无';
            }
            $res['active_type']=$this->getActiveType($res['service_type_id']);
            $res['active_time_format']=active_format_date($res['active_start_time'])." ~ ".active_format_date($res['active_end_time']);
            $recruit_end_time=$res['recruit_end_time'];
            if (empty($recruit_end_time)){ //如果招募结束时间为空，则结束时间为活动的开始时间
                $recruit_end_time=$res['active_start_time'];
            }
            //获取招募及活动状态
            $res['recruit_status']=recruit_status($res['recruit_start_time'],$recruit_end_time,$res['active_start_time'],$res['active_end_time']);
            $res['recruit_time_format']=active_format_date($res['recruit_start_time'])." ~ ".active_format_date($recruit_end_time);

            //判断报名按钮显示
            if (empty($openid)){//如果没有登录
                $res['bm_button_status']=0;
            }else{
                $bmM=Db::query("select count(*) as total   from qx_enter enter left  join qx_user user on user.id=enter.user_id where user.openid='".$openid."' and enter.active_id=".$id);
                $res['bm_button_status']=$bmM[0]['total'];

            }
            return json(['code'=>200,'content'=>$res]);
        }else{
            return json(['code'=>420,'msg'=>'内容不存在']);
        }
    }

    //立即报名
    public function postReport(){
        $active_id=input('post.id',0);
        $openid=input('post.openid','');
        if (empty($active_id) || empty($openid)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $user_id=\app\api\model\User::getUserId($openid);
        if (empty($user_id)){
            return json(['code'=>420,'msg'=>'用户不存在']);
        }
        $res=EnterModel::create(['user_id'=>$user_id,'active_id'=>$active_id,'create_time'=>time()]);
        if ($res){
            return json(['code'=>200,'msg'=>"success"]);
        }else{
            return json(['code'=>420,'msg'=>'报名错误']);
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
    //获取单位名称
//    private function getTeamName($id){
//        if (empty($id)){
//            return '--';
//        }else{
//            $res=Team::where(['id'=>$id])->field('name')->find();
//            if ($res){
//                return $res['name'];
//            }else{
//                return 'none';
//            }
//        }
//    }

}