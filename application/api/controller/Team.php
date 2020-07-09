<?php
namespace app\api\controller;

use think\Controller;

class Team extends Controller
{

    //获取团队列表
    public function getList(){
        $index=input('get.index',0);
        $id=0;
        switch ($index){
            case 0: //机关
              $id=1;  //机关ID
              break;
            case 1:
               $id=85; //镇街
               break;
            case 2:
                $id=58;//学校
                break;
            case 3:
                $id=0; //社区没有ID，所以为0
                break;
            case 4:
                $id=39; //团体
                break;
        }
        if ($id==0){ //如果是社区，取level=3
            $res=\app\api\model\Team::where("level=3")->select();
        }else{
            //is_team<>2 去掉二级街道
            $res=\app\api\model\Team::where("pid=".$id." and is_team<>2")->select();
        }

        return json(['code'=>200,'content'=>$res]);
    }
}