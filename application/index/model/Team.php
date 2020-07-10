<?php
namespace app\index\model;
use think\Model;
class Team extends Model{
    protected $table="qx_team";

    public function typeData(){
        $res = self::field('id,name,pid,sort,level,is_team')->order('sort desc,id asc')->select();
        $i=1;
        foreach ($res as $val){
            $val['no']=$i;
            $i++;
        }
        return $res;
    }


}