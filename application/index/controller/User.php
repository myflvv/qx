<?php
namespace app\index\controller;

use app\index\model\Log;
use think\Controller;
use think\Db;

class User extends Controller{

    public function getIndex(){
//        $this->assign('pol_cou_arr',pol_cou_select());
        return $this->fetch('index');
    }

    public function getListData(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $search=input('get.search');
//        if (empty($search)){
//            $total = \app\index\model\User::count();
//            $res = \app\index\model\User::limit($offset,$limit)->order('create_time desc')->select();
//        }else{ //TODO 条件搜索
//            $real_name_where=[
//                ['real_name','like','%'.$search.'%']
//            ];
//            $id_number_where=[
//                ['id_number','like','%'.$search.'%']
//            ];
//            $total = \app\index\model\User::whereOr([$real_name_where,$id_number_where])->count();
//            $res = \app\index\model\User::whereOr([$real_name_where,$id_number_where])->limit($offset,$limit)->order('create_time desc')->select();
//        }
        $where='';
        if (!empty($search)){
            $where=" where qu.real_name like '%$search%' or qt.name like '%$search%' ";
        }
        $countField="select count(*) as total ";
        $searchField="select qu.*,qt.`name` ";
        $sql=" from qx_user qu LEFT JOIN qx_team qt on qu.team_id=qt.id ".$where;
        $limitSql=" limit $offset,$limit";
        $total=Db::query($countField.$sql);
        $res=Db::query($searchField.$sql.$limitSql);
        $data=[];
        $no=1+intval($offset);
        foreach ($res as $val){
            $val['create_time']=date('Y-m-d H:i:s',$val['create_time']);
            $val['no']=$no;
            $data[]=$val;
            $no++;
        }
        return json(['total'=>$total[0]['total'],'rows'=>$data]);
    }
    //获取编辑内容
    public function getEdit(){
        $id=input('get.id',0);
        if ($id==0){
            return json(['code'=>420,'msg'=>'id错误']);
        }
        $res=\app\index\model\User::where(['id'=>$id])->find();
        if ($res){
//            $parent=$this->getparent($res['team_id']);
            if (!empty($res['team_id'])) {
                $sysM = new Sys();
                $res['team'] = $sysM->getparent($res['team_id']);
            }
            return json(['code'=>200,'data'=>$res]);
        }else{
            return json(['code'=>420,'msg'=>'获取数据错误']);
        }
    }
    public function postSave(){
        $param=input('post.');
        $data=[
            'real_name'=>$param['real_name'],
            'id_number'=>$param['id_number'],
            'sex'=>$param['sex'],
            'tel'=>$param['tel'],
            'comm_id'=>$param['comm_id'],
            'pol_cou'=>$param['pol_cou'],
            'hight_edu'=>$param['hight_edu'],
            'area'=>$param['area'],
            'address'=>$param['address'],
            'duration'=>$param['duration'],
        ];
//        $team_id=0;
//        if ($param['team_modify']==1){
//            if (array_key_exists('team_type_3',$param) && $param['team_type_3']!=0){
//                $team_id=$param['team_type_3'];
//            }elseif(array_key_exists('team_type_2',$param) && $param['team_type_2']!=0){
//                $res=\app\index\model\Team::where(['pid'=>$param['team_type_2']])->count();
//                if ($res>0){
//                    return json(['code'=>420,'msg'=>'请完善工作单位选择']);
//                }
//                $team_id=$param['team_type_2'];
//            }
//            if ($team_id==0){
//                return json(['code'=>420,'msg'=>'请完善工作单位选择']);
//            }
//            $data['team_id']=$team_id;
//        }
        if (array_key_exists('e_team_3',$param)){
            $data['team_id']=$param['e_team_3'];
        }else{
            $data['team_id']=$param['e_team_2'];
        }
        Log::add('人员管理 修改-'.$param['real_name']);
        \app\index\model\User::where(['id'=>$param['action_id']])->update($data);
        return json(['code'=>200]);
    }
    public function postDel(){
        $id=input('post.id',0);
        $name=input('post.real_name');
        if ($id==0){
            return json(['code'=>420,'msg'=>'id错误']);
        }
        $res=\app\index\model\User::destroy($id);
        if ($res){
            Log::add('人员管理 删除-'.$name);
            return json(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json(['code'=>420,'msg'=>'删除错误']);
        }
    }
    //工作单位下拉菜单
    public function getTeam(){
        $id=input('get.id',9999);
        if($id==9999){
            $res=\app\index\model\Team::where("pid=0 && is_team=0")->order('sort desc,id asc')->field('id,name')->select();
        }else{
            $res=\app\index\model\Team::where("pid=".$id." && is_team=0")->order('sort desc,id asc')->field('id,name')->select();
        }
        $data=[];
        foreach ($res as $key=>$val){
            $val['count']=\app\index\model\Team::where(['pid'=>$val['id']])->count();
            $data[0]=[
                'id'=>0,
                'name'=>'请选择',
                'count'=>0
            ];
            $data[$key+1]=$val;
        }
        return json(['code'=>200,'content'=>$data]);
    }

    //获取team_id父级 子级
//    private function getparent($id){
//        if ($id==0){
//            return '';
//        }
//        $res=\app\index\model\Team::where(['id'=>$id])->field('id,name,pid,level')->find();
//        $res_p=\app\index\model\Team::where(['id'=>$res['pid']])->field('id,name,pid,level')->find();
//        if ($res['level']==2){
//            return $res_p['name']." > ".$res['name'];
//        }
//        if ($res['level']==3){
//            $res_pp=\app\index\model\Team::where(['id'=>$res_p['pid']])->field('id,name,pid')->find();
//            return $res_pp['name']." > ".$res_p['name']." > ".$res['name'];
//        }
//    }

    //社区团队
    public function getComm(){
        $res=\app\index\model\Team::where(['pid'=>39])->order('sort desc,id asc')->field('id,name')->select();
        $data=[];
        foreach ($res as $key=>$val){
            $data[0]=[
                'id'=>0,
                'name'=>'请选择(可选)',
            ];
            $data[$key+1]=$val;
        }
        return json(['code'=>200,'data'=>$data]);
    }

    public function getTeamSelect(){
        $res=\app\index\model\Team::order('sort desc')->select();
        $r=recursion($res,0);
        return json($r);
    }
}