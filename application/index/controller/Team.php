<?php
namespace app\index\controller;
use app\index\model\Log;
use think\Controller;
use app\index\model\Team as mTeam;
class Team extends Controller{

    public function getType(){
        return $this->fetch('type');
    }

    public function getTypeList(){
        $m= new mTeam();
        $data=$m->typeData();
        return json($data);
    }

    public function postSave(){
        $action_id=input('post.action_id',0);
        $name=input('post.name');
        $sort=input('post.sort',0);
        $pid=input('post.pid',0);
        $level=input('post.level',1);
        if ($action_id==0){
            $m=new mTeam();
            $m->data([
                'name'=>$name,
                'sort'=>$sort,
                'pid'=>$pid,
                'level'=>$level
            ]);
            $m->save();
            Log::add('团队管理 添加-'.$name);
        }else{
            $data=[
                'name'=>$name,
                'sort'=>$sort
            ];
            \app\index\model\Team::where(['id'=>$action_id])->update($data);
            Log::add('团队管理 修改-'.$name);
        }
        return json(['code'=>200]);
    }

    public function getDel(){
        $id=input('get.id');
        $name=input('get.name');
        if (empty($id) || empty($name)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $m = new mTeam();
        $count=$m->where(['pid'=>$id])->count();
        if ($count>0){
            return json(['code'=>420,'msg'=>'请先删除子栏目']);
        }
        $res = \app\index\model\Team::destroy($id);
        if ($res){
            Log::add('团队管理 删除-'.$name);
            return json(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json(['code'=>420,'msg'=>'删除错误']);
        }
    }

}