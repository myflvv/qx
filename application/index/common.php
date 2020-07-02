<?php
function recursion($result,$parentid=0){
    $list=array();
    foreach ($result as $k => $v){
        if($v['pid']==$parentid){
//            $list[$k]['n']=$v['name'];
            $v['n']=$v['name'];
            $v['s']=recursion($result,$v['id']);
//            if ($v['level']!=1){
//                $list[]['s']['n']=recursion($result,$v['id']);
//            }
            $list[]=$v;
        }
    }
    return $list;
}
