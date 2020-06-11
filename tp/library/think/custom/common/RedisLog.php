<?php
/**
 * redis队列日志类
 * @author zdy
 */
namespace think\custom\common;
use think\custom\lib\RedisLib;
class RedisLog
{
    private static $queue='api_es_log';
    /**
     * 正常通信信息日志
     * @param $message
     * @param $sql
     */
    public static function info($message,$sql=''){
        return self::push('info',$message,$sql);
    }

    /**
     * 警告
     * @param $message
     * @param $sql
     */
    public static function warning($message,$sql=''){
        return self::push('warning',$message,$sql);
    }

    /**错误
     * @param $message
     * @param $sql
     */
    public static function error($message,$sql=''){
        return self::push('error',$message,$sql);
    }

    /**
     * 提示注意
     * @param $message
     * @param $sql
     */
    public static function notice($message,$sql=''){
        return self::push('notice',$message,$sql);
    }

    /**
     * 测试
     * @param $message
     * @param $sql
     */
    public static function debug($message,$sql=''){
        return self::push('debug',$message,$sql);
    }

    /**
     * 写入队列日志
     * @param $type
     * @param $message
     * @param $sql
     * @throws \Exception
     */
    private static function push($type,$message,$sql){
        try{
            $msg="【".$type."】 ".date('Y-m-d H:i:s')."[url:".request()->url(true)."] [location:".request()->module()."/".request()->controller()."/".request()->action()."] [msg:".$message."]";
            if($sql!=''){
                $msg.="[sql:".$sql."]";
            }
            $handler=new RedisLib();
            return $handler->queueIn(self::$queue,$msg);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(),300);
        }
    }

}