<?php
namespace app\index\model;
use think\Db;
use think\Model;
class StatisticModel extends Model
{
    //获取单位子ID,及单位总数
    public static function teamNameByPid($pid,$limit,$offset){
        $res=\app\api\model\Team::where(['pid'=>$pid])->limit($offset,$limit)->order('sort desc')->select();
        $resCount=\app\api\model\Team::where(['pid'=>$pid])->count();
        return ['res'=>$res,'count'=>$resCount];
    }

    //获取发起活动总数
    public static function activeCount($team_id){
        $countSql="select count(*) as count from qx_admin admin left join qx_active act on admin.id=act.add_user_id where admin.team_id=".$team_id;
        $countRes=Db::query($countSql);
        return $countRes[0]['count'];
    }

    //获取单位人员平均服务时长及人员总数
    public static function userCount($team_id){
        $sql="select  avg(duration) as avg_duration,count(id) as count from qx_user where team_id=".$team_id;
        $res=Db::query($sql);
        return $res[0];
    }

    //获取镇街二级、三级子ID及单位总数
    public static function townNameByPid($limit,$offset){
        $res=\app\api\model\Team::where(['is_town'=>1])->limit($offset,$limit)->order('sort desc,id asc')->select();
        $resCount=\app\api\model\Team::where(['is_town'=>1])->count();
        return ['res'=>$res,'count'=>$resCount];
    }
    //人员 获取所属单位
    public static function userTeamData($limit,$offset){
        $sql="select user.real_name,user.comm_id,user.id,user.duration,team.name as team_name from qx_user user left join qx_team team on user.team_id=team.id order by user.create_time desc limit $offset,$limit";
        $res=Db::query($sql);
        return $res;
    }
}