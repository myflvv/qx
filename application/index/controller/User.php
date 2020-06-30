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
}