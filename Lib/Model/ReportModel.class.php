<?php
    /*
     * 	报表管理
     *  author:jason.guo	 
     * 	date:2012-08-10
     */
class ReportModel extends Model {
    /*     * ************************************************************************************************************** */
    /*
     * 	得到任务数据
	 *  $week_arr 时间区间
     *  author:jason.guo	 
     * 	date:2012-08-10
     */
	public function getListTask($week_arr){
		$sql = "SELECT b.userid,a.created_by operator,count(a.task_id) task_id,sum(a.man_day) man_day,sum(a.true_man_day) true_man_day FROM `ttms_simplify_task` a,ttms_user b WHERE ((begin_time >= '".$week_arr[0]."' AND begin_time <= '".$week_arr[1]."')OR(end_time >= '".$week_arr[0]."' AND end_time <= '".$week_arr[1]."')) AND a.created_by=b.username GROUP BY a.created_by";
		$list = D("task")->query($sql);
		return $list;
	}
    /*
     * 	数据导出列名
     *  author:jason.guo	 
     * 	date:2012-08-30
     */
	public function getHeaderArray($type){
		$array[1] = array(
			'created_by' => '任务执行人',
			'task_name' => '任务名称',
			'task_type' => '任务类型',
			'task_status' => '任务状态',
			'begin_time' => '开始时间',
			'end_time' => '结束时间',
			'remark' => '任务描述',
		);
		$array[2] = array(
			'created_by' => '任务执行人',
			'task_id' => '任务数量',
			'man_day' => '执行总工时',
		);
		return $array[$type];
	}
    /*
     * 	数据导出
	 *  $data 为需要导出的数组，第一个元素为头
	 *	$export_url 为导出地址，相对路径为从项目目录下开始
     *  author:jason.guo	 
     * 	date:2012-08-30
     */
	public function export($data,$export_url){
		/*导出数量*/
        $intTotalRowss = 0;
		/*成功导出条数*/
        $intSuccessRowss = 0;
		$intTotalRows = count($data);
		$file_count=array();
		foreach($data[0] as $key=>$value){
			$file_count[] = $key;
		}
		require_once './Common/columns.lib.php';
		if($intTotalRows > 1){
			/*计算列数量*/
			$End_Columns = $Excel_Columns[sizeof($file_count)-1];
			$EndIndex = array_search($End_Columns, $Excel_Columns);
			set_include_path($export_url);
			/*导入excel类*/
            require_once './Common/PHPExcel.php';
			/*用于 excel-2007 格式*/
            require_once './Common/PHPExcel/Writer/Excel2007.php'; 
			$objExcel = new PHPExcel();
            $objWriter = new PHPExcel_Writer_Excel2007($objExcel);
			//for($j=0;$j<3;$j++){
			$objActSheet = $objExcel->getActiveSheet();
			$objExcel->setActiveSheetIndex(0);
			//$objExcel->createSheet($j);
			//$objExcel->setActiveSheetIndex($j);
			//$objActSheet->setTitle('jason'.$j); 
				for ($i = 0; $i < count($data); $i++) {
					foreach ($file_count as $key => $value) {
						$objActSheet->setCellValueExplicit($Excel_Columns[$key].($i + 1), $data[$i][$value], PHPExcel_Cell_DataType::TYPE_STRING);
					}
					$intSuccessRows++;
				}
			//}
			$intSuccessRowss = $intSuccessRows - 1;
			$FileName = date('YmdHis') . ".xlsx";
			$intTotalRowss = $intTotalRows;
			try {
				/*把内容写入文件*/
				ob_end_clean();
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename="'.$FileName.'"');
				header('Cache-Control: max-age=0');				
				$objWriter->save('php://output');
				//$objWriter->save($export_url.$FileName);
			} catch(Exception $e) {
				return array('status'=>0,'massage'=>'失败！~'.$e);exit;
			}
			unset($objExcel);
			$url = ($export_url. $FileName);
			return array('status'=>1,'url'=>$url,'filename'=>$FileName,'massage'=>'成功！~');
		}else{
			return array('status'=>0,'massage'=>'没有符合条件的数据~');
		}
		
	}
    /*
     * 	导入导出日志列表
     *  author:jason.guo	 
     * 	date:2012-08-30
     */
	public function getLog(){
		/*导入分页类*/
		import("@.ORG.Page"); 
		$count =M("report_log")->count();
		$page = new Page($count, 20);
		$show = $page->show();
		$list = M("report_log")->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();
		//dump($this->getLastsql());
        return array('list'=>$list,'show'=>$show);
	}
}
?>