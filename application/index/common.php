<?php
//dump(request()->path());die;
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

function pathSelect($menu){
    $path=request()->path();
    $arr='';
    if ($menu=='active'){
        $arr=activeMenu();
    }
    if ($menu=='sys'){
        $arr=sysMenu();
    }
    if (in_array($path,$arr)){
        return true;
    }else{
        return false;
    }
}

function prePathSelect($cuPathArr){
    $path=request()->path();
    if (in_array($path,$cuPathArr)){
        echo "class='active'";
    }
}

function activeMenu(){
    return [
        'admin/active/type',
        'admin/active/time',
        'admin/active/active',
        'admin/active/user',
        'admin/active/report',
        'admin/active/edit'
    ];
}

function sysMenu(){
    return [
        'admin/sys/keywords',
        'admin/sys/logs',
        'admin/sys/index',
        'admin/sys/statistic_office',
        'admin/sys/statistic_team',
        'admin/sys/statistic_school',
        'admin/sys/statistic_town',
        'admin/sys/statistic_user',
    ];
}