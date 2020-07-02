<?php
namespace app\api\controller;

use app\api\model\Team;
use think\Controller;
use lib\WXBizDataCrypt;
class User extends Controller{

    public function postRegister(){
        $params=input('post.');
        $param=$params['data'];
        $openid=$params['openid'];
        if (!$this->chkIdNumber($param['id_number'])){
            return json(['code'=>420,'msg'=>'身份证号码已存在']);
        }
        $data=[
            'openid'=>$openid,
            'real_name'=>$param['real_name'],
            'id_number'=>$param['id_number'],
            'sex'=>$param['sex'],
            'tel'=>$param['tel'],
            'team_id'=>$param['team_id'],
            'comm_id'=>$param['comm_id'],
            'pol_cou'=>$param['pol_cou'],
            'hight_edu'=>$param['hight_edu'],
            'area'=>$param['area'],
            'address'=>$param['address'],
            'create_time'=>time()
        ];
        $res=\app\api\model\User::create($data);
        if ($res){
            return json(['code'=>200,'msg'=>'注册成功']);
        }else{
            return json(['code'=>420,'msg'=>'注册失败']);
        }
    }

    //检查身份证号码是否重复注册
    private function chkIdNumber($id_number){
        if (empty($id_number)){
            return false;
        }
        $res=\app\api\model\User::where(['id_number'=>$id_number])->count();
        if ($res>0){
            return false;
        }else{
            return true;
        }
    }

    //获取openid session_key
    public function getLogin(){
        $code=input('get.code');
        $appid=config('app.AppID');
        $secret=config('app.AppSecret');
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $res=curl_request($url,'','GET');
        return $res;
//        $resArr=json_decode($res,true);
//        if (array_key_exists('errcode',$resArr)){
//            return json(['code'=>420,'msg'=>$resArr['errmsg']]);
//        }else{
//            return json(['code'=>200,'data'=>$resArr]);
//        }
    }

    //获取手机号,并且判断是否注册过
    public function postPhonenumber(){
        $sessionKey=input('post.session_key');
        $encryptedData=input('post.encryptedData');
        $iv=input('post.iv');
        $appid=config('app.AppID');
        $openid=input('post.openid');
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        header("Content-Type: application/json; charset=utf-8");
        if ($errCode == 0) {
            $dataArr=json_decode($data,true);
            if ($this->chkIsRegister($openid)){
                $dataArr['is_register']=1;
            }else{
                $dataArr['is_register']=0;
            }
            return json(['code'=>200,'content'=>$dataArr]);
        } else {
            return json(['code'=>$errCode]);
        }
    }

    //检查是否注册过
    private function chkIsRegister($openid){
        $res=\app\api\model\User::where(['openid'=>$openid])->count();
        if ($res>0){
            return true;
        }else{
            return false;
        }
    }

    //工作单位
    public function getTeamType(){
        $id=input('get.id',0);
        if ($id==0){
            $res=Team::where("pid=0 && is_team=0")->order('sort desc,id asc')->field('id,name')->select();
        }else{
            $res=Team::where("pid=".$id." && is_team=0")->order('sort desc,id asc')->field('id,name')->select();
        }

        $data=[];
        foreach ($res as $key=>$val){
            $val['count']=Team::where(['pid'=>$val['id']])->count();
            $data[0]=[
                'id'=>0,
                'name'=>'请选择'
            ];
            $data[$key+1]=$val;
        }
//        dump($data);die;
        return json(['code'=>200,'content'=>$data]);
    }

    //社区团队
    public function getCommType(){
        $res=Team::where(['pid'=>39])->order('sort desc,id asc')->field('id,name')->select();
        $data=[];
        foreach ($res as $key=>$val){
            $data[0]=[
                'id'=>0,
                'name'=>'请选择(可选)'
            ];
            $data[$key+1]=$val;
        }
        return json(['code'=>200,'content'=>$data]);
    }

    //我的 接口数据
    public function postMyData(){
        $openid=input('post.openid','');
        if (empty($openid)){
            return json(['code'=>420,'msg'=>'授权不存在']);
        }
        $res=\app\api\model\User::where(['openid'=>$openid])->field('real_name')->find();
        //TODO 计算服务时间及排名
        $res['service_time']=100;
        $res['ranking']=40;
        if ($res){
            return json(['code'=>200,'content'=>$res]);
        }else{
            return json(['code'=>420,'msg'=>'初始化数据失败']);
        }
    }

    //我的信息
    public function getInfo(){
        $openid=input('get.openid','');
        if (empty($openid)){
            return json(['code'=>420,'msg'=>'授权不存在']);
        }
        $res=\app\api\model\User::where(['openid'=>$openid])->find();
        if ($res){
            if ($res['comm_id']==0){
                $res['comm']='';
            }else{
                $commRes=Team::where(['id'=>$res['comm_id']])->field('name')->find();
                $res['comm']=$commRes['name'];
            }
            $teamRes=Team::where(['id'=>$res['team_id']])->field('name')->find();
            $res['team']=$teamRes['name'];

            return json(['code'=>200,'content'=>$res]);
        }else{
            return json(['code'=>420,'msg'=>'获取用户数据失败']);
        }
    }

    public function getTeam(){
        echo 1;
    }
}