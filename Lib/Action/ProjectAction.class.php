<?php

header("Content-type: text/html; charset=utf-8");
require_once './Common/enumeration.class.php';
import("@.ORG.User");

class ProjectAction extends Action {

    public function index() {
        SysUser::check_privilege('project_manage');
        if (isset($_GET)) {
            $project_siteselect = $_GET['project_site'];
            $project_statusselect = $_GET['project_status'];
            $server_ipselect = $_GET['server_ip'];
            $this->assign('project_ontime', $_GET['project_ontime']);
            $this->assign('project_name', $_GET['project_name']);
            unset($_GET['__hash__']);
            
            foreach ($_GET as $key => $value) {
                if (!empty($value))
                    if ($key == 'project_name') {
                        $map[$key] = array('like', '%' . trim($value) . '%');
                    } else {
                        $map[$key] = trim($value);
                    }
            }
        }

        unset($map['p']);
        $model = D('Project');
        $list = $model->getProjectlist($map);
        $this->page = $list['show'];
        $this->list = $list['list'];

        $this->status = C('project');
        $this->server = C('server');
        $enum = new Enumeration();

        //项目站点
        $project_sitelist = C('server.server_site');
        $project_site = $enum->get_select($project_sitelist, 'project_site', 'project_site', $project_siteselect, $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('project_site', $project_site);

        //项目状态
        $project_statuslist = C('project.project_status');
        $project_status = $enum->get_select($project_statuslist, 'project_status', 'project_status', $project_statusselect, $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('project_status', $project_status);

        //服务器ip地址
        $server = D('Server');
        $server_iplist = $server->getServerip();
        $server_ip = $enum->get_select($server_iplist, 'server_ip', 'server_ip', $server_ipselect, $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('server_ip', $server_ip);

        $this->assign('menu_name', 'icon_6');
        $this->display();
    }

    public function add_project() {
        if (isset($_GET)) {
            $model = D('Project');
            $project = $model->getProjectbyid($_GET['project_id']);
            foreach ($project['0'] as $key => $value) {
                $project[$key] = $value;
            }
            if ($_GET['type'] == 'view') {
                $type = "view";
                SysUser::check_privilege('project_detail');
            } else if ($_GET['type'] == 'edit') {
                $type = "edit";
                SysUser::check_privilege('project_edit');
            } else if ($_GET['type'] == 'add') {
                $type = "add";
                SysUser::check_privilege('project_add');
            }
            $this->assign('a', $type);
            $this->assign('project', $project);
        }
        if (isset($_POST) && !empty($_POST)) {
            if (!empty($_POST['project_name']) && !empty($_POST['server_ip']) && !empty($_POST['project_site']) && !empty($_POST['project_ontime']) && !empty($_POST['project_status'])) {

                $server = D('Server');
                $_POST['project_server_id'] = $server->getServerid($_POST['server_ip']);
                unset($_POST['server_ip']);
				unset($_POST['select_ip']);
                unset($_POST['__hash__']);
                foreach ($_POST as $key => $vlaue) {
                    $array[$key] = $vlaue;
                }
				$array['project_type'] = implode(",",$array['project_type']);
				$array['project_business_type'] = implode(",",$array['project_business_type']);
                if ($_POST['submit'] == '添加') {

                    $array['created'] = date('Y-m-d H:i:s');
                    $array['created_by'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
                    $model = M('Project');
                    $project = $model->add($array);
                    if ($project) {
                        die("<script>alert('项目添加成功');window.location='?m=project&a=index';</script>");
                    } else {
                        die("<script>alert('项目添加失败');window.location='?m=project&a=add_project&type=add';</script>");
                    }
                } else if ($_POST['submit'] == '保存') {

                    $array['modified'] = date('Y-m-d H:i:s');
                    $array['modified_by'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
                    $model = M('Project');
                    $project_id['project_id'] = $array['project_id'];
                    unset($array['project_id']);
                    $project = $model->where($project_id)->save($array);

                    if ($project) {
                        die("<script>alert('项目修改成功');window.location='?m=project&a=index';</script>");
                    } else {
                        die("<script>alert('项目修改失败');history.go(-1);</script>");
                    }
                }
            } else {
                die("<script>history.go(-1);</script>");
            }
        }
        $enum = new Enumeration();
        $server = D('Server');
        $server_iplist = $server->getServerip();
        $server_ip = $enum->get_select($server_iplist, 'server_ip', 'server_ip', $project['server_ip'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('server_ip', $server_ip);

        $select_ip = $enum->get_select($server_iplist, 'select_ip', 'select_ip', $project['select_ip'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('select_ip', $select_ip);
		
        $project_sitelist = C('server.server_site');
        $project_site = $enum->get_select($project_sitelist, 'project_site', 'project_site', $project['project_site'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('project_site', $project_site);

        $project_statuslist = C('project.project_status');
        $project_status = $enum->get_select($project_statuslist, 'project_status', 'project_status', $project['project_status'], $size = 1, $class = '', $ext = '',$gettype = 2);
		$project_arr = c('project');
		$project_type = $enum->get_checkbox($project_arr['project_type'], 'project_type', 'project_type', $project['project_type'], $cols = 5, $class = '', $ext = '','', $gettype = 2);
		$project_business_type = $enum->get_checkbox($project_arr['project_business_type'], 'project_business_type', 'project_business_type', $project['project_business_type'], $cols = 1, $class = '', $ext = '', '',$gettype = 2);
		
        $this->assign('project_status', $project_status);
		$this->assign('project_type', $project_type);
		$this->assign('project_business_type', $project_business_type);
        $this->assign('menu_name', 'icon_6');
        $this->display();
    }

    public function delete() {
        SysUser::check_privilege('project_del');
        if ($_GET['type'] == 'delete') {
            if ($_GET['project_id']) {
               $map['project_id']=$_GET['project_id'];
               $model=D('Project');
               $project=$model->where($map)->delete();
               if($project){
                    die("<script>alert('项目删除成功');window.location='?m=project&a=index';</script>");
               }
            }
        }
    }

}

?>
