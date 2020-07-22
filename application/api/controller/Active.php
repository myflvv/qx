<?php
namespace app\api\controller;


use app\api\model\ActiveModel;
use app\api\model\ActiveType;
use app\api\model\EnterModel;
use app\api\model\FilterModel;
use app\api\model\Team;
use app\index\model\Log;
use think\Controller;
use think\Db;

class Active extends Controller{

    public function postSave(){
        $params=input('post.data');
        $add_user_id=input('post.add_user_id');
        //发布内容过滤
        $filter_title=FilterModel::chkFilter($params['title']);
        if (!$filter_title['status']){
            return json(['code'=>420,'msg'=>"标题含有非法关键字[".$filter_title['key']."]"]);
        }

        $filter_info=FilterModel::chkFilter($params['info']);
        if (!$filter_info['status']){
            return json(['code'=>420,'msg'=>"描述含有非法关键字[".$filter_info['key']."]"]);
        }

        //毫秒转日期 活动开始时间
        $start_time=$this->getMsecToMescdate($params['start_time_unix']);

        //活动结束时间
        $end_time=$this->getMsecToMescdate($params['end_time_unix']);

        //招募开始时间
        $recruit_start_time=$this->getMsecToMescdate($params['recruit_start_time_unix']);

        //招募结束时间
        if(!empty(trim($params['recruit_end_time_unix']))){
            $recruit_end_time=$this->getMsecToMescdate($params['recruit_end_time_unix']);
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
        if (empty($params['active_id'])){ //如果活动ID为空或者为0,则添加
            $r=ActiveModel::create($data);
        }else{
            //修改更新
            $r=ActiveModel::where(['id'=>$params['active_id']])->update($data);
        }
        if ($r){
            return json(['code'=>200,'msg'=>'success']);
        }else{
            return json(['code'=>420,'msg'=>$r]);
        }
    }
    //毫秒时间戳转年月日时分时间戳
    private function getMsecToMescdate($msectime)
    {
        if (strlen($msectime)==10){ //修改保存如果没有选择,则是11位时间戳,原样返回
            return $msectime;
        }
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
        $mescdate = str_replace('x', $sec, $date);
        return strtotime($mescdate);
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
//        $sql="select act.*,team.name from qx_active act left join qx_team team on act.add_user_id=team.id ".$where."  order by act.create_time desc limit $limit,$offset";
        $sql="select act.*,admin.team_id from qx_active act left join qx_admin admin on act.add_user_id=admin.id ".$where."  order by act.create_time desc limit $limit,$offset";
        $res=Db::query($sql);
        if ($res){
            foreach ($res as $key=>$val){
                $recruit_end_time=$val['recruit_end_time'];
                if (empty($recruit_end_time)){ //如果招募结束时间为空，则结束时间为活动的开始时间
                    $recruit_end_time=$val['active_start_time'];
                }
                //获取发布人员所在单位
                if (empty($val['team_id'])){
                    $res[$key]['name']="发布人员单位不存在";
                }else{
                    $teamM=\app\index\model\Team::where(['id'=>$val['team_id']])->field('name')->find();
                    if ($teamM){
                        $res[$key]['name']=$teamM['name'];
                    }else{
                        $res[$key]['name']="单位不存在";
                    }
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
    //修改活动
    public function getEditDetail(){
        $id=input('get.id',0);
        if (empty($id)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $res=Db::query("select act.*,type.id as type_id,type.name as type_name from qx_active act left join qx_active_type type on act.service_type_id=type.id where act.id=".$id);
        if (!$res){
            return json(['code'=>420,'msg'=>'活动不存在']);
        }
        $res=$res[0];
        $nowTime=time();
        if ($nowTime<$res)
        //根据表单字段格式化
        $res['title_value']=$res['title'];
        $res['service_type']=$res['type_name'];
        $res['service_type_unix']=$res['type_id'];
        $res['service_time']=$res['service_time'].'小时';
        $res['service_time_unix']=$res['service_time'];
        $res['start_time']=date('Y-m-d H:i',$res['active_start_time']);
        $res['start_time_unix']=$res['active_start_time'];
        $res['end_time']=date('Y-m-d H:i',$res['active_end_time']);
        $res['end_time_unix']=$res['active_end_time'];
        $recruit_start_time_unix=$res['recruit_start_time'];
        $res['recruit_start_time']=date('Y-m-d H:i',$res['recruit_start_time']);
        $res['recruit_start_time_unix']=$recruit_start_time_unix;
        $res['recruit_end_time']=empty($res['recruit_end_time'])?"    ":date('Y-m-d H:i',$res['recruit_end_time']);//如果是空，保留空格，用于箭头对齐
        $res['recruit_end_time_unix']=$res['recruit_end_time'];
        $res['user_value']=$res['user'];
        $res['tel_value']=$res['tel'];
        $res['address_value']=$res['address'];
        $res['info_value']=$res['info'];
        $res['place']=$res['place_address'];
        return json(['code'=>200,'content'=>$res]);
    }

    //首页总数接口
    public function getHomeCount(){
        //志愿者总数
        $userCount=\app\api\model\User::count();
        //服务总时长
        $userDurationCount=\app\api\model\User::sum('duration');
        //活动总数
        $activeCount=ActiveModel::count();
        //团队总数
        $teamCount=Team::where('pid<>0 and is_team<>2')->count();
        $data=[
            'useCount'=>$userCount,
            'userDurationCount'=>$userDurationCount,
            'activeCount'=>$activeCount,
            'teamCount'=>$teamCount
        ];
        return json(['code'=>200,'content'=>$data]);
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