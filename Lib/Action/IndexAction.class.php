<?php

header("Content-type: text/html; charset=utf-8");
require_once './Common/enumeration.class.php';
import("@.ORG.User");

class IndexAction extends Action {

    public function index() {
        
        $map['username'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
		$id = $_COOKIE[C('COOKIE_PREFIX') . 'userid'];
        $usermodel = D('User');
        $user = $usermodel->field('is_admin')->where($map)->select();

            $select_user = D('user')->field('username')->select();
            $object = new SysUser();
            $listparent = $object->get_task($mark = '┣', $id, $map['username']);

            $listparent = '<select name="parentid" id="uesrname"><option value="0">请选择用户</option>' . $listparent . '</select>';
            $this->assign('listparent', $listparent);
      

        $this->assign('menu_name', 'icon_1');
        $this->display();
    }

    public function gettask() {

        if ($_GET['user_name'] == 'undefined') {
            $condition['created_by'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
        } else {
            $condition['created_by'] = $_GET['user_name'];
        }
        $model = D('simplifyTask');
        $array = array('task_id', 'task_name','begin_time', 'end_time', 'task_status');
		
        $start = date("Y-m-d H:i:s", $_GET['start']);
        $end = date("Y-m-d H:i:s", $_GET['end']);
        $condition['begin_time'] = array('egt', $start);
        $condition['end_time'] = array('lt', $end);
      
        $task = D('simplifyTask')->field($array)->where($condition)->select();
        foreach ($task as $key => $value) {

                $task_all[$key]['title'] = $task[$key]['task_name'];
                $task_all[$key]['start'] = $task[$key]['begin_time'];
                $task_all[$key]['end'] = $task[$key]['end_time'];
                $task_all[$key]['url'] = "?m=simplifyTask&a=view&task_id=" . $task[$key]['task_id'];
        }
		//print_r($task);
		//echo D('Task')->getlastsql(); 
        echo json_encode($task_all);
    }

}

?>