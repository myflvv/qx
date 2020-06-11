<?php

namespace app\activity\controller;

use think\Controller;
use think\Db;

/**
 * Class Activity
 * @package app\activity\controller
 */
class Activity extends Controller
{
    function __construct() {
        parent::__construct();
    }
    /**
     * SUK取出参加的规则
     * @SWG\Post(
     *     path="/activity/activity/getrule",
     *     summary="SUK取出参加的规则",
     *     description="SUK取出参加的规则",
     *     operationId="send",
     *     tags={"activity/activity"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="sku_id",
     *         in="formData",
     *         name="sku_id",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success",
     *     ),
     *     @SWG\Response(
     *         response=502,
     *         description="参数错误",
     *     ),
     *     security={{
     *     "apikey":{}
     *   }}
     * )
     */
    function postGetrule($sku_id)
    {
        if (empty((int)$sku_id)) {
            return _return(502);
        }
        /*-start------SKU查询满减规则------------start-*/
        $mj_sku_model = new \app\activity\model\Mjrulesku();
        $mj_data = $mj_sku_model->getAll(['sku_id' => $sku_id]);
        $rule_id_arr = [];
        foreach ($mj_data as $key => $value) {
            $rule_id_arr[] = $value['rule_id'];
        }

//        if (!$rule_id_arr) {
//            return _return(200);
        if ($rule_id_arr) {

            //取出所有规则的活动ID
            $rule_index_model = new \app\activity\model\Activityruleindex();
            //规则所在的活动路由表
            $map[] = ['rule_id', 'in', $rule_id_arr];
            $map[] = ['act_status', '=', '1'];
            $map[] = ['rule_type', '=', 'mj'];
            $act_rule_index_arr = $rule_index_model->where($map)->order(['id' => 'desc'])->select();
            $rule_id_arr = [];
            foreach ($act_rule_index_arr as $key => $value) {
                $rule_id_arr[] = $value['rule_id'];
            }
            if ($rule_id_arr) {

                $mj_condition_model = new \app\activity\model\Mjrulecondition();
                $mj_rule_list = $mj_condition_model->where('rule_id', 'in', $rule_id_arr)->order(['rule_id' => 'desc', 'type' => 'asc', 'condtion' => 'asc'])->select();
                if ($mj_rule_list) {
                    $rule_list = [];
                    $mj_rule_model = new \app\activity\model\Mjrule();
                    $act_model = new \app\activity\model\Activity();
                    foreach ($mj_rule_list as $key => $value) {

                        $rule_index = $rule_index_model->getOnce(['rule_id' => $value['rule_id'], 'rule_type' => 'mj']);
                        if (!$rule_index || $rule_index['act_status'] != 1) {
                            continue;
                        }
                        //查询活动是否绑定
                        if (empty($rule_index['act_id'])) {
                            continue;
                        }
                        //查询活动过期时间
                        $act_info = $act_model->get(['act_id' => $rule_index['act_id']]);
                        //当前时间是否在活动时间范围内
                        if (time() < $act_info['act_start_time'] || time() >= $act_info['act_end_time']) {
                            continue;
                        }

                        $rule_info = $mj_rule_model->getOnce(['id' => $value['rule_id']]);

                        $value['act_id'] = $act_info['act_id'];
                        $value['act_name'] = $act_info['act_name'];
                        $value['act_status'] = $act_info['act_status'];
                        $value['act_start_time'] = $act_info['act_start_time'];
                        $value['act_end_time'] = $act_info['act_end_time'];
                        $value['rule_type'] = 'mj';
                        $value['rule_code'] = $rule_info['rule_code'];
                        $value['rule_title'] = $rule_info['rule_title'];
                        $value['group'] = $rule_info['group'];
                        $value['sku_id'] = $sku_id;

                        $rule_list[] = $value;
                    }
                }
            }

            /*-end--------SKU查询满减规则--------------end-*/
        }


            /*-start------SKU查询满赠规则------------start-*/     // 待改进  by zuiw  2018.10.12

            $_rule_sql = " select b.code,b.title,b.type,b.condition_unit,b.id as bid,b.bind_activity_id from activity_mz_sku a left join activity_mz b on  a.rule_id=b.id where a.sku_id='$sku_id' and b.bind_activity_id<>'0' order by b.type asc ";
            $mz_rule_list = Db::query($_rule_sql);

            foreach($mz_rule_list as $k=>$v){

                $_value = array();
                if (!empty($v['bind_activity_id'])){

                    $_time = time();
                    $_act_info = Db::table('activity')->field('act_name,act_status,act_start_time,act_end_time')->where(" act_id='".$v['bind_activity_id']."' and act_del='0' and act_end_time>'$_time' ")->find();   // 活动信息
                    if (!empty($_act_info)){

                        // 判断赠品
                        $sql = " select a.mz_id,a.unit_value,b.gifts_name,b.unit_name,b.start_num,b.id as bid from activity_mz_gifts_relation a left join activity_mz_gifts b on a.gifts_id = b.id where b.initial_num>0 and b.is_delete='2' and a.mz_id=b.bind_mz_id and a.mz_id='".$v['bid']."' ";
                        $gifts = Db::query($sql);

                        foreach ($gifts as $_k=>$_v){
                            $_value['rule_id']       = $_v['mz_id'];   // 赠品id
                            $_value['act_name']      = $_act_info['act_name'];      // 活动名称
                            $_value['act_status']    = $_act_info['act_status'];  //
                            $_value['act_start_time']= $_act_info['act_start_time'];  //
                            $_value['act_end_time']  = $_act_info['act_end_time'];    //
                            $_value['rule_type']     = 'mz';

                            $_value['rule_code']     = $v['code'];
                            $_value['rule_title']    = $v['title'];
                            $_value['group']          = $v['type'];  // 1 单品满赠，2 分组满赠
                            $_value['unit']          = $v['condition_unit'];    // 1  总数量标准、2 总价格标准
                            $_value['unit_value']    = $_v['unit_value'];    //
                            $_value['gifts_name']    = $_v['gifts_name']; // 赠品名称
                            $_value['gifts_unit']    = $_v['unit_name']; // 赠品单元

                            $rule_list[] = $_value;
                        }
                    }
                }
            }

            /*-end--------SKU查询满赠规则--------------end-*/



        return _return(200,'success',$rule_list);
    }

    /**
     * 验证SKU 与规则是否可以使用
     * @SWG\Post(
     *     path="/activity/activity/checkrule",
     *     summary="验证SKU 与规则是否可以使用",
     *     description="验证SKU 与规则是否可以使用",
     *     operationId="send",
     *     tags={"activity/activity"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="sku_id",
     *         in="formData",
     *         name="sku_id",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="规则ID",
     *         in="formData",
     *         name="rule_id",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="规则类型  'mj'满减，'mz'满赠",
     *         in="formData",
     *         name="rule_type",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="规则内细则 例满减：'1'满N件N折，'2'满N件减N元，'3'满N元N折，'4'满N元减N元，'5'每满N件减N元，'6'每满N元减N元，7满N件单价设置N元",
     *         in="formData",
     *         name="type",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="规则内细则ID",
     *         in="formData",
     *         name="sub_id",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success",
     *     ),
     *     @SWG\Response(
     *         response=502,
     *         description="参数错误",
     *     ),
     *     security={{
     *     "apikey":{},
     *   }}
     * )
     */
    function postCheckrule($sku_id,$rule_id,$rule_type,$type,$sub_id='')
    {
        if (empty((int)$sku_id)|| empty((int)$rule_id)||empty($rule_type)) {
            return _return(502);
        }
        $rule_index_model = new \app\activity\model\Activityruleindex();
        if($rule_type=='mj'){
            /*-start------SKU查询满减规则------------start-*/
            $mj_sku_model= new \app\activity\model\Mjrulesku();
            $rule_sku = $mj_sku_model->getOnce(['rule_id'=>$rule_id,'sku_id'=>$sku_id]);
            if(!$rule_sku){
                return _return(200,'success',[]);
            }
            $mj_condition_model = new \app\activity\model\Mjrulecondition();
            if(empty($sub_id)){
                $condition = $mj_condition_model->getAll(['rule_id'=>$rule_id,'type'=>$type]);
            }else{
                $condition = $mj_condition_model->getAll(['id'=>$sub_id,'rule_id'=>$rule_id,'type'=>$type]);
            }
          //  dump($condition);

            /*-end--------SKU查询满减规则--------------end-*/
        }elseif ($rule_type=='mz'){

            /*-start------SKU查询满赠规则------------start-*/

            // 参数释义：
            //  sku_id
            //  rule_id: 赠品id
            //  rule_type: mz
            //  type: 1 单品满赠，2 分组满赠

            $_rule_sql = " select b.code,b.title,b.type,b.condition_unit,b.id as bid,b.bind_activity_id from activity_mz_sku a left join activity_mz b on  a.rule_id=b.id where a.sku_id='$sku_id' and b.bind_activity_id<>'0' order by b.type asc ";
            $mz_rule_list = Db::query($_rule_sql);

            $rule_list = [];
            foreach($mz_rule_list as $k=>$v){

                $_value = array();
                if (!empty($v['bind_activity_id'])){

                    $_time = time();
                    $_act_info = Db::table('activity')->field('act_name,act_status,act_start_time,act_end_time')->where(" act_id='".$v['bind_activity_id']."' and act_del='0' and act_end_time>'$_time' ")->find();   // 活动信息
                    if (!empty($_act_info)){

                        // 判断赠品
                        $sql = " select a.mz_id,a.unit_value,b.gifts_name,b.unit_name,b.start_num,b.id as bid from activity_mz_gifts_relation a left join activity_mz_gifts b on a.gifts_id = b.id where b.initial_num>0 and b.is_delete='2' and a.mz_id=b.bind_mz_id and a.mz_id='".$v['bid']."' ";
                        $gifts = Db::query($sql);

                        foreach ($gifts as $_k=>$_v){
                            $_value['rule_id']       = $_v['mz_id'];   // 赠品id
                            $_value['act_name']      = $_act_info['act_name'];      // 活动名称
                            $_value['act_status']    = $_act_info['act_status'];  //
                            $_value['act_start_time']= $_act_info['act_start_time'];  //
                            $_value['act_end_time']  = $_act_info['act_end_time'];    //
                            $_value['rule_type']     = 'mz';

                            $_value['rule_code']     = $v['code'];
                            $_value['rule_title']    = $v['title'];
                            $_value['group']          = $v['type'];  // 1 单品满赠，2 分组满赠
                            $_value['unit']          = $v['condition_unit'];    // 1  总数量标准、2 总价格标准
                            $_value['unit_value']    = $_v['unit_value'];    //
                            $_value['gifts_name']    = $_v['gifts_name']; // 赠品名称
                            $_value['gifts_unit']    = $_v['unit_name']; // 赠品单元

                            $rule_list[] = $_value;
                        }
                    }
                }
            }

            return _return(200,'success',$rule_list);

            /*-end--------SKU查询满赠规则--------------end-*/
        }
        $rule_index = $rule_index_model->getOnce(['rule_id'=>$rule_id,'rule_type'=>$rule_type]);
        if(!$rule_index || $rule_index['act_status'] !=1){
            return _return(200,'success',[]);
        }
        //查询活动是否绑定
        if(empty($rule_index['act_id'])){
            return _return(200,'success',[]);
        }
        //查询活动过期时间
        $act_model = new \app\activity\model\Activity();
        $act_info = $act_model->get(['act_id'=>$rule_index['act_id']]);
        if(time()>=$act_info['act_end_time']){
            return _return(200,'success',[]);
        }
        $rule_list = [];
        foreach($condition as $key=>$value){
            $value['act_id']=$act_info['act_id'];
            $value['act_name']=$act_info['act_name'];
            $value['act_status']=$act_info['act_status'];
            $value['act_start_time']=$act_info['act_start_time'];
            $value['act_end_time']=$act_info['act_end_time'];

            $value['rule_type']=$rule_index['rule_type'];
            $value['rule_code']=$rule_index['rule_code'];
            $value['rule_title']=$rule_index['rule_title'];
            $value['group']=$rule_index['group'];
            $value['sku_id']=$sku_id;
            $rule_list[] = $value;
        }
        return _return(200,'success',$rule_list);
    }
}
