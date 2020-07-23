<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class Team extends Controller
{

    //获取团队列表
    public function getList(){
        $index=input('get.index',0);
        $id=$this->teamTitle($index);
//        if ($id==0){ //如果是社区，取level=3
//            $res=\app\api\model\Team::where("level=3")->order('sort desc,id asc')->select();
//        }else{
//            //is_team<>2 去掉二级街道
//            $res=\app\api\model\Team::where("pid=".$id." and is_team<>2")->select();
//        }
        if ($id==0){ //如果是社区，取level=3
            $where=' where team.level=3 ';
        }else{
            //is_team<>2 去掉二级街道
            $where=" where team.pid=$id and team.is_team<>2 ";
        }
        $sql="select team.name, sum(user.duration) as sum_duration,count(user.id) as user_count from qx_team team left join qx_user user on team.id=user.team_id $where  group by team.id order by team.sort desc,team.id asc";
        $res=Db::query($sql);
        foreach ($res as $key=>$val){
            if (empty($val['sum_duration'])){
                $res[$key]['sum_duration']=0;
            }
        }
        return json(['code'=>200,'content'=>$res]);
    }
    //首页志愿排行
    public function getRanking(){
        $index=input('get.index',0);
        if ($index==5){ //索引是5 表示人员
            $page=input('get.pageNum',1);
            $offset=15;
            $limit=($page-1)*$offset;
            $res=\app\api\model\User::field('real_name,duration')->order('duration desc')->limit($limit,$offset)->select();
            return json(['code'=>200,'content'=>$res]);
        }

        $id=$this->teamTitle($index);
        if ($id==0){ //如果是社区，取level=3
            #TODO 社区应该读取用户表comm_id而不是team_id
            $where=' where team.level=3 ';
        }else{
            //is_team<>2 去掉二级街道
//            $where=" where team.pid=$id and team.is_team<>2 ";
            $where=" where team.pid=$id ";
        }
//        $sql="select user.duration,user.team_id as user_team_id,team.id as team_id,team.name as team_name from qx_team team left join qx_user user on team.id=user.team_id $where ";
        $sql="select team.id,team.is_team,team.name, avg(user.duration) as avg_duration from qx_team team left join qx_user user on team.id=user.team_id $where  group by team.id order by avg_duration desc";
        $res=Db::query($sql);
        foreach ($res as $key=>$val){
            if (!empty($val['avg_duration'])){
                $res[$key]['avg_duration']=floor($val['avg_duration']*10)/10; //取一位小数
            }else{
                $res[$key]['avg_duration']=0;
            }

            //如果是街道,计算街道下属于社区的用户时长 街道时长=用户总时长/社区数量
            if ($val['is_team']==2){
                //获取街道所有子ID社区
                $countJD=\app\api\model\Team::where(['pid'=>$val['id']])->field('id')->select();
                $countJD_arr=[];
                foreach ($countJD as $v){
                    $countJD_arr[]=$v['id'];
                }
                $countJD_id=implode(',',$countJD_arr);
                //查询所有包含子ID社区的用户时长
                $tsql="select duration from qx_user where team_id in ($countJD_id)";
                $jdRes=Db::query($tsql);
                $jv_int=0;
                if ($jdRes){
                    //将子ID时长累加
                    foreach ($jdRes as $jv){
                        $jv_int=$jv_int+$jv['duration'];
                    }
                    //所有用户的累加时长，除以当前街道的总社区数
                    $avg_duration=floor($jv_int/count($countJD));
                   $res[$key]['avg_duration']=$avg_duration;
                }
                #TODO 按照时长排序
            }
        }
//        $data=[];
//        foreach ($res as $key=>$val){
//            if (!array_key_exists($val['team_name'],$data)){
//                $data[$val['team_name']]=empty($val['duration'])?0:$val['duration'];
//            }elseif ($val['user_team_id']==$val['team_id']){
//                $data[$val['team_name']]= $data[$val['team_name']]+$val['duration'];
//            }
//        }
        return json(['code'=>200,'content'=>$res]);
    }

    //获取头部切换标签
    private function teamTitle($index){
        $id=0;
        switch ($index){
            case 0: //机关
                $id=1;  //机关ID
                break;
            case 1:
                $id=85; //镇街
                break;
            case 2:
                $id=58;//学校
                break;
            case 3:
                $id=0; //社区没有ID，所以为0
                break;
            case 4:
                $id=39; //团体
                break;
        }
        return $id;
    }
}