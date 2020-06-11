<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/19
 * Time: 11:02
 */

namespace think\custom\lib;
/**
 * 导出类
 * @author msw
 * Class Export
 * @package think\custom\common
 * 调用方法
 * $export = new Export();
 * $export->export_to_excel($title,$data,$name)
 * $title = array(
 * 0=>array('订单号','姓名','手机号')
 * );
 * $data = array(
 * array('111','222','333'),
 * array('111','2223','3334'),
 * );
 * $name = '未支付订单';
 *
 */
class Export
{
    public function export_to_excel($title, $data, $name = '')
    {
        $setWidth   = '20';   // 单元格默认宽度
        $filename   = "$name" . date('Y-m-d-') . mt_rand(1000000, 9999999) . '.xlsx';
        $_sheet     = !empty($name)?$name:'Sheet1';
        $data       = array_merge($title, $data);
        $php_excel  = new \PHPExcel();

        $php_excel->setActiveSheetIndex(0);
        $php_sheet = $php_excel->getActiveSheet();
        $php_sheet->setTitle($_sheet);

        // 边框样式
        $border = array(
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN, //设置border样式 'color' => array ('argb' => 'FF000000'), //设置border颜色
                ),
            ),);

        // 示例数据
//        $data = array(
//            array(" 开票申请：开票申请编号"," 审批通过时间"," 开票申请：创建人"," 开票申请人编号"," 发票类型"," 主订单号"," 子订单号"," 甲方签约主体"," 客户"," 证件号"," 甲方开票地址"," 甲方公司电话"," 甲方开户银行"," 甲方开户银行账号"," 申请开票内容"," 子订单金额"," 申请开票金额"," 乙方签约主体"," 备注",),
//            array(  " ykpsq-00001",
//                " 2019-08-28 14:05:08",
//                " 陈春华",
//                " BJ00004",
//                " 增值税普通发票(电子)",
//                array(" 1567998047550"," 12345685588","ys12345655880",),
//                array("LA081567998047549276_549","ys1234565588","ys12345655880",),
//                " ",
//                " 中细软公司",
//                "2147483647",
//                " 北京市房山区长阳镇55号",
//                " 010-123456",
//                " 北京长阳支行",
//                " 622041716002523618",
//                " 服务费",
//                array(" 300.00"," 300.00"," 300.00"),
//                array(" 300.00"," 300.00"," 300.00"),
//                " 北京细软智谷",
//                " 备注",
//            ),
//            array ( " ykpsq-00002", " 2019-08-28 14:08:28", " 陈春华", " BJ00004", " 增值税普通发票(电子)", " 1565069070526", " BR01157180814633956_584", " ", " 中细软公司", "2147483647", " 北京市房山区长阳镇55号", " 010-123456", " 北京长阳支行", "622041716002523618", " 服务费", " 300.00", " 300.00", " 北京细软智谷", " 备注",),
//            array( " ykpsq-00003", " 2019-08-29 14:30:03", " 陈春华", " BJ00004", " 增值税普通发票(电子)", " 1565068001998", " LA081567998047549276_548", " ", " 乌兰图雅", "", " ", " ", " 工商银行北京支行房山分理处", "", " 服务费", " 300.00", " 300.00", " 北京细软智谷", " 请发顺丰",),
//            array(" ykpsq-00004"," "," "," "," 增值税普通发票(电子)",""," "," "," 中细软公司","2147483647"," "," "," ",""," 服务费"," 300.00"," 300.00"," 细软智谷"," ",),
//            array( " ykpsq-00005", " ", " ", " ", " 增值税普通发票(电子)", "", " ", " ", " 中细软公司", "2147483647", " ", " ", " ", "", " 服务费", " 300.00", " 300.00", " 细软智谷", "",),
//            array(" ykpsq-00006"," "," "," "," 增值税普通发票(电子)","12345685588"," ys12345655881"," "," 中细软公司","2147483647"," "," "," ",""," 服务费"," 300.00"," 300.00"," 细软智谷"," ",),
//            array( " ykpsq-00007", " ", " ", " ", " 增值税普通发票(电子)", "12345685588", " ys12345655882", " ", " 中细软公司", "2147483647", " ", " ", " ", "", " 服务费", " 300.00", " 300.00", " 细软智谷", "",),
//            array(" ykpsq-00008"," "," "," "," 增值税普通发票(电子)","12345685588"," ys12345655883"," "," 中细软公司","2147483647"," "," "," ",""," 服务费"," 300.00"," 300.00"," 细软智谷"," ",),
//        );


        $i = 0;// 定义偏移量，用在由于合并按行合并单元格时候产生的行偏移
        foreach ($data as $k => $v) {   // 行控制

            //// 判断数据格式，如果需要合并单元格，需要多个值的数组长度相同 start
            $_merge = $this->checkMerge($v);
            if (!$_merge[0]){
                return 'error'; //  数据格式错误
            }else{
                $_mergeLen = $_merge[1];    // 数据个数，需要合并（纵向合并/竖向合并)单元格的个数
            }
            //// 判断 end

            foreach ($v as $_k => $_v) {    // 列控制
                $_alpha = $this->_alpha($_k);   // 表格列(A、B、C)
                $_cel   = $_alpha . ($k + 1 + $i);     // 单元格

                // 单元格样式 start
                $php_sheet->getColumnDimension($_alpha)->setAutoSize(true);  // 自动设置宽度
                $php_sheet->getStyle($_cel)->applyFromArray($border);   // 设置表格边框
                if ($k == 0){
                    $php_sheet->getStyle($_cel)->getFont()->setBold(true);      //第一行设置加粗
                }

                if ($_merge[0] && $_merge[1]>1){    // 有合并单元格需要

                    // 需要合并单元格的行进行数据填充
                    if (is_array($_v)){
                        foreach ($_v as $_k_m=>$_v_m){
                            $_cel_m = $_alpha . ($k +1 + $i + $_k_m);
                            $php_sheet->getStyle($_cel_m)->applyFromArray($border);   // 设置表格边框
                            $php_sheet->setCellValue($_cel_m, $_v_m);
                        }
                    }else{

                        // 数据填充
                        $php_sheet->setCellValue($_cel, $_v);

                        // 单元格合并起始位置
                        $_cel_start = $_cel;    // 合并单元格 起始
                        $_cel_end = $_alpha . ($k + $i + $_mergeLen);    // 合并单元格 结束
                    }
                    $php_sheet->getStyle($_cel_start.":".$_cel_end)->applyFromArray($border);   // 设置表格边框
                    // 合并单元格
                    $php_sheet->mergeCells($_cel_start.":".$_cel_end);    // 合并单元格

                }else{

                    // 数据填充
                    $php_sheet->setCellValue($_cel, $_v);
                }
            }

            $i = $i + $_mergeLen -1;    // 修改循环行的偏移量
        }

        try {
            ob_end_clean();//清除缓冲区,避免乱码
            $php_writer = \PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
            $dir = "./static/" . $filename;
            $php_writer->save($dir);
            return $dir;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    /**
     * 检查数组是否复合合并单元格
     *      -- 检查数组元素是否多维，并且维度数是否一致。
     * @param $arr
     * @return
     */
    private function checkMerge($arr){

        $_arrLen = 1;   // 元素个数

        foreach ($arr as $k=>$v){
            if (is_array($v) && (count($v) == count($v,1))){
                if ($_arrLen>1){
                    if ($_arrLen != count($v)){
                        return array(false);
                    }
                }else{
                    $_arrLen = count($v);
                }
            }
        }

        return array(true,$_arrLen);
    }

    /**
     * 列计算器
     *  -   按excel列（a-z)循环计算
     * @param $value
     */
    private function _alpha($value){
        $_v = $value%26;    //余数
        if($value>25){
            $value = intval(floor($value/26))-1;   // 取整部分
            $_alpha = chr(65 + ($value)).chr(65 + ($_v));   // 表格列(A、B、C)
        }else{
            $_alpha = chr(65 + ($value));   // 表格列(A、B、C)
        }
        return $_alpha;
    }
}
