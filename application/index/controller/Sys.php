<?php
namespace app\index\controller;

use app\index\model\Admin;
use app\index\model\Log;
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
        $offset=input('get.offset',0);
        $limit=input('get.limit',10);
        $total=Admin::count();
        $res=Admin::limit($offset,$limit)->order('create_time desc')->select();
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
    private function getparent($id,$type="id"){
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

    public function getKeyWords(){
        $res=Db::query("select keywords from qx_filter where id=1");
        $this->assign('keywords',$res[0]['keywords']);
        return $this->fetch('keywords');
    }

    public function postKeyWordsSave(){
        $keywords=input('post.keywords');
        Db::query("update qx_filter set keywords='".$keywords."', update_time='".time()."' where id=1");
        return json(['code'=>200,'msg'=>"success"]);
    }
}