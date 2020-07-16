<?php
namespace app\index\model;
use think\Db;
use think\Model;
//人员单位活动时长计算
class Duration extends Model{

    //计算人员积分
    public static function computeUserDuration($active_id){
        $service_time=self::getServiceTime($active_id);

        if (!empty($service_time)){//如果活动服务时长存在
            $sql="select enter.*,user.duration,user.id as user_id from qx_enter enter left join qx_user user on enter.user_id=user.id where enter.active_id=".$active_id;
            $res=Db::query($sql);
            if ($res){
                foreach ($res as $val){
                    //如果user_id等于空，说明此人员参加了活动，但是user表人员信息被删除
                    if (!empty($val['user_id'])){
                        //如果签到、签退时间存在
                        if (!empty($val['start_dk_time']) && !empty($val['end_dk_time'])){
                            //更新服务时长
                            User::where(['id'=>$val['user_id']])->update([
                                'duration'=>$val['duration']+$service_time
                            ]);
                        }
                    }
                }
            }
        }

    }
    //获取活动服务时长
    private static function getServiceTime($active_id){
        $activeM=ActiveModel::where(['id'=>$active_id])->field('service_time')->find();
        if ($activeM){
            return $activeM['service_time'];
        }else{ //如果服务不存在
            return '';
        }
    }
}