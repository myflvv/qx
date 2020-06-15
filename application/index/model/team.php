<?php
namespace app\index\model;
use think\Model;
class Team extends Model{
    protected $table="qx_team";

    public function listData($pid=0,&$data=[])
    {
        $res = self::where(['pid'=>$pid])->order('sort desc,id asc')->select();
        foreach ($res as $key=>$val){
            $data[$key]['text']=$val['name'];
            $data[$key]['href']='#'.$val['id'];
            $data[$key]['nodes']=self::listData($val['id'],$data);
        }
        return $data;
    }

    public function typeData(){
        $res = self::where(['pid'=>0])->order('sort desc,id asc')->select();
        return $res;
    }
}