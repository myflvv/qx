<?php
namespace app\index\model;
use think\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ExportModel extends Model{

    public static function export($type,$headerArr,$dataArr){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $cell='A';
        foreach ($headerArr as $val){
            $sheet->setCellValue($cell.'1',$val);
            $cell++;
        }
        $row=2;
        foreach ($dataArr as $val){
            foreach ($val as $v){
                $dataCell='A';
                foreach ($v as $sv){
                    $sheet->setCellValue($dataCell.$row,$sv);
                    $dataCell++;
                }
                $row++;
            }
        }
//        $filename=$type.'-'.date('Ymd',time()).'.xlsx';
//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header('Content-Disposition: attachment;filename="'.$filename.'"');
//        header('Cache-Control: max-age=0');
//        // If you're serving to IE 9, then the following may be needed
//        header('Cache-Control: max-age=1');
//
//        // If you're serving to IE over SSL, then the following may be needed
//        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//        header('Pragma: public'); // HTTP/1.0
//
//        $writer = new Xlsx($spreadsheet);
//        $writer->save('php://output');
//        exit;
        $filename=$type.'.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save('excel/'.$filename);
    }
}