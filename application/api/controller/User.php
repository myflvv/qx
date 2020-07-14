<?php
namespace app\api\controller;

use app\api\model\ActiveModel;
use app\api\model\EnterModel;
use app\api\model\Team;
use think\Controller;
use think\custom\lib\WXBizDataCrypt;
use think\Db;

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
            $res=Team::where("pid=0 && is_team!=1")->order('sort desc,id asc')->field('id,name')->select();
        }else{
            $res=Team::where("pid=".$id." && is_team!=1")->order('sort desc,id asc')->field('id,name')->select();
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
        if ($res){
            //TODO 计算服务时间及排名
            $res['service_time']=100;
            $res['ranking']=40;
            return json(['code'=>200,'content'=>$res]);
        }else{
            return json(['code'=>420,'msg'=>'初始化数据失败']);
        }
    }

    //我的信息 获取
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

    //我的信息 通用更新方法
    public function postModify(){
        $openid=input('post.openid','');
        if (empty($openid)){
            return json(['code'=>420,'msg'=>'授权不存在']);
        }
        $params=input('post.data');
        $updateData=[];
        //工作单位
        if ($params['submit_type']=='team'){
            if ($params['team_id']!=0){
                $updateData=['team_id'=>$params['team_id']];
            }else{
                return json(['code'=>420,'msg'=>'单位ID错误']);
            }
        }
        //性别
        if ($params['submit_type']=='sex'){
            $updateData=['sex'=>$params['sex']];
        }

        //政治面貌
        if ($params['submit_type']=='pol_cou'){
            $updateData=['pol_cou'=>$params['pol_cou']];
        }

        //最高学历
        if ($params['submit_type']=='hight_edu'){
            $updateData=['hight_edu'=>$params['hight_edu']];
        }
        //居住区域
        if ($params['submit_type']=='area'){
            $updateData=['area'=>$params['area']];
        }
        //详细地址
        if ($params['submit_type']=='address'){
            $updateData=['address'=>$params['address']];
        }
        //社区团队
        if ($params['submit_type']=='comm'){
            $updateData=['comm_id'=>$params['comm_id']];
        }

        if (!empty($updateData)){
            \app\api\model\User::where(['openid'=>$openid])->update($updateData);
            return json(['code'=>200,'msg'=>'success']);
        }else{
            return json(['code'=>420,'msg'=>'请求数据错误']);
        }
    }
    //我的活动
    public function getMyActive(){
        $openid=input('get.openid','');
        if (empty($openid)){
            return json(['code'=>420,'msg'=>'参数错误']);
        }
        $page=input('get.pageNum',1);
        $offset=10;
        $limit=($page-1)*$offset;
        $user_res=\app\api\model\User::where(['openid'=>$openid])->field('id')->find();
        $user_id=$user_res['id'];
        if (!$user_id){
            return json(['code'=>420,'msg'=>'openid错误']);
        }
        $res=Db::query("select *,enter.id as enter_id from qx_enter enter left join qx_active act on enter.active_id=act.id where enter.user_id=$user_id order by enter.create_time desc limit $limit,$offset");
        foreach ($res as $key=>$val){
            //打卡是否完成
            if (empty($val['start_dk_time']) || empty($val['end_dk_time'])){
                $res[$key]['finish_status']='未完成';
            }
            if (!empty($val['start_dk_time']) && !empty($val['end_dk_time'])){
                $res[$key]['finish_status']='已完成';
            }
            //服务时间格式化
            $res[$key]['active_time_format']=active_format_date($val['active_start_time'])." ~ ".active_format_date($val['active_end_time']);
            if (empty($val['start_dk_time'])){ //如果开始打卡时间为空，说明没有打卡,计算活动开始打卡时间范围
                $res[$key]['start_dk_time_format']=dk_time_format($val['active_start_time']);
                $res[$key]['start_dk_status']='签到';//开始是否打卡,未打卡
            }else{ //如果存在则显示时分
                $res[$key]['start_dk_time_format']=date('H:i',$val['start_dk_time']);
                $res[$key]['start_dk_status']='已签到';//开始是否打卡,已打卡
            }
            //签到签退时间处理
            if (empty($val['end_dk_time'])){ //结束打卡时间
                $res[$key]['end_dk_time_format']=dk_time_format($val['active_end_time']);
                $res[$key]['end_dk_status']='签退';//结束是否打卡,未打卡
            }else{ //如果存在则显示时分
                $res[$key]['end_dk_time_format']=date('H:i',$val['end_dk_time']);
                $res[$key]['end_dk_status']='已签退';//结束是否打卡,已打卡
            }
        }
        return json(['code'=>200,'content'=>$res]);
    }

    //签到
    public function postMyActiveDk(){
        $id=input('post.id',0);
        $active_id=input('post.activeid',0);
        $type=input('post.type','');
        $openid=input('post.openid','');
        $address=input('post.address','');
        $latitude=input('post.latitude','');
        $longitude=input('post.longitude','');

        if (empty($id) || empty($type) || empty($openid) || empty($active_id) || empty($address) || empty($latitude) || empty($longitude)){
            return json(['code'=>420,'msg'=>'参数错误,请重新登录尝试']);
        }
        $res=ActiveModel::where(['id'=>$active_id])->field('active_start_time,active_end_time')->find();
        if ($res){
            $dk_time="";
            $data=[];
            $tip="";
            $place=json_encode([
                'latitude'=>$latitude,
                'longitude'=>$longitude,
                'address'=>$address
            ]);
            if ($type=='start'){ //如果是签到
                $tip="签到";
                $dk_time=$res['active_start_time'];
                $data=[
                  'start_dk_time'=>time(),
                  'start_dk_place'=>$place
                ];
            }
            if ($type=='end'){//如果是签退
                $tip="签退";
                $dk_time=$res['active_end_time'];
                $data=[
                    'end_dk_time'=>time(),
                    'end_dk_place'=>$place
                ];
            }
            if (empty($dk_time)){
                return json(['code'=>420,'msg'=>'打卡参数错误,请重新登录尝试']);
            }
            if (chk_dk_time($dk_time)){ //如果打卡时间在时间范围内
                //更新enter表打卡时间，以及打卡定位信息
                EnterModel::where(['id'=>$id])->update($data);
                return json(['code'=>200,'content'=>$tip."成功",'date'=>date('H:i',time())]);
            }else{
                return json(['code'=>420,'msg'=>'不在打卡时间范围内']);
            }
        }else{
            return json(['code'=>420,'msg'=>'活动不存在']);
        }
    }

    public function getTeam(){
        echo 1;
    }
}