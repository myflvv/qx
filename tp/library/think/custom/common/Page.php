<?php
namespace think\custom\common;

use think\Db;

/**
 * 分页类
 * @author zdy
 * Class Page
 * @package think\custom\common
 * 调用方法
 * $page=new Page('admin_role','2','`name`,`desc`','2','');
 * $res=$page->data();
 */
class Page{

    private $total;                         //数据表中总记录数
    private $listRows;                      //每页显示行数
    private $pageNum;                       //总页数
    private $currentPage;                   //当前页
    private $table;                         //表名
    private $query;                         //查询条件
    private $field;                         //返回字段名例如:`name`,`id`
    private $offset;                        //偏移

    /**
     * 设置参数
     * Page constructor.
     * @param $table
     * @param int $listRows
     * @param string $field
     * @param string $query
     * @param int $currentPage
     */
    public function __construct($table, $listRows=25, $field="*", $currentPage=1, $query=""){
        $this->table = $table;
        $this->query=$query;
        $this->listRows = $listRows;
        $this->currentPage=$currentPage;
        $this->field=$field;
        $this->offset=($this->currentPage-1)*$this->listRows;
        $this->count();
    }

    /**
     * 获取记录
     * @return array
     */
    public function data(){
        $sql="select $this->field from $this->table $this->query limit $this->offset,$this->listRows";
        $res=Db::query($sql);
        $data=[
            'items'=>$res, //查询结果
            'currentPage'=>$this->currentPage,//当前页码
            'total' => $this->total, //记录总数
            'totalPage' => $this->pageNum //总页数
        ];
        return $data;
    }

    /**
     * 获取总数
     */
    private function count(){
        $sql="select count(*) as count from $this->table $this->query";
        $count=Db::query($sql);
        $this->total=$count[0]['count'];
        $this->pageNum = ceil($this->total / $this->listRows);
    }
}