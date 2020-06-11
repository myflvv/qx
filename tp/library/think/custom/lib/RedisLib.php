<?php
/**
 * redis操作类
 * @author zdy
 */
namespace think\custom\lib;
use think\cache\driver\Redis;
class RedisLib extends Redis
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
     * @throws \Exception
     */
    public function queueIn($queue,$value){
        try{
            $this->handler->rpush($queue, $value);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(),300);
        }
    }

    /**
     * 出队
     * @param $queue
     * @param int $time
     * @return mixed
     * @throws \Exception
     */
    public function blpopOut($queue,$time=10){
        try{
            return $this->handler->blpop($queue, $time);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(),300);
        }
    }
}