<?php

namespace app\activity\model;

use think\Exception;
use think\Model;
use think\custom\common\RedisLog;
class Activity extends Model {
    protected $pk    = 'act_id';
    protected $table = 'activity';

    function getPage($conditions = [], $page = 1, $limit = 20) {
        try{
            $info['list']  = $this->where($conditions)->page($page)->limit($limit)->order('act_id', 'desc')->select();
            RedisLog::info(backtrace(),$this->getLastSql());
        }catch (\Exception $e){
            throw new \Exception($e->getMessage().' SQL:'.$this->getLastSql(),300);
        }
        try{
            $info['total'] = $this->where($conditions)->count('*');
            RedisLog::info(backtrace(),$this->getLastSql());
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(). ' SQL:' . $this->getLastSql(), 300);
        }
        return $info;
    }

    function getOnce($conditions = []) {
        try{
            $info = $this->where($conditions)->find();
            RedisLog::info(backtrace(),$this->getLastSql());
        }catch (\Exception $e){
            throw new \Exception($e->getMessage().' SQL:'.$this->getLastSql(),300);
        }
        return $info;
    }

    function getAll($conditions = []) {
        try{
            $info =  $this->where($conditions)->select();
            RedisLog::info(backtrace(),$this->getLastSql());
        }catch (\Exception $e){
            throw new \Exception($e->getMessage().' SQL:'.$this->getLastSql(),300);
        }
        return $info;
    }

    function add($data = []) {
        try{
            $info =  $this->insertGetId($data);
            RedisLog::info(backtrace(),$this->getLastSql());
        }catch (\Exception $e){
            throw new \Exception($e->getMessage().' SQL:'.$this->getLastSql(),300);
        }
        return $info;
    }

    function set($data = [], $conditions = []) {
        try{
            $info =  $this->save($data, $conditions);
            RedisLog::info(backtrace(),$this->getLastSql());
        }catch (\Exception $e){
            throw new \Exception($e->getMessage().' SQL:'.$this->getLastSql(),300);
        }
        return $info;
    }

    function del($conditions = []) {
        try{
            $info =  $this->where($conditions)->delete();
            RedisLog::info(backtrace(),$this->getLastSql());
        }catch (\Exception $e){
            throw new \Exception($e->getMessage().' SQL:'.$this->getLastSql(),300);
        }
        return $info;
    }


}