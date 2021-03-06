<?php
namespace app\index\controller;

use app\api\model\ActiveModel;
use app\api\model\EnterModel;
use app\index\model\Admin;
use app\index\model\ExportModel;
use app\index\model\Log;
use app\index\model\StatisticModel;
use think\Controller;
use think\Db;

class Sys extends Controller{

    public function getIndex(){
        return $this->fetch('index');
    }

    public function getLogs(){
        return $this->fetch('logs');
    }

    public function getLogsData(){
//        $page = input('get.page',1);
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $total = Log::count();
        $res = Log::field('id,content,create_time')->limit($offset,$limit)->order('create_time desc')->select();
        $data=[];
        $no=1+intval($offset);
        foreach ($res as $val){
            $val['create_time']=date('Y-m-d H:i:s',$val['create_time']);
            $val['no']=$no;
            $data[]=$val;
            $no++;
        }
        return json(['total'=>$total,'rows'=>$data]);
    }

    public function getAdminData(){
        $level=session("level");
        $where= " 1=1 ";
        //同级别管理员只能看到同级及下级
        if ($level!=0){
            $t=intval($level)-1;
            $where.=" and level > ".$t;
        }
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $total=Admin::where($where)->count();
        $res=Admin::where($where)->limit($offset,$limit)->order('create_time desc')->select();
        $data=[];
        $no=1+intval($offset);
        foreach ($res as $val){
            $val['create_time']=date('Y-m-d H:i:s',$val['create_time']);
            $val['level_name']=admin_level($val['level']);
            $val['team']=$this->getparent($val['team_id'],'name');
            $val['no']=$no;
            $data[]=$val;
            $no++;
        }
        return json(['total'=>$total,'rows'=>$data]);
    }

    public function postAdminSave(){
        $params=input('post.');
        if ($params['password']!=$params['repassword']){
            return json(['code'=>420,'msg'=>'两次输入密码不一直']);
        }
        $team_id=0;
        if ($params['level']==3){
            if (array_key_exists('team_3',$params)){
                $team_id=$params['team_3'];
            }else{//如果没有team_3说明菜单只有2级
                $team_id=$params['team_2'];
            }
        }
        $findRes=Admin::where(['username'=>$params['username']])->count();
        if ($findRes>0){
            return json(['code'=>420,'msg'=>'用户名已存在']);
        }
        $res=Admin::create([
            'username'=>$params['username'],
            'password'=>md5_en($params['password']),
            'level'=>$params['level'],
            'team_id'=>$team_id,
            'create_time'=>time()
        ]);
        if($res){
            return json(['code'=>200,'msg'=>'success']);
        }else{
            return json(['code'=>420,'msg'=>'保存数据错误']);
        }
    }

    public function postAdminEditSave(){
        $params=input('post.');
        $data=[];
        if (!empty($params['e_password'])){
            if ($params['e_password']!=$params['e_repassword']){
                return json(['code'=>420,'msg'=>'两次输入密码不一致']);
            }else{
                $data['password']=md5_en($params['e_password']);
            }
        }

        if ($params['action_id']!=1){
            if ($params['e_level']==3){
                if (array_key_exists('e_team_3',$params)){
                    $data['team_id']=$params['e_team_3'];
                }else{
                    $data['team_id']=$params['e_team_2'];
                }
            }else{
                $data['team_id']=0;
            }
            $data['level']=$params['e_level'];
        }
        $data['update_time']=time();

        Admin::where(['id'=>$params['action_id']])->update($data);
        return json(['code'=>200,'msg'=>'success']);
    }

    public function postAdminDel(){
        $id=input('post.id',0);
        $name=input('post.username');
        if ($id==0){
            return json(['code'=>420,'msg'=>'id错误']);
        }
        if ($id==1){
            return json(['code'=>420,'msg'=>'超级管理员账号不能删除']);
        }
        $res=Admin::destroy($id);
        if ($res){
            Log::add('管理员管理 删除-'.$name);
            return json(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json(['code'=>420,'msg'=>'删除错误']);
        }
    }

    public function getAdminInfo(){
        $id=input('get.id',0);
        if ($id==0){
            return json(['code'=>420,'msg'=>'id错误']);
        }
        $res=Admin::where(['id'=>$id])->find();
        if ($res){
            if ($res['team_id']!=0){
                $res['team']=$this->getparent($res['team_id']);
            }
            return json(['code'=>200,'data'=>$res]);
        }else{
            return json(['code'=>420,'msg'=>'获取信息错误']);
        }
    }

    //获取team_id父级 子级 id
    public function getparent($id,$type="id"){
        if ($id==0){
            return '';
        }
        $res=\app\index\model\Team::where(['id'=>$id])->field('id,name,pid,level')->find();
        $res_p=\app\index\model\Team::where(['id'=>$res['pid']])->field('id,name,pid,level')->find();
        if ($res['level']==2){
            if ($type=='id'){
                return ['team_1_id'=>$res_p['id'],'team_2_id'=>$res['id'],'team_3_id'=>0];
            }else{
                return $res_p['name']." > ".$res['name'];
            }
        }
        if ($res['level']==3){
            $res_pp=\app\index\model\Team::where(['id'=>$res_p['pid']])->field('id,name,pid')->find();
            if ($type=='id'){
                return ['team_1_id'=>$res_pp['id'],'team_2_id'=>$res_p['id'],'team_3_id'=>$res['id']];
            }else{
                return $res_pp['name']." > ".$res_p['name']." > ".$res['name'];
            }
        }
    }

    //过滤关键字
    public function getKeyWords(){
        $res=Db::query("select keywords from qx_filter where id=1");
        $this->assign('keywords',$res[0]['keywords']);
        return $this->fetch('keywords');
    }

    //保存过滤关键字
    public function postKeyWordsSave(){
        $keywords=input('post.keywords');
        Db::query("update qx_filter set keywords='".$keywords."', update_time='".time()."' where id=1");
        return json(['code'=>200,'msg'=>"success"]);
    }

    //机关页面
    public function getStatistic_Office(){
        return $this->fetch('statistic_office');
    }

    //机关
    public function getOffice(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        return $this->statisticData(1,$limit,$offset);
    }

    //团体页面
    public function getStatistic_Team(){
        return $this->fetch('statistic_team');
    }

    //团体
    public function getTeam(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        return $this->statisticData(39,$limit,$offset);
    }

    //学校页面
    public function getStatistic_School(){
        return $this->fetch('statistic_school');
    }

    //学校
    public function getSchool(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        return $this->statisticData(58,$limit,$offset);
    }

    //镇街页面admininfo
    public function getStatistic_Town(){
        return $this->fetch('statistic_town');
    }

    //镇街
    public function getTown(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        return $this->statisticTownData($limit,$offset);
    }

    //导出镇街数据
    public function getExportTown(){
        $limit=10;
        $resArr=$this->statisticTownData($limit,0,false);
        $data=[];
        if ($resArr['total']>0){
            $data[]=$resArr['rows'];
            $page=ceil($resArr['total']/$limit);
            if ($page>1){
                for ($i=1;$i<$page;$i++){
                    $res=$this->statisticTownData($limit,$i*$limit,false);
                    array_push($data,$res['rows']);
                }
            }
            $headerArr=['序号','名称','发起活动总数','人员总数','平均服务时长(小时)'];
            ExportModel::export('Town',$headerArr,$data);
            return json(['code'=>200,'msg'=>'/excel/Town.xlsx']);
        }else{
            return json(['code'=>420,'msg'=>'数据不存在']);
        }
    }

    //获取镇街数据
    private function statisticTownData($limit,$offset,$json=true){
        $no=1+intval($offset);
        $res=StatisticModel::townNameByPid($limit,$offset);
        $teamRes=$res['res'];
        $data=[];
        foreach ($teamRes as $key=>$val){
            $data[$key]['no']=$no;
            $data[$key]['name']=$val['name'];
            //二级
            if ($val['level']==2){
                //获取街道所有子ID社区
                $countJD=\app\api\model\Team::where(['pid'=>$val['id']])->field('id')->select();
                $countJD_arr=[];
                foreach ($countJD as $v){
                    $countJD_arr[]=$v['id'];
                }
                $countJD_id=implode(',',$countJD_arr);
                //查询所有包含子ID社区的人员时长及人员ID
                $tsql="select duration from qx_user where team_id in ($countJD_id)";
                $jdRes=Db::query($tsql);

                //获取二级单位发起的活动总数
                $adminSql="select count(*) as active_count from qx_admin admin left join qx_active act on admin.id=act.add_user_id where admin.team_id in ($countJD_id)";
                $adminRes=Db::query($adminSql);
                $data[$key]['active_count']=$adminRes[0]['active_count'];
                //二级人员总数
                $data[$key]['user_count']=count($jdRes);
                $jv_int=0;

                if ($jdRes){
                    //将子ID时长累加
                    foreach ($jdRes as $jv){
                        $jv_int=$jv_int+$jv['duration'];
//                        $user_id_str.=$jv['id'].','; //所有二级人员ID
                    }

//                    $enterCount=
                    //所有用户的累加时长，除以当前街道的总社区数
                    $avg_duration=floor($jv_int/count($countJD)*10)/10;
                    $data[$key]['avg_duration']=$avg_duration;
                }else{
                    $data[$key]['avg_duration']=0;
                }
            }
            //三级
            if ($val['level']==3){
                //三级单位发起活动总数
                $data[$key]['active_count']=StatisticModel::activeCount($val['id']);

                $threeRes=StatisticModel::userCount($val['id']);
                $data[$key]['user_count']=$threeRes['count'];
                $data[$key]['avg_duration']=empty($threeRes['avg_duration'])?0:floor($threeRes['avg_duration']*10)/10;
            }
            $no++;
        }
        if ($json){
            return json(['total'=>$res['count'],'rows'=>$data]);
        }else{
            return ['total'=>$res['count'],'rows'=>$data];
        }
    }
    //人员
    public function getStatistic_User(){
        return $this->fetch('statistic_user');
    }

    //人员统计数据
    public function getUser(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        return $this->statisticUserData($limit,$offset);
    }

    //人员导出
    public function getExportUser(){
        $limit=10;
        $resArr=$this->statisticUserData($limit,0,false);
        $data=[];
        if ($resArr['total']>0){
            $data[]=$resArr['rows'];
            $page=ceil($resArr['total']/$limit);
            if ($page>1){
                for ($i=1;$i<$page;$i++){
                    $res=$this->statisticUserData($limit,$i*$limit,false);
                    array_push($data,$res['rows']);
                }
            }
            $headerArr=['序号','姓名','所属单位','所属团体','参与活动总数','总服务时长(小时)'];
            ExportModel::export('User',$headerArr,$data);
            return json(['code'=>200,'msg'=>'/excel/User.xlsx']);
        }else{
            return json(['code'=>420,'msg'=>'数据不存在']);
        }

    }

    //导出机关、团体、学校数据
    public function getExportAll(){
        $type=input("get.type",'');
        if (empty($type)){
            return '参数错误';
        }
        if ($type=='office'){
            $team_id=1;
        }
        if ($type=='team'){
            $team_id=39;
        }
        if ($type=='school'){
            $team_id=58;
        }
        $types=ucfirst($type); //首字母转大写
        $limit=10;
        $resArr=$this->statisticData($team_id,$limit,0,false);
        if ($resArr['total']>0){
            $data[]=$resArr['rows'];
            $page=ceil($resArr['total']/$limit);
            if ($page>1){
                for ($i=1;$i<$page;$i++){
                    $res=$this->statisticData($team_id,$limit,$i*$limit,false);
                    array_push($data,$res['rows']);
                }
            }
            $headerArr=['序号','名称','发起活动总数','人员总数','平均服务时长(小时)'];
            ExportModel::export($types,$headerArr,$data);
            return json(['code'=>200,'msg'=>'/excel/'.$types.'.xlsx']);
        }else{
            return json(['code'=>420,'msg'=>'数据不存在']);
        }

//        dump($data);
    }

    //获取人员数据
    private function statisticUserData($limit,$offset,$json=true){
        $no=1+intval($offset);
        $res=StatisticModel::userTeamData($limit,$offset);
        $count=\app\api\model\User::count();
        if ($res){
            $data=[];
            foreach ($res as $key=>$val){
                $data[$key]['no']=$no;
                $data[$key]['real_name']=$val['real_name'];
                $data[$key]['team_name']=$val['team_name'];
                //获取团体名称
                $commRes=\app\api\model\Team::where(['id'=>$val['comm_id']])->field('name')->find();
                if ($commRes){
                    $team_name=$commRes['name'];
                }else{
                    $team_name='--';
                }
                $data[$key]['comm_name']=$team_name;
                //获取参与活动总数,签到签退完成的总数
                $enterRes=EnterModel::where("user_id=".$val['id']." and start_dk_time<>0 and end_dk_time<>0 ")->count();
                $data[$key]['sum_active_count']=$enterRes;

                $data[$key]['sum_service_time']=floor($val['duration']*10)/10;
//                $res[$key]['no']=$no;
                $no++;
            }
            if ($json){
                return json(['total'=>$count,'rows'=>$data]);
            }else{
                return ['total'=>$count,'rows'=>$data];
            }

        }else{
            if ($json){
                return json(['total'=>0,'rows'=>'']);
            }else{
                return ['total'=>0,'rows'=>''];
            }
        }
    }

    //获取机关、团体、学校统计数据
    private function statisticData($team_id,$limit,$offset,$json=true){
        $no=1+intval($offset);
        $res=StatisticModel::teamNameByPid($team_id,$limit,$offset);
        $teamRes=$res['res'];
        $data=[];
        foreach ($teamRes as $key=>$val){
            $data[$key]['no']=$no;
            $data[$key]['name']=$val['name'];
            $data[$key]['active_count']=StatisticModel::activeCount($val['id']);
            $userArr=StatisticModel::userCount($val['id']);
            if (empty($userArr['avg_duration'])){
                $duration=0;
            }else{
                $duration=floor($userArr['avg_duration']*10)/10;
            }
            $data[$key]['user_count']=$userArr['count']; //人员总数
            $data[$key]['avg_service_time']=$duration; //平均服务时长

            $no++;
        }
        if ($json){
            return json(['total'=>$res['count'],'rows'=>$data]);
        }else{
            return ['total'=>$res['count'],'rows'=>$data];
        }
    }

    public function getStatisticSearch(){
        $params=input('get.');
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $searchKey=input('get.searchKey','');
        $no=1+intval($offset);

        $date=explode(' - ',$params['selectDate']);
        $startUnix=strtotime($date[0]);
        $endUnix=strtotime($date[1]);

        if ($params['type_select']=='team'){
            if (empty($searchKey)){
                $keyWhere='';
            }else{
                $keyWhere=" and  name like '%".$searchKey."%'";
            }
            $teamRes=\app\api\model\Team::where('pid<>0 and is_team<>2'.$keyWhere)->limit($offset,$limit)->select();
            $count=\app\api\model\Team::where('pid<>0 and is_team<>2'.$keyWhere)->count();
//            dump($teamRes);
            foreach ($teamRes as $key=>$val){
                $countSql="select count(*) as count from qx_admin admin left join qx_active act on admin.id=act.add_user_id where admin.team_id=".$val['id'].' and act.create_time > '.$startUnix.' and act.create_time < '.$endUnix;
                $countRes=Db::query($countSql);
                $teamRes[$key]['count']=$countRes[0]['count'];
                //人员总数
                if ($val['pid']==39){
                    $userWhere='comm_id='.$val['id'];
                }else{
                    $userWhere='team_id='.$val['id'];
                }
                $userWhere.=' and create_time > '.$startUnix.' and create_time < '.$endUnix;
                $userCount=\app\index\model\User::where($userWhere)->count();
                $teamRes[$key]['userCount']=$userCount;
                $teamRes[$key]['no']=$no;
                $no++;
            }

            return  json(['total'=>$count,'rows'=>$teamRes]);
        }

        if ($params['type_select']=='user'){
            if (empty($searchKey)){
                $keyWhere='';
            }else{
                $keyWhere=" and real_name like '%".$searchKey."%'";
            }
            $res=\app\index\model\User::where('1=1 '.$keyWhere)->limit($offset,$limit)->field('real_name,id')->select();
            $count=count($res);
            $data=[];
            foreach ($res as $key=>$val){
                $res[$key]['count']=EnterModel::where('user_id='.$val['id'].' and create_time > '.$startUnix.' and create_time < '.$endUnix)->count();
                $res[$key]['no']=$no;
                $no++;
            }
            return  json(['total'=>$count,'rows'=>$res]);
        }
    }


}