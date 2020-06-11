<?php
/**
 * redis队列类
 * @author zdy
 */
namespace lib;
use think\cache\driver\Redis;
class RedisQueue extends Redis
{
    function __construct()
    {
        $option=[
            'host' => Config('redis.host'),
            'port'       => Config('redis.port'),
            'password'   => Config('redis.password'),
            'select'     => 0,
            'timeout'    => Config('redis.timeout'),
            'expire'     => Config('redis.expire'),
            'persistent' => false,
            'prefix'     => '',
            'serialize'  => true,
        ];
        parent::__construct($option);
    }

    /**
     * 向队列尾部插入元素
     * @param $queue
     * @param $value
     */
    public function queueIn($queue,$value){
        $this->handler->rpush($queue, $value);
    }
}