<?php
/*
 * 	任务管理模块
 *  author:jason.guo	 
 * 	date:2012-08-3
 */
require_once './Common/enumeration.class.php';
require_once './Common/phpmailer/class.phpmailer.php';
header("Content-type: text/html; charset=utf-8");
import("@.ORG.User");
class TaskAction extends Action {

    /*
     * 	任务列表
     *  author:jason.guo	 
     * 	date:2012-08-3
     */
    //任务列表
    public function index()
	{
		/*
		*默认显示当天
		*点击显示上一周下一周
		*/
		//dump($_GET);
		//echo "<script>setTimeout(parent_redirect('".$url."'),2000);</script>";
		$user = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$this->assign('user',$user);
		$enum = new Enumeration(); //生成下拉菜单类
		//判断是否为管理员
		$userid = $_COOKIE[C('COOKIE_PREFIX') . 'userid'];
		$user_parentid=D('user')->where('userid='.$userid)->select();
		$this->assign('is_admin',$user_parentid[0]['is_admin']);
        //查询条件
		if (!empty($_REQUEST['task_priority'])) {
			$map['task_priority'] = $_REQUEST['task_priority']; //任务类型
			$this->assign('task_priority', $map['task_priority']);
		}
		if (!empty($_REQUEST['task_status'])) {
			$map['task_status'] = $_REQUEST['task_status']; //任务状态
			$this->assign('task_status', $map['task_status']);
		}
		/*if (!empty($_REQUEST['assignment'])) {
			$map['assignment'] = $_REQUEST['assignment']; //分配人
			$this->assign('assignment', $map['assignment']);
		}*/
		$self = $_GET['self'] == '' ? 'myself' : $_GET['self'];
		$this->assign('self',$self);
        //用户结构
		if($self == 'myself'){
			if($_GET['asop_name'] == '')//执行人
			{
				$asop_name = $user;//默认显示当前登录用户
				$map['operator'] = array('like','%'.$asop_name.'%');
				$this->assign('asop_name', $asop_name);
			}else if($_GET['asop_name'] == 'quanbu'){
				$asop_name = 'quanbu';
				$this->assign('asop_name', $asop_name);
			}else{
				$asop_name = $_GET['asop_name'];
				$map['operator'] = array('like','%'.$asop_name.'%');
				$this->assign('asop_name', $asop_name);
			}
		}
		if($self == 'related'){
			if($_GET['asop_name'] == '')//分配人
			{
				$asop_name = $user;//默认显示当前登录用户
				$map['assignment'] = array('like','%'.$asop_name.'%');
				$this->assign('asop_name', $asop_name);
			}else if($_GET['asop_name'] == 'quanbu'){
				$asop_name = 'quanbu';
				$this->assign('asop_name', $asop_name);
			}else{
				$asop_name = $_GET['asop_name'];
				$map['assignment'] = array('like','%'.$asop_name.'%');
				$this->assign('asop_name', $asop_name);
			}
			//$map['assignment'] = array('like','%'.$user.'%');
		}
		$task = new SysUser();
		$listparent = $task->get_optname($mark = '┣', $parentid = 0,$asop_name);
		$listparent = '<select name="asop_name" id="asop_name"><option value="quanbu">全部</option>' . $listparent . '</select>';
		$this->assign('listparent',  $listparent);
		//默认是本周
		$num = $_REQUEST['num'] == '' ? 0 : $_REQUEST['num'];
		$date = D('Task')->getWeekList($num);//周时间转换
		$this->assign('date', $date);
		$this->assign('num', $num);
		/*
		*如果开始时间和结束时间有一个在所查的时间断内就显示出来
		*/
		$map['_string'] = " (begin_time >= '".$date['begin_time']." 00:00:00' and begin_time<= '".$date['end_date']." 23:59:59') or (end_time >= '".$date['begin_time']." 00:00:00' and end_time<= '".$date['end_date']." 23:59:59')";
		//dump($map);
		$list = D('Task')->getTaskList($map);
		//dump(D('Task')->getLastsql());
		$this->assign('list', $list['list']);
		$this->assign('page', $list['show']);
		//任务权限
		//$list_purview = D('Task')->getListPurview($list['list'],$user);
		if($list['list']){
			foreach($list['list'] as $key=>$value){
				$search_list['man_day'] += $value['man_day'];
				$search_list['actual_man_day'] += $value['actual_man_day'];
			}
		}
		$this->assign('search_list', $search_list);
		//得到task
		$task = C('task');
		$this->assign('task', $task);
		//任务类型
        $task_priority = $enum->get_select($task['task_priority'], 'task_priority', 'task_priority', $map['task_priority'], $size = 1, $class = '', $ext = '', $gettype = 2);
		//任务状态
        $task_status = $enum->get_select($task['task_status'], 'task_status', 'task_status', $map['task_status'], $size = 1, $class = '', $ext = '', $gettype = 2);
		$this->assign('task_priority', $task_priority);
		$this->assign('task_status', $task_status);
        $this->m = 'task';
        $this->a = 'index';
		$this->assign('menu_name','icon_2');
		$this->display();
	}
    /*
     * 	子任务查看
	 *	ajax操作
     *  author:jason.guo	 
     * 	date:2012-08-3
     */
	public function seed_view()
	{
		$user = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$this->assign('user',$user);
		$num = $_REQUEST['num'] == '' ? 0 : $_REQUEST['num'];
		$date = D('Task')->getWeekList($num);
		$where['_string'] = " (begin_time >= '".$date['begin_time']."' and begin_time<= '".$date['end_date']."') or (end_time >= '".$date['begin_time']."' and end_time<= '".$date['end_date']."')";
		$where['parent_id'] = $_REQUEST['task_id'];
		//$where['operator'] = $_REQUEST['operator'];
		$seed_task = D('Task')->where($where)->findAll();
		$this->assign('seed_task', $seed_task);
		$task = C('task');
		$this->assign('task', $task);
		$this->display();
	}
	//检查用户  备用
	public function check_executor()
	{
		/*
		*检查执行人，任务发起人是否有权限把任务分配给执行人
		*执行人在此段时间是否空闲
		*/
		$user = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$array = $_REQUEST;
		$return_executor = D('Task')->check_executor($user,$array);
		if($return_executor['status'] == '0'){
			$this->ajaxReturn($return_executor,'失败',0);
		}else if($return_executor['status'] == '1'){
			//符合要求返回执行人的任务信息。
			$return_user = D('Task')->get_task($array['executor']);
			$this->ajaxReturn($return_user,'成功',1);
		}
	}
    /*
     * 	例行任务添加
	 *	遍历需要添加的例行任务，每个例行任务在遍历一周，每天添加一次
	 *	例行任务时间都是每天上午的9点到9:30
     *  author:jason.guo	 
     * 	date:2012-08-3
     */
	public function add_select()
	{
		//self::task_mail();die();	email_check
		if($_POST){
			$username = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
			$date = date('Y-m-d H:i:s');
			$week_arr = D("task")->check_time("week",$date);
			$where['task_name'] = array('in',$_POST['task_name']);
			$where['operator'] = $username;
			$where['created'] = array(array('egt',$week_arr[0]),array('elt',$week_arr[1]));
			$opt_task = D('Task')->where($where)->findAll();
			if(empty($opt_task)){
				$date_arr = D('Task')->getWeekList(0);
				$operator_arr[0] = $username;
				$array = array(
					'project_id'=>0,
					'task_priority'=>'1',
					'task_attribute'=>'1',
					'task_type'=>'1',
					'task_biling'=>'2',
					'task_biling_type'=>'1',
					'task_subject'=>'日常任务',
					'assignment'=>$username,
					'operator'=>$operator_arr,
					'man_day'=>'2.5',
					'begin_time'=>$date_arr['begin_time'].' 09:00:00',
					'end_time'=>$date_arr['end_date'].' 09:30:00',
					//'begin_time'=>'2012-11-05 09:00:00',
					//'end_time'=>'2012-11-09 09:30:00',
					'espiration_time'=>'',
					'task_status'=>'2',
					'remark'=>'日常任务',
					'created'=>$date,
					'created_by'=>$username,
					'modified'=>$date,
					'modified_by'=>$username,
				);
				//遍历需要添加的任务名称
				foreach($_POST['task_name'] as $key=>$value){
					$array['task_name'] = $value;
					$return_task = D('Task')->TaskAdd($array);
				}
				die("<script>alert('生成成功');window.location='?m=task&a=index'</script>");
				//die("<script>alert('".$return_task['message']."');window.location='?m=task&a=index';</script>");
			}else{
				die("<script>alert('例行任务不能重复添加！');window.location='?m=task&a=index'</script>");
			}
		}
		$this->display();
	}
    /*
     * 	任务添加
	 *	包括父级任务和子任务的添加
     *  author:jason.guo	 
     * 	date:2012-08-3
     */
	public function add()
	{
		/*
		*1.检查是否是有此用户
		*2.检查此用户是否有权限及权限是否足够
		*/
		$enum = new Enumeration(); //生成下拉菜单类
		$userid = $_COOKIE[C('COOKIE_PREFIX') . 'userid'];
		$username = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		if($_GET){
			$task_id = $_GET['task_id'];
			$add_seed_value = D('Task')->where("task_id=".$task_id)->findAll();
			$add_seed_value[0]['act'] = $_GET['act'];
			if($_GET['act'] == 'add'){
				$last_add = D('Task')->where("parent_id=".$task_id)->sum('man_day');
				$last_man_day = $add_seed_value[0]['man_day'] - $last_add;
				$this->assign('last_man_day',$last_man_day);
			}
			$this->assign('add_seed_value',$add_seed_value[0]);
		}
		if($_POST){
			/*
			*检查执行人，任务发起人是否有权限把任务分配给执行人
			*执行人在此段时间是否空闲
			*/
			$array = $_REQUEST;
			if(is_array($array) && !empty($array)){
				if($array['man_day'] > 8){
					die("<script>alert('添加任务预计工时不能大于8小时，请拆分任务从新添加！');window.history.go(-1);</script>");
				}
				if($array['act'] == 'add' && $array['man_day'] > $array['last_man_day']){
					die("<script>alert('添加失败，剩余预计工时不足');window.history.go(-1);</script>");
				}else{
					unset($array['last_man_day']);
				}
				$return_executor = D('Task')->check_executor($userid,$array);
				if($return_executor['status'] == '0'){
					die("<script>alert('".$return_executor['message']."');window.history.go(-1);</script>");
					//$this->ajaxReturn($return_executor,'失败',0);
				}else if($return_executor['status'] == '1'){
					/*
					*用户可以添加任务
					*只可以分配给本人和下级用户
					*默认分配给当前用户
					*/
					$return_task = D('Task')->ordinaryTaskAdd($array);
					//$return_task = D('Task')->TaskAdd($array);
					if($return_task['status'] == '1' ){
					die("<script>alert('任务添加成功');window.location='?m=task&a=index';</script>");
						/*$return_mail = self::task_mail($return_task['task_id'],$return_task['message']);
						if($return_mail['status'] == '1'){
							die("<script>alert('任务添加成功，邮件已发送');window.location='?m=task&a=index';</script>");
						}else{
							die("<script>alert('任务添加成功，".$return_mail['message']."');window.location='?m=task&a=index';</script>");
						}*/
					}else{
						die("<script>alert('任务添加失败');window.history.go(-1);</script>");
					}
				}
			}
		}
		$task = C('task');
		$this->assign('task', $task);
		//任务状态
		$add_seed_value[0]['task_status'] = $add_seed_value[0]['task_status'] == '' ? '1' : $add_seed_value[0]['task_status'];
        $task_status = $enum->get_radio($task['task_status'], 'task_status', 'task_status', $add_seed_value[0]['task_status'], $size = 2, $class = '', $ext = '',$width = 150, $gettype = 2);
		//任务优先级
		$add_seed_value[0]['task_priority'] = $add_seed_value[0]['task_priority'] == '' ? '2' : $add_seed_value[0]['task_priority'];
		$task_priority = $enum->get_radio($task['task_priority'], 'task_priority', 'task_priority', $add_seed_value[0]['task_priority'], $size = 2,$class = '', $ext = '',$width = 150, 2);
		//任务属性
		$add_seed_value[0]['task_attribute'] = $add_seed_value[0]['task_attribute'] == '' ? '1' : $add_seed_value[0]['task_attribute'];
		$task_attribute = $enum->get_radio($task['task_attribute'], 'task_attribute', 'task_attribute', $add_seed_value[0]['task_attribute'], $size = 2, $class = '', $ext = '',$width = 150, 2);
		//是否收费
		$add_seed_value[0]['task_biling'] = $add_seed_value[0]['task_biling'] == '' ? '2' : $add_seed_value[0]['task_biling'];
		$task_biling = $enum->get_radio($task['task_biling'], 'task_biling', 'task_biling', $add_seed_value[0]['task_biling'], $size = 2,$class = '', $ext = '',$width = 150, $gettype = 2);
		//任务范围
		$add_seed_value[0]['task_biling_type'] = $add_seed_value[0]['task_biling_type'] == '' ? '1' : $add_seed_value[0]['task_biling_type'];
		$task_biling_type = $enum->get_radio($task['task_biling_type'], 'task_biling_type', 'task_biling_type', $add_seed_value[0]['task_biling_type'], $size = 3,$class = '', $ext = '',$width = 150, $gettype = 2);
		//收费标准
		$task_biling_money = $enum->get_radio($task['task_biling_money'], 'task_biling_money', 'task_biling_money', $add_seed_value[0]['task_biling_money'], $size = 5, $class = '', $ext = '',$width = 150, $gettype = 2);
		//任务类型
		$add_seed_value[0]['task_type'] = $add_seed_value[0]['task_type'] == '' ? '2' : $add_seed_value[0]['task_type'];
		$task_type = $enum->get_radio($task['task_type'], 'task_type', 'task_type', $add_seed_value[0]['task_type'], $size = 2, $class = '', $ext = '',$width = 150, $gettype = 2);
		//任务类别Category
		$task_category = $enum->get_radio($task['task_category'], 'task_category', 'task_category', $add_seed_value[0]['task_category'], $size = 7, $class = '', $ext = '',$width = 140, $gettype = 2);
		$this->assign('task_category', $task_category);
		$this->assign('task_status', $task_status);
		$this->assign('task_priority', $task_priority);
		$this->assign('task_attribute', $task_attribute);
		$this->assign('task_biling', $task_biling);
		$this->assign('task_biling_type', $task_biling_type);
		$this->assign('task_biling_money', $task_biling_money);
		$this->assign('task_type', $task_type);
		/*
		*得到用户，只查询出当前登录用户及其下级用户
		*取得某个指定用户的所有同等级和下级用户的名称
		*/
		$user_old = $add_seed_value[0]['operator'] == '' ? $username : $add_seed_value[0]['operator'];
		$user_parentid=D('user')->where('userid='.$userid)->select();
        $object = new SysUser();
        $user = $object->get_arrparentname($user_parentid[0]['parentid']);
		$operator = $enum->get_radio($user, 'operator', 'operator', $user_old, $size = 5,$class = '', $ext = '',$width = 150, $gettype = 2);
		$this->assign('operator', $operator);
		/*
		*得到所有的项目
		*/
		$project_array = M('project')->field('project_id,project_name')->order(" project_name")->findAll();
		foreach($project_array as $key=>$value){
			$project_arr[$value['project_id']] = $value['project_name'];
		}
		$project = $enum->get_radio($project_arr, 'project_id', 'project_id', $add_seed_value[0]['project_id'], $size = 7,$class = '', $ext = '', $width = 150,$gettype = 2);
		$this->assign('project', $project);
        $this->m = 'task';
        $this->a = 'add';
		//菜单样式参数
		$this->assign('menu_name','icon_2');
		$this->display();
	}
    /*
     * 	任务删除
     *  author:jason.guo	 
     * 	date:2012-08-3
     */
	public function delete()
	{
		/*
		*默认只有任务发起人及其更高权限的用户可以删除此任务
		*/
		$user = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$task_id = $_REQUEST['task_id'];
		$return_executor = D('Task')->check_executor($user,$_REQUEST['assignment']);
		if($return_executor['status'] == '1'){
			$delete = D('Task')->task_delete($task_id);
			//D('Task')->where("task_id=".$task_id)->delete();
			$this->ajaxReturn($delete,'删除成功!',1);
		}else if($return_executor['status'] == '0'){
			$this->ajaxReturn($return_executor,'删除失败！',0);
		}
	}
    /*
     * 	任务查看
	 *	如果有父级或者子级任务一同显示
     *  author:jason.guo	 
     * 	date:2012-08-3
     */
	public function view()
	{
		/*
		*默认只有任务发起人及其更高权限的用户可以查看此任务
		*/
		$view = D('Task')->task_view($_REQUEST['task_id']);
		$project_view = D('Project')->getProjectbyid($view[0]['project_id']);
		$this->assign('project_view',$project_view[0]);
		$this->assign('view',$view);
		if(!empty($view['seed'])){
			$this->assign('view_other',$view['seed']);
			$this->assign('title','子级任务为');
		}else if(!empty($view['parent'])){
			$this->assign('view_other',$view['parent']);
			$this->assign('title','父级任务为');
		}
		//dump($view_other);
		$task = C('task');
		//dump($task);
		$this->assign('task', $task);
        $this->m = 'task';
        $this->a = 'view';
		$this->assign('menu_name','icon_2');
		$this->display();
	}
    /*
     * 	任务编辑，状态更新
     *  author:jason.guo	 
     * 	date:2012-08-25
     */
	public function edit()
	{
		if($_POST){
			$change_status = D('Task')->change_status($_POST);
			if($change_status['status'] == 1){
				die("<script>alert('修改成功！');window.location='?m=task&a=index';</script>");
			}else{
				die("<script>alert('修改状态错误！');window.location='?m=task&a=index';</script>");
			}
		}
		$enum = new Enumeration(); //生成下拉菜单类
		$task_id = $_REQUEST['task_id'];
		$edit = D('Task')->where("task_id=".$task_id)->findAll();
		$this->assign('edit', $edit[0]);
		$task = C('task');
		$this->assign('task', $task);
        $task_status = $enum->get_select($task['task_status'], 'task_status', 'task_status', $edit[0]['task_status'], $size = 1, $class = '', $ext = '', $gettype = 2);
		
		/*
		*得到用户，只查询出当前登录用户及其下级用户
		*取得某个指定用户的所有同等级和下级用户的名称
		*/
		$userid = $_COOKIE[C('COOKIE_PREFIX') . 'userid'];
		$user_parentid=D('user')->where('userid='.$userid)->select();
        $object = new SysUser();
        $user = $object->get_arrparentname($user_parentid[0]['parentid']);
		$operator = $enum->get_radio($user, 'operator', 'operator', $edit[0]['operator'], $size = 5, '',$class = '', $ext = '', $gettype = 2);
		$this->assign('operator', $operator);
		$this->assign('task_status',$task_status);
		$this->assign('task_id',$task_id);
		$this->display();
	}
    /*
     * 	发送邮件
	 *	$task_id任务的id根据id查看任务是添加还是更新
	 *	$message任务添加的信息
     *  author:jason.guo	 
     * 	date:2012-08-25
     */
	public function task_mail($task_id,$message){
		$task=D('task')->where('task_id='.$task_id)->select();
		$user=D('user')->where("username='".$task[0]['operator']."'")->select();
		if(!empty($task) && !empty($user)){
			$mail = new PHPMailer();    
			$mail->IsSMTP();                  // send via SMTP    
			$mail->Host = "172.20.2.11";   // SMTP servers    
			$mail->SMTPAuth = true;           // turn on SMTP authentication    
			$mail->Username = "Crm1";     // SMTP username  注意：普通邮件认证不需要加 @域名    
			$mail->Password = "Password01!"; // SMTP password    
			$mail->From = "crm1@transcosmos-cn.com";      // 发件人邮箱    
			$mail->FromName =  "crm1";  // 发件人  
			$mail->CharSet = "utf-8";   // 这里指定字符集！    
			$mail->Encoding = "base64";    
			$mail->AddAddress($user[0]['email'],$user[0]['username']);  // 收件人邮箱和姓名    
			$mail->AddReplyTo("jason.guo@transcosmos-cn.com","yourdomain.com");
			$mail->Subject = $task[0]['task_name']; 
			$mail->Body = $message.'<br>任务优先级:'.$task[0]['task_priority'].'<br>任务说明:<br>'.$task[0]['task_subject'].'<br>备注:<br>'.$task[0]['remark'];	
			$mail->AltBody ="text/html";  
			//$mail->Send();	
			if(!$mail->Send())    
			{   
				//echo "邮件发送有误 <p>";    
				//echo "邮件错误信息: " . $mail->ErrorInfo;  
				return array('message'=>"邮件发送失败，邮件错误信息: " . $mail->ErrorInfo,'status'=>'0');
			}    
			else {    
				//echo "邮件发送成功!<br />"; 
				return array('message'=>"邮件发送成功!",'status'=>'1');
			}
		}
	}
}
?>