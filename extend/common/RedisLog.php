<?php
/**
 * redis队列日志类
 * @author zdy
 */
namespace common;
use lib\RedisQueue;
class RedisLog
{

    /**
     * 正常通信信息日志
     * @param $message
     */
    public static function info($message){
        return self::push('info',$message);
    }

    /**
     * 警告
     * @param $message
     */
    public static function warning($message){
        return self::push('warning',$message);
    }

    /**错误
     * @param $message
     */
    public static function error($message){
        return self::push('error',$message);
    }

    /**
     * 提示注意
     * @param $message
     */
    public static function notice($message){
        return self::push('notice',$message);
    }

    /**
     * 测试
     * @param $message
     */
    public static function debug($message){
        return self::push('debug',$message);
    }

    /**
     * 写入队列日志
     * @param $type info|warning|error|notice|debug
     * @param $message
     */
    private static function push($type,$message){
        $msg="【".$type."】 ".date('Y-m-d H:i:s')."[url:".request()->url(true)."] [location:".request()->module()."/".request()->controller()."/".request()->action()."] [msg:".$message."]";
        $handler=new RedisQueue();
        return $handler->queueIn(Config('redis.queue_log'),$msg);
    }

}