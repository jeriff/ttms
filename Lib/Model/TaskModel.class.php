<?php
	/*
	 * 	任务管理模块
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
class TaskModel extends Model {
    /*     * ************************************************************************************************************** */

    protected $TableName = 'simplify_task';
    protected $pk = 'task_id';//定义主键
	/*
	 * 	任务列表
	 *	$map为查询条件
	 *	返回值为查询数据的数组和分页类信息
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
    public function getTaskList($map) {
		$map['parent_id']=0;
		import("@.ORG.Page"); //导入分页类 $page->parameter .= "&storage_id=".$map['storage_id'];
		$count = $this->where($map)->count();
		$page = new Page($count, 20);
		$show = $page->show();
        $fields = array('task_id','task_name','task_priority','task_attribute','task_biling_type','espiration_time','project_id','parent_id', 'task_type', 'task_subject', 'assignment', 'operator','begin_time', 'end_time', 'man_day', 'actual_man_day', 'espiration_time', 'task_status', 'remark', 'created','created_by','modified','modified_by');
		$list = $this->where($map)->field($fields)->limit($page->firstRow . ',' . $page->listRows)->order('task_id desc')->findAll();
		//dump($this->getLastsql());
        return array('list'=>$list,'show'=>$show);
    }
	//用户权限检查
	public function check_executor(){
		return array('status'=>'1','message'=>'成功！~~~');
	}
	/*
	 * 	时间转换
	 *	$inventory_time为你要得到时间段的范围 值：day week month season year
	 *	$time传进来的时间点
	 *	根据时间点得到你要得到的时间范围
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
    public function check_time($inventory_time, $time) {

        if ($inventory_time == 'day') {
            $firstday = date("Y-m-d 00:00:00", strtotime($time));
            $lastday = date("Y-m-d 23:59:59", strtotime($time));
        } else if ($inventory_time == 'week') {
            $lastday = date("Y-m-d 23:59:59", strtotime("$time Sunday"));
            $firstday = date("Y-m-d 00:00:00", strtotime("$lastday - 6 days"));
        } else if ($inventory_time == 'month') {
            $firstday = date("Y-m-01 00:00:00", strtotime($time));
            $lastday = date("Y-m-d 23:59:59", strtotime("$firstday +1 month -1 day"));
        } else if ($inventory_time == 'season') {
            $season = ceil((date('n', strtotime($time))) / 3); //当月是第几季度
            $firstday = date('Y-m-d H:i:s', mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y', strtotime($time))));
            $lastday = date('Y-m-d H:i:s', mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date('Y', strtotime($time)))), date('Y', strtotime($time))));
        } else if ($inventory_time == 'year') {
            $firstday = date('Y-01-01 00:00:00', strtotime($time));
            $lastday = date('Y-12-31 23:59:59', strtotime($time));
        }
        //$map = array('between', '"' . $firstday . '","' . $lastday . '"');
        $map=array(0=>$firstday,1=>$lastday);
        return $map;
    }
	/*
	 * 	时间转换为周时间段
	 *	日期转换，以周为单位进行转换
	 *	$num游标
	 *	根据当前时间点得到本周的日期范围
	 *	根据游标得到于本周相差几周的日期范围
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
    function getWeekList($num) {
		$week = date('w');//dump($week);
		switch ($week)
		{
			default :
			case 0 :
				$date['begin_time'] = date('Y-m-d',strtotime($num." week -6 day"));
				$date['end_date'] = date('Y-m-d',strtotime($num." week"));
				break;
			case 1 :
				$date['begin_time'] = date('Y-m-d',strtotime($num." week"));
				$date['end_date'] = date('Y-m-d',strtotime($num." week +6 day"));
				break;
			case 2 :
				$date['begin_time'] = date('Y-m-d',strtotime($num." week -1 day"));
				$date['end_date'] = date('Y-m-d',strtotime($num." week +5 day"));
				break;
			case 3 :
				$date['begin_time'] = date('Y-m-d',strtotime($num." week -2 day"));
				$date['end_date'] = date('Y-m-d',strtotime($num." week +4 day"));
				break;
			case 4 :
				$date['begin_time'] = date('Y-m-d',strtotime($num." week -3 day"));
				$date['end_date'] = date('Y-m-d',strtotime($num." week +3 day"));
				break;
			case 5 :
				$date['begin_time'] = date('Y-m-d',strtotime($num." week -4 day"));
				$date['end_date'] = date('Y-m-d',strtotime($num." week +2 day"));
				break;
			case 6 :
				$date['begin_time'] = date('Y-m-d',strtotime($num." week -5 day"));
				$date['end_date'] = date('Y-m-d',strtotime($num." week +1 day"));
				break;
		}
		//dump($date);
		return $date;
    }
	/*
	 * 	一般任务添加
	 *	$array添加任务的信息
	 *	根据act来判断是更新还是添加
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
	public function ordinaryTaskAdd($array){
		$user = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$array['modified_by'] = $user;
		$array['modified'] = date('Y-m-d H:i:s');
		if($array['act'] == 'save'){
			unset($array['act']);
			$task_id = $this->where("task_id=".$array['task_id'])->save($array);
			return array('status'=>'1','task_id'=>$task_id,'message'=>'你所执行的任务有修改，请查看！');
		}else{
			unset($array['act']);
			$array['assignment'] = $user;
			$array['created_by'] = $user;
			$array['created'] = date('Y-m-d H:i:s');
			$task_id = $this->add($array);
			return array('status'=>'1','task_id'=>$task_id,'message'=>'你有新任务，请查看！');
		}
	}
	/*
	 * 	周期性任务添加
	 *	$array添加任务的信息
	 *	把任务拆分为每天每个人添加一条
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
	public function TaskAdd($array){
		$user = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$array['assignment'] = $user;
		$user_arr = $array['operator'];
		$array['operator'] = implode(',',$array['operator']);
		$array['created_by'] = $user;
		$array['created'] = date('Y-m-d H:i:s');
		$array['modified_by'] = $user;
		$array['modified'] = date('Y-m-d H:i:s');
		$taskid = $this->add($array);
		$st = explode(' ',$array['begin_time']);
		$ed = explode(' ',$array['end_time']);
		$cha_date = (strtotime($ed[0])-strtotime($st[0]))/(3600*24);
		$array['man_day'] = ($array['man_day']/(5));
		if($cha_date>0 || count($user_arr)>1){
			$star_time = $array['begin_time'];
			$end_time = $array['end_time'];
			foreach($user_arr as $key=>$value){
				for($i=0;$i<=$cha_date;$i++){
					$array['begin_time'] = date("Y-m-d", (strtotime($st[0]) + 3600*24*$i))." ".$st[1];
					$array['end_time'] = date("Y-m-d", (strtotime($ed[0]) - 3600*24*($cha_date-$i)))." ".$ed[1];
					$array['parent_id'] = $taskid;
					$array['operator'] = $value;
					if(date('w',strtotime($array['begin_time'])) != 0 && date('w',strtotime($array['begin_time'])) != 6){
						$task_id[] = $this->add($array);
					}
				}
			}
		}
		
		return array('status'=>'1','message'=>'添加成功！~~~');
	}
	/*
	 * 	任务查看
	 *	$task_id需要查看任务的id
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
	public function task_view($task_id){
		$view = $this->where("task_id=".$task_id)->findAll();
		$seed = $this->where("parent_id=".$task_id)->findAll();
		/*
		*查看当前任务以及子任务或父级任务
		*/
		if(!empty($seed)){
			$view['seed'] = $seed;
		}
		if($view[0]['parent_id'] != 0){
			$parent = $this->where("task_id=".$view[0]['parent_id'])->findAll();
			$view['parent'] = $parent;
		}
		return $view;
	}
	/*
	 * 	任务删除
	 *	$task_id需要查看任务的id
	 *	删除任务，如果有子任务连同删除
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
	public function task_delete($task_id){
		$check_delete = $this->where("task_id=".$task_id)->findAll();
		if($check_delete[0]['parent_id'] == 0){
			/*
			*如果parent_id为0，则没有父级任务
			*删除本任务，以及删除子级任务
			*/
			$this->where("task_id=".$task_id)->delete();
			$this->where("parent_id=".$task_id)->delete();
		}else{
			/*
			*如果parent_id为0，则没有父级任务
			*删除本任务
			*/
			$this->where("task_id=".$task_id)->delete();
			/*
			*如果parent_id不为0，则有父级任务
			*删除的同时查看父级任务还有没有其他子级任务，
			*如果没有连同父级任务一同删除
			
			$where['parent_id'] =  $check_delete[0]['parent_id'];
			$where['task_id'] = array('neq',$task_id);
			$seed_delete = $this->where($where)->findAll();
			if(!empty($seed_delete)){
				$this->where("task_id=".$task_id)->delete();
			}else{
				$this->where("task_id=".$check_delete[0]['parent_id'])->delete();
				$this->where("task_id=".$task_id)->delete();
			}*/
		}
		return array('status'=>'1','message'=>'删除成功！~~~');	
	}
	/*
	 * 	更新任务状态
	 *	$array需要更新任务信息
	 *	如果任务状态是完成则添加实绩执行工时和完成时间
	 *  author:jason.guo	 
	 * 	date:2012-08-25
	 */
	public function change_status($array){
		$task = D("Task");
		$user = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$task_id = $array['task_id'];
		$parent_id = $array['parent_id'];
		$data['task_status'] = $array['task_status'];
		/*
		*如果执行人不为空且不等于当前登录人
		*则执行人有变动（默认只有执行人和system账号可以变动执行人）
		*则更新执行人，如果分配人也不等于当前登录人，则做连接更新登录人
		*/
		if(!empty($array['operator']) && $array['operator'] != $user){
			$data['operator'] = $array['operator'];
			if($array['assignment'] != $user){
				$data['assignment'] = $array['assignment'].",".$user;
			}
		}
		/*
		*如果更新的任务状态为已完成
		*则更新完成时间和实际执行时间
		*/
		if($array['task_status'] == 4){
			$data['over_time'] = $array['over_time'];
			$data['actual_man_day'] = $array['actual_man_day'];
		}else if($array['task_status'] == 1){
			return array($array,'status'=>'0');
		}
		/*
		*如果parent_id不为0，则有父级任务
		*查看此父级任务的所有子级任务的状态是否等于当前更新状态
		*如果所有子任务都为此状态则更新父级任务
		*如果子级任务状态为已完成，则更新父级任务的实际执行工时
		=====================================
		*如果parent_id为0，则没有父级任务
		*更新子任的状态
		*/
		if($parent_id != 0){
			/*if($data['task_status'] == 4){
				//更新父级任务的实际执行工时
				$old_man = $task->where("task_id=".$parent_id)->field(" actual_man_day ")->select();
				$parent_data['actual_man_day'] = ($data['actual_man_day']+$old_man[0]['actual_man_day']);
				$task->where("task_id=".$parent_id)->save($parent_data);
			}*/
			$where['parent_id'] =  $parent_id;
			$where['task_id'] = array('neq',$task_id);
			$parent = $task->where($where)->findAll();
			$i = 0;
			foreach($parent as $key=>$value){
				if($value['task_status'] != $array['task_status']){
					$i++;
				}
			}
			if($i == 0){
				$parent_arr['task_status'] = $data['task_status'];
				$over['parent'] = $task->where("task_id=".$parent_id)->save($parent_arr);//更新父级任务
			}
		}else{
			$parent_arr['task_status'] = $data['task_status'];
			$over['seed'] = $task->where("parent_id=".$task_id)->save($parent_arr);//更新子任务
		}
		$data['remark'] = $array['remark'];
		$over['task'] = $task->where("task_id=".$task_id)->save($data);
		//更新父级任务工时
		$parent_data['actual_man_day'] = $task->where("parent_id=".$parent_id)->sum("actual_man_day");
		$task->where("task_id=".$parent_id)->save($parent_data);
		return array($over,'status'=>'1');
	}
}

?>