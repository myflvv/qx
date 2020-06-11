<?php
namespace think\custom\common;
use Firebase\JWT\JWT;
use think\custom\lib\RedisLib;
/**
 * jwt类
 * @author zdy
 * Class JwtToken
 * @package common
 */
class JwtToken{

    private static $key="w12#$3@wr"; //加密key
    private static $blacklist_key='jwt_blacklist_'; //redis黑名单，用于注销删除token
    private static $key_expire=14400; //redis黑名单过期时间
    private static $token_expire=10800; //token过期时间

    /**
     * 创建token
     * @param $data  //自定义参数,可以为数组
     * @return array
     */
    public static function create($data){
//        echo $data;die;
        try{
            $time=time();
            $tokenArr=array(
                'iat' => $time, //创建时间
                'nbf' => $time, //Not Before 某个时间点后才能访问
                'exp' => $time+self::$token_expire, //3小时过期
                'data' =>$data  //自定义
            );
            $token=JWT::encode($tokenArr, self::$key);
        }catch (\Exception $e){
            return array('msg'=>$e->getMessage(),'code'=>301);
        }
        return array('data'=>$token,'msg'=>'success','code'=>200);
    }

    /**
     * 校验token
     * tp获取token方法 Request::header('Authorization')
     * @param $token
     * @return array
     */
    public static function verify($token){
        $redis=new RedisLib();
        $btoken=$redis->get(self::$blacklist_key.md5($token));
        if(!empty($btoken) && $btoken==$token){
            return array('code'=>302,'msg'=>'token已过期');
        }
        try{
            JWT::$leeway = 60; //当前时间减去60，把时间留点余地
            $result = JWT::decode($token, self::$key, array('HS256'));
        }catch (\Exception $e){
            return array('msg'=>$e->getMessage(),'code'=>303);
        }
        return array('data'=>$result,'msg'=>'success','code'=>200);
    }

    /**
     * 用于注销、修改密码等重新登录操作
     * @param $token
     * @return array
     */
    public static function cancel($token){
        try{
            $redis=new RedisLib();
            $redis->set(self::$blacklist_key.md5($token),$token,self::$key_expire);
        }catch (\Exception $e){
            return array('code'=>304,'msg'=>'cache保存错误');
        }
        return array('code'=>200);
    }
}
