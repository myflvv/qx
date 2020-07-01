<?php
namespace app\index\controller;

use app\index\model\Log;
use think\Controller;
class User extends Controller{

    public function getIndex(){
//        $this->assign('pol_cou_arr',pol_cou_select());
        return $this->fetch('index');
    }

    public function getListData(){
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $search=input('get.search');
        if (empty($search)){
            $total = \app\index\model\User::count();
            $res = \app\index\model\User::limit($offset,$limit)->order('create_time desc')->select();
        }else{ //TODO 条件搜索
            $total = \app\index\model\User::where()->count();
            $res = \app\index\model\User::limit($offset,$limit)->order('create_time desc')->select();
        }

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
    //获取编辑内容
    public function getEdit(){
        $id=input('get.id',0);
        if ($id==0){
            return json(['code'=>420,'msg'=>'id错误']);
        }
        $res=\app\index\model\User::where(['id'=>$id])->find();
        if ($res){
            $parent=$this->getparent($res['team_id']);
            return json(['code'=>200,'data'=>$res,'parent'=>$parent]);
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
//            'team_id'=>$param['team_id'],
//            'comm_id'=>$param['comm_id'],
            'pol_cou'=>$param['pol_cou'],
            'hight_edu'=>$param['hight_edu'],
            'area'=>$param['area'],
            'address'=>$param['address'],
        ];
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
        $id=input('get.id',0);
        if($id==0){
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
    private function getparent($id){
        if ($id==0){
            return '';
        }
        $res=\app\index\model\Team::where(['id'=>$id])->field('id,name,pid,level')->find();
        $res_p=\app\index\model\Team::where(['id'=>$res['pid']])->field('id,name,pid,level')->find();
        if ($res['level']==2){
            return $res_p['name']." > ".$res['name'];
//            return ['team_id_1'=>$res_p['name'],'team_id_2'=>$res['name'],'team_id_3'=>''];
        }
        if ($res['level']==3){
            $res_pp=\app\index\model\Team::where(['id'=>$res_p['pid']])->field('id,name,pid')->find();
            return $res_pp['name']." > ".$res_p['name']." > ".$res['name'];
//            return ['team_id_1'=>$res_pp['name'],'team_id_2'=>$res_p['name'],'team_id_3'=>$res['name']];
        }
    }

    public function getTest(){
        $res=\app\index\model\Team::order('sort desc')->select();
        $r=recursion($res,0);
        return json($r);
    }
}