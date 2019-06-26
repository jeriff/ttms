<?php
    /*
     * 	报表管理
     *  author:jason.guo	 
     * 	updata:2012-08-30
     */
require_once './Common/enumeration.class.php';
import("@.ORG.User");
header("Content-type: text/html; charset=utf-8");
class ReportAction extends Action {
    /*
     * 	报表管理任务报表
     *  author:jason.guo	 
     * 	updata:2012-08-30
     */
    public function user_task()
	{
		/*生成下拉菜单类*/
		$enum = new Enumeration(); 
		$report = D("report");
		$week_time = $_GET['week_time'];
		$this->assign("week_time",$week_time);
		$date_arr = explode(" ",$week_time);
		/*任务频率，默认为week*/
		$task_frequency = $_GET['task_frequency'] == '' ? "week" : $_GET['task_frequency'];
		/*时间转换*/
		$date_time = $date_arr[0] == '' ? date("Y-m-d") : $date_arr[0];
		$week_arr = D("task")->check_time($task_frequency,$date_time);
		$list = $report->getListTask($week_arr);
		$this->assign("list",$list);
		/*flsh插件生成柱状图*/
		if($list){
			foreach($list as $key=>$value){
				$string1 .= '<category name="'.$value['operator'].'"/>';
				$string2 .= '<set value="'.$value['man_day'].'"/>';
				$string3 .= '<set value="'.$value['actual_man_day'].'"/>';
			}
			$res = '<graph xaxisname="日期" yaxisname="Time" hovercapbg="DEDEBE" hovercapborder="889E6D" rotateNames="0" yAxisMaxValue="60" numdivlines="5" divLineColor="CCCCCC" divLineAlpha="80" decimalPrecision="0" showAlternateHGridColor="1" AlternateHGridAlpha="30" AlternateHGridColor="CCCCCC" caption="工时统计">
			<categories font="Arial" fontSize="11" fontColor="000000">';
			$res .= $string1.'</categories><dataset seriesname="总计工时" color="56B9F9">'.$string2;
			$res .= '</dataset></graph>';
			$this->assign('data',$res);
		}
		$task_fre = array('week'=>'周任务','month'=>'月任务');
        $task_frequency = $enum->get_select($task_fre, 'task_frequency', 'task_frequency', $task_frequency, $size = 1, $class = '', $ext = '', $gettype = 2);
		$this->assign("task_frequency",$task_frequency);
		$this->assign("menu_name","icon_7");
		$this->display();
	}
    /*
     * 	报表管理任务统计
     *  author:jason.guo	 
     * 	updata:2012-08-30
     */
	public function task_count(){
		$simplifytask = D("simplifyTask");
		$user = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$created_by = $_POST['operator'] == '' ? $user : $_POST['operator'];
		$task_frequency = $_POST['task_frequency'] == '' ? 'week' : $_POST['task_frequency'];
		$week_time = $_POST['week_time'];
		$date_arr = explode(" ",$week_time);
		$date_time = $date_arr[0] == '' ? date("Y-m-d") : $date_arr[0];
		$week_arr = $simplifytask->check_time($task_frequency,$date_arr[0]);
		$map['_string'] = " (begin_time >= '".$week_arr[0]."' and begin_time<= '".$week_arr[1]."') or (end_time >= '".$week_arr[0]."' and end_time<= '".$week_arr[1]."')";
		
		$map['created_by'] = $created_by;
		$resp = '';
		$task_arr = C('task');
		$task_status = $simplifytask->where($map)->field("task_status,count(task_id) task_id")->group("task_status")->select();
		//dump($simplifytask->getLastsql());
		$resp .= '<td></td>';
		$resp .= '<td>任务状态:<br>';
		foreach($task_status as $key=>$value){
			$resp .= $task_arr['task_status'][$value['task_status']].":".$value['task_id']."条<br>";
		}
		$resp .= '</td>';
		$task_type = $simplifytask->where($map)->field("task_type,count(task_id) task_id")->group("task_type")->select();
		$resp .= '<td>任务类型:<br>';
		foreach($task_type as $key=>$value){
			$resp .= $task_arr['task_type'][$value['task_type']].":".$value['task_id']."条<br>";
		}
		$resp .= '</td>';
		echo $resp;
		//$this->display();
	}
    /*
     * 	数据导出
     *  author:jason.guo	 
     * 	date:2012-08-30
     */
	public function task_export(){
		$report = D("report");
		if($_GET){
			if(empty($_GET['export_type'])){
				die("<script>alert('导出类型不能为空！~');history.back(-1);</script>");
			}
			$task = D("task");
			$array = array();
			/*导出时间段，默认是本周*/
			if($_GET['week_time']){
				$week_time = $_GET['week_time'];
				$this->assign("week_time",$week_time);
				$date_arr = explode(" ",$week_time);
			}else{
				$date_arr[0] = date("Y-m-d");
			}
			/*导出指定用户的任务，默认是全部*/
			if($_GET['operator'] == '' || $_GET['operator'] == 'quanbu')//执行人
			{
				$operator = 'quanbu';
				$this->assign('operator', $operator);
			}else{
				$operator = $_GET['operator'];
				$where['operator'] = array('like','%'.$operator.'%');
				$this->assign('operator', $operator);
			}
			/*时间转换，转换为周的日期时间段*/
			$week_arr = $task->check_time("week",$date_arr[0]);
			/*任务导出，以任务为主键导出*/
			if($_GET['export_type'] == 1){
				$field = array('operator','task_name','task_type','task_status','begin_time','over_time','actual_man_day','task_subject');
				$where['parent_id'] = 0;
				$where['_string'] = " (begin_time >= '".$week_arr[0]."' and begin_time<= '".$week_arr[1]."') or (end_time >= '".$week_arr[0]."' and end_time<= '".$week_arr[1]."')";
				$task_list = $task->where($where)->order('operator')->field($field)->select();
				/*获取导出字段的列名*/
				$array[0] = $report->getHeaderArray(1);
				/*获取导出字段的列名*/
				$task_arr = C('task');
				if(!empty($task_list)){
					foreach($task_list as $key=>$value){
						$value['task_type'] = $task_arr['task_type'][$value['task_type']];
						$value['task_status'] = $task_arr['task_status'][$value['task_status']];
						$array[] = $value;
					}
				}
				$log_array['type'] = '任务导出';
			}
			/*任务导出，以人为主键导出任务工时统计*/
			if($_GET['export_type'] == 2){
				/*获取导出的数据*/
				$task_list = $report->getListTask($week_arr);
				/*获取导出字段的列名*/
				$array[0] = $report->getHeaderArray(2);
				if(!empty($task_list)){
					foreach($task_list as $key=>$value){
						unset($value['userid']);
						$array[] = $value;
					}
				}
				$log_array['type'] = '任务统计导出';
			}
			//dump($array);die();
			$return_export = D('Report')->export($array,'./public/export/');
			if($return_export['status'] == 1){
				$log_array['start_time'] = $week_arr[0];
				$log_array['end_time'] = $week_arr[1];
				$log_array['modified'] = date("Y-m-d H:i:s");
				$log_array['modified_by'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
				$log_array['name'] = $operator;
				$log_array['url'] = $return_export["url"];
				$log_array['filename'] = $return_export["filename"];
				M("report_log")->add($log_array);
				die('<script>alert("成功！~");window.location="?m=report&a=task_export";</script>');
			}else{
				die("<script>alert('导出失败！~');window.history.go(-1);</script>");
			}
		}
		$list_arr = $report->getLog();
		$this->assign('list',  $list_arr['list']);
		$this->assign('page', $list_arr['show']);
		/*生成下拉菜单类*/
		$enum = new Enumeration(); 
		$export_tp_arr = array('1'=>'任务导出','2'=>'任务统计导出');
        $export_type = $enum->get_select($export_tp_arr, 'export_type', 'export_type', $_GET['export_type'], $size = 1, $class = '', $ext = '', $gettype = 2);
		$this->assign('export_type',  $export_type);
		/*树形结构的人员列表*/
		$operator_arr = new SysUser();
		$listparent = $operator_arr->get_optname($mark = '┣', $parentid = 0,$operator);
		$listparent = '<select name="operator" id="operator"><option value="quanbu">全部</option>' . $listparent . '</select>';
		$this->assign('listparent',  $listparent);
		$this->assign("menu_name","icon_7");
		$this->display();
	}
}
?>