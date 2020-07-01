<?php
function recursion($result,$parentid=0){
    static $list=array();
    foreach ($result as $k => $v){
        if($v['pid']==$parentid){
            $list[]=$v;
            recursion($result,$v['id']);
        }
    }
    return $list;
}
