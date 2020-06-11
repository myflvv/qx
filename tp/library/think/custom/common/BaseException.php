<?php
namespace think\custom\common;
use Exception;
use think\exception\Handle;
use think\custom\common\RedisLog;
/**
 * 异常错误处理类,以json形式统一抛出所有错误
 * 使用方法 throw new \Exception('msg',300);
 * Class BaseException
 * @package common
 */
class BaseException extends Handle{

    public function render(Exception $e){
        if ($e instanceof Exception) {
            $result = [
                "code" => $e->getCode(),
                "msg"   => $e->getMessage(),
            ];
            RedisLog::error('异常:'.$e->getMessage());
            return json($result);
        }
        // 其他错误交给系统处理
//        return parent::render($e);
    }
}