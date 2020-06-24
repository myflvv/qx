<?php
namespace app\api\controller;

use think\Controller;
use lib\WXBizDataCrypt;
class User extends Controller{

    public function postRegister(){
        $param=input('post.');
        if (!$this->chkIdNumber($param['id_number'])){
            return json(['code'=>420,'msg'=>'身份证号码已存在']);
        }
        $data=[
            'real_name'=>$param['real_name'],
            'id_number'=>$param['id_number'],
            'sex'=>$param['sex'],
            'tel'=>$param['tel'],
            'team_id'=>$param['team_id'],
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

    //获取手机号
    public function postPhonenumber(){
        $sessionKey=input('post.session_key');
        $encryptedData=input('post.encryptedData');
        $iv=input('post.iv');
        $appid=config('app.AppID');
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        header("Content-Type: application/json; charset=utf-8");
        if ($errCode == 0) {
            $dataArr=json_decode($data,true);
            return json(['code'=>200,'content'=>$dataArr]);
        } else {
            return json(['code'=>$errCode]);
        }
    }

    public function getTeam(){

    }
}