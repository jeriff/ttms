<?php

/*
 *  任务管理模块
 *  author:jason.guo	 
 *  date:2012-08-3
 */
header("Content-type: text/html; charset=utf-8");
import("@.Org.form");

class SimplifyTaskAction extends Action {
    //任务列表
    public function index() {       
        $SimplifyTask = D('SimplifyTask');
        /* =============搜索============= */
        $fields = array('task_type', 'task_status', 'created_by');
        $map = array();
        if (isset($_GET) && !empty($_GET)) {
            foreach ($_GET as $key => $value) {
                if (in_array($key, $fields)) {
                    if (isset($_GET[$key]) && !empty($_GET[$key])) {
                        $map[$key] = trim($value);
                    }
                }
            }
        } 
         import("@.ORG.User");
        $userModel = new SysUser();
        $id=$_COOKIE[C("COOKIE_PREFIX")."userid"];
        if($map['created_by']==''){
            $username_string = $userModel->get_cid($id);
            $map['created_by']=array('in',$username_string.$_COOKIE[C("COOKIE_PREFIX")."username"]);
        }
        
        if (isset($_GET['week_time']) && !empty($_GET['week_time'])) {
            $time = explode(' ', $_GET['week_time']);
            $date = $SimplifyTask->check_time('week', $time[0]);
            $this->week_time = $_GET['week_time'];
        } else {
            $date = $SimplifyTask->check_time('week', date("Y-m-d"));
            $this->week_time = date('Y-m-d 第W周');
        }
        $this->date = $date;
        $map['_string'] = " (begin_time >= '" . $date[0] . "' and begin_time<= '" . $date[1] . "') or (end_time >= '" . $date[0] . "' and end_time<= '" . $date[1] . "')";
        
        /* =============搜索============= */
        $list = $SimplifyTask->getTaskList($map);
        //dump($list);
        $this->assign('list', $list);

        //页面初始化
        $task = C('task');
        $this->assign('task', $task);
        //任务优先级getDataList
        $this->task_type = Form::select($task['task_type'], 'task_type', 'task_type', $map['task_type']);
        //任务状态
        $this->task_status = Form::select($task['task_status'], 'task_status', 'task_status', $map['task_status']);
        //任务执行人
       
       
        //echo $parentid;
        $listparent = $userModel->get_task($mark = '┣', $id, $map['created_by']);
       
        $listparent = '<select name="created_by" id="created_by"><option value="">全部</option>' . $listparent . '</select>';
        $this->assign('listparent', $listparent);
        $this->m = 'SimplifyTask';
        $this->a = 'index';
        $this->user = $SimplifyTask::getUsername();
        //非admin查看自己任务
        $is_admin = $SimplifyTask::getAdmin();
        $this->assign('is_admin', $is_admin);
        $this->assign('menu_name', 'icon_2');
        $this->display();
    }

    /*
     * 	任务查看
     *  author:jason.guo	 
     * 	date:2012-08-3
     */

    public function view() {
        if (!isset($_GET['task_id']) || empty($_GET['task_id'])) {
            $this->error('任务不存在');
        }
        $SimplifyTask = D('SimplifyTask');
        $view = $SimplifyTask->find($_GET['task_id']);

        $this->project_name = '';
        if (!empty($view['project_id']) && $view['project_id'] != 0) {
             $this->project_name = D('Project')->where('project_id='.$view['project_id'])->getField('project_name');
        }
        $this->assign('view', $view);
        $task = C('task');
        $this->assign('task', $task);
        $this->m = 'taskNew';
        $this->a = 'view';
        $this->assign('menu_name', 'icon_2');
        $this->display();
    }

    /*
     * 	任务添加
     * 	包括父级任务和子任务的添加
     *  author:jason.guo	 
     * 	date:2012-08-3
     */

    public function add() {
        $SimplifyTask = D('SimplifyTask');
        if ($_POST) {
            $date=$_POST['begin_time'];
            $_POST['begin_time']=$date." ".$_POST['btime'];
            $_POST['end_time']=$date." ".$_POST['etime'];
            $vo = $SimplifyTask->create();
            if (!$vo){
            // 如果创建失败 表示验证没有通过 输出错误提示信息
                $this->error('添加失败'.$SimplifyTask->getError());
            }
            // 验证通过 可以进行其他数据操作
            $data = $vo['task_id'] == '' ? $SimplifyTask->add() : $SimplifyTask->save();
            if($data){
                $vo['task_id'] == '' ? $this->success('添加成功<br>') : $this->success("修改成功<br>");
            }
            $this->error("失败");
        }
        $edit = array();
        if(isset($_GET['task_id']) && !empty($_GET['task_id'])){
            $edit = $SimplifyTask->find($_GET['task_id']);
            $btime=  explode(" ", $edit[begin_time]);
            $etime=explode(" ",$edit[end_time]);
            $edit["begin_time"]=$etime[0];
            $edit["btime"]=  $btime[1];
            $edit["etime"]=  $etime[1];
        }
        if(!$_GET&&!$_POST){
             $edit['project_id']=27;
             $edit['task_status']=4;
             $edit['task_type']=2;
        }
        //页面初始化
        $task = C('task');
        $this->assign('task', $task);
        $btime=array("08:00:00"=>"8:00","08:30:00"=>"8:30");
        $etime=array("19:00:00"=>"19:00","20:00:00"=>"20:00","21:00:00"=>"21:00","22:00:00"=>"22:00","23:00:00"=>"23:00","23:59:59"=>"23:59");
        $time_arr=array("09:00:00"=>"9:00","09:30:00"=>"9:30","10:00:00"=>"10:00","10:30:00"=>"10:30","11:00:00"=>"11:00","11:30:00"=>"11:30","12:00:00"=>"12:00","13:00:00"=>"13:00","13:30:00"=>"13:30","14:00:00"=>"14:00","14:30:00"=>"14:30","15:00:00"=>"15:00","15:30:00"=>"15:30","16:00:00"=>"16:00","16:30:00"=>"16:30","17:00:00"=>"17:00","17:30:00"=>"17:30","18:00:00"=>"18:00");
        $bgtime=array_merge($btime,$time_arr);
        $edtime=  array_merge($time_arr,$etime);
        $this->btime=Form::select($bgtime,'btime','btime',$edit['btime']);
        $this->etime=Form::select($edtime,'etime','etime',$edit['etime']);
        //任务优先级
        $this->task_type = Form::select($task['task_type'], 'task_type', 'task_type', $edit['task_type']);
        //任务状态
        $this->task_status = Form::select($task['task_status'], 'task_status', 'task_status', $edit['task_status']);
        /*
         * 得到所有的项目
         */
        $project_array = M('project')->field('project_id,project_name')->order(" project_name")->findAll();
        foreach ($project_array as $key => $value) {
            $project_arr[$value['project_id']] = $value['project_name'];
        }
        $project = Form::radio($project_arr, 'project_id', 'project_id', $edit['project_id'], $cols = 100, $class = '', $ext = '', $width = 150);
        $this->assign('project', $project);
        $this->assign('edit',$edit);
        $this->m = 'SimplifyTask';
        $this->a = 'add';
        //菜单样式参数
        $this->assign('menu_name', 'icon_2');
        $this->display();
    }
    /*
     * 	任务删除
     *  author:jason.guo	 
     * 	date:2012-08-3
     */

    public function delete() {
        /*
         * 默认只有任务发起人及其更高权限的用户可以删除此任务
         */
        if (isset($_GET['task_id']) && !empty($_GET['task_id'])) {
            $delete = D('SimplifyTask')->where("task_id=" . $_GET['task_id'])->delete();
            $this->success('删除成功!');
        } else {
            $this->error('任务不存在');
        }
    }
    
    public function checktime(){
       $etime=array("19:00:00"=>"19:00","20:00:00"=>"20:00","21:00:00"=>"21:00","22:00:00"=>"22:00","23:00:00"=>"23:00","23:59:59"=>"23:59");
       $time_arr=array("09:00:00"=>"9:00","09:30:00"=>"9:30","10:00:00"=>"10:00","10:30:00"=>"10:30","11:00:00"=>"11:00","11:30:00"=>"11:30","12:00:00"=>"12:00","13:00:00"=>"13:00","13:30:00"=>"13:30","14:00:00"=>"14:00","14:30:00"=>"14:30","15:00:00"=>"15:00","15:30:00"=>"15:30","16:00:00"=>"16:00","16:30:00"=>"16:30","17:00:00"=>"17:00","17:30:00"=>"17:30","18:00:00"=>"18:00");
       $edtime=  array_merge($time_arr,$etime);
       $btime=$_GET["btime"];
       $etime=$_GET["etime"];
       
      $time_array=  explode(":", $btime);
      $h=$time_array[0];
      $m=$time_array[1];
      $h==12 ? $h=13 : $h;
      if($btime>=$etime){
          $h=="18" ? $etime="19:00:00" : "";
          $h<9 ? $etime="09:00:00" : "";
          if(($h>8)&&($h<18)){
              $h=($m=="30" ? $h+1 : $h);
              $m=($m=="30" ? "00" : "30");
              $etime=$h.":".$m.":00";
          }
      
      }
      if($btime==""){
           $btime="09:00:00";
           $etime="";
       }
                foreach ($edtime as $k => $v){
                    if($k>$btime){
                        $time_bg[$k]=$v;
                    }
                }
                $string=Form::select($time_bg,'etime','etime',$etime);
        die($string);
   }
}

?>