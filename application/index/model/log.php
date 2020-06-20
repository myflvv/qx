<?php
namespace app\index\model;
use think\Model;
class Log extends Model{
    protected $table="qx_log";

    static function add($content){
        self::insert([
            'user_id'=>session('user_id'),
            'create_time'=>time(),
            'content'=>$content
        ]);
    }
}