<?php
namespace app\bhadmin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Excel extends Common
{
    //导出
    public function export(){
        $xlsData = Db('message')->field('topic,tel,date')->select();
        Vendor('PHPExcel');//调用类库,路径是基于vendor文件夹的
        Vendor('PHPExcel.Worksheet.Drawing');
        Vendor('PHPExcel.Writer.Excel2007');
        $objExcel = new \PHPExcel();
        //set document Property
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
 
        $objActSheet = $objExcel->getActiveSheet();
        $key = ord("A");
        $letter =explode(',',"A,B,C,D,E,F");
        $arrHeader = array('姓名','手机号','日期');
        //填充表头信息
        $lenth =  count($arrHeader);
        for($i = 0;$i < $lenth;$i++) {
            $objActSheet->setCellValue("$letter[$i]1","$arrHeader[$i]");
        };
        //填充表格信息
        foreach($xlsData as $k=>$v){
            $k +=2;
            $objActSheet->setCellValue('A'.$k,"\t".$v['topic']."\t");
            $objActSheet->setCellValue('B'.$k,"\t".$v['tel']."\t");
            // // 图片生成
            // $objDrawing[$k] = new \PHPExcel_Worksheet_Drawing();
            // $objDrawing[$k]->setPath('public/static/admin/images/profile_small.jpg');
            // // 设置宽度高度
            // $objDrawing[$k]->setHeight(40);//照片高度
            // $objDrawing[$k]->setWidth(40); //照片宽度
            // /*设置图片要插入的单元格*/
            // $objDrawing[$k]->setCoordinates('C'.$k);
            // // 图片偏移距离
            // $objDrawing[$k]->setOffsetX(30);
            // $objDrawing[$k]->setOffsetY(12);
            // $objDrawing[$k]->setWorksheet($objPHPExcel->getActiveSheet());
            // 表格内容
            $objActSheet->setCellValue('C'.$k,date('Y年m月d日',strtotime($v['date'])));
            // $objActSheet->setCellValue('D'.$k, $v['email']);
            // $objActSheet->setCellValue('E'.$k, $v['statuid'] == 1?'正常':'失效');
 
 
            // 表格高度
            $objActSheet->getRowDimension($k)->setRowHeight(20);
        }
 
        $width = array(20,20,15,10,10,30,10,15);
        //设置表格的宽度
        $objActSheet->getColumnDimension('A')->setWidth($width[5]);
        $objActSheet->getColumnDimension('B')->setWidth($width[1]);
        $objActSheet->getColumnDimension('C')->setWidth($width[0]);
        $objActSheet->getColumnDimension('D')->setWidth($width[5]);
        $objActSheet->getColumnDimension('E')->setWidth($width[5]);
 
 
        $outfile = "报名表.xls";
        ob_end_clean();
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outfile.'"');
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }
    //导入
    public function savestudentImport(){  

        //import('phpexcel.PHPExcel', EXTEND_PATH);//方法二  

        vendor("PHPExcel.PHPExcel");  

        $objPHPExcel = new \PHPExcel();  

          $themeid=input('post.themeid');//导入数据类型

        //获取表单上传文件  

        $file = request()->file('excel');  

        $info = $file->validate(['size'=>1567800,'ext'=>'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'excel');  

        if($info){  

            $exclePath = $info->getSaveName();  //获取文件名  

            $file_name = ROOT_PATH . 'public' . DS . 'excel' . DS . $exclePath;   //上传文件的地址  

            $objReader =\PHPExcel_IOFactory::createReader('Excel5');  

            $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8  

            echo "<pre>";  

            $excel_array=$obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式  

            array_shift($excel_array);  //删除第一个数组(标题);  

             

            $data = [];  

            $i=0;  

            foreach($excel_array as $k=>$v) {  

                 

                $data[$k]['title'] = $v[1]; 

                $data[$k]['optiona'] = $v[2];   

                $data[$k]['optionb'] = $v[3];   

                $data[$k]['optionc'] = $v[4];   

                $data[$k]['optiond'] = $v[5];   

                $data[$k]['optione'] = $v[6];   

                $data[$k]['optionf'] = $v[7];   

                $data[$k]['time']    = date('Y-m-d H:i:s',time());

                $data[$k]['themeid'] = $themeid;

                $i++;  

            }  

           $success=Db::name('sleeptopic')->insertAll($data); //批量插入数据  

           //$i=  

           $error=$i-$success;  

            echo "总{$i}条，成功{$success}条，失败{$error}条。";  

           // Db::name('t_station')->insertAll($city); //批量插入数据  

        }else{  

            // 上传失败获取错误信息  

            echo $file->getError();  

        }  

   

    }
}
?>