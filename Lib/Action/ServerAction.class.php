<?php
header("Content-type: text/html; charset=utf-8");
require_once './Common/enumeration.class.php';
import("@.ORG.User");
class ServerAction extends Action {

    public function index() {
         SysUser::check_privilege('server_manage');
        if (isset($_GET)) {
            $server_siteselect = $_GET['server_site'];
            $server_ipselect = $_GET['server_ip'];
            $server_statusselect = $_GET['server_status'];
            $this->assign('server_name', $_GET['server_name']);
            $this->assign('server_type', $_GET['server_type']);
            $this->assign('server_status', $_GET['server_status']);
            unset($_GET['__hash__']);
            foreach ($_GET as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'server_name' || $key == 'server_type') {
                        $map[$key] = array('like', '%' . trim($value) . '%');
                    } else {
                        $map[$key] = trim($value);
                    }
                }
            }
        }
        unset($map['p']);
        $model = D('Server');
        $list= $model->getServer($map);
        $this->page = $list['show'];
        $this->list = $list['list'];
        
        $this->server = C('server');
        $enum = new Enumeration();

        $server_sitelist = C('server.server_site');
        $server_site = $enum->get_select($server_sitelist, 'server_site', 'server_site', $server_siteselect, $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('server_site', $server_site);
        
        

        $server = D('Server');
        $server_iplist = $server->getServerip();
        $server_ip = $enum->get_select($server_iplist, 'server_ip', 'server_ip', $server_ipselect, $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('server_ip', $server_ip);
        
        $server_statuslist = C('server.server_status');
        $server_status = $enum->get_select($server_statuslist, 'server_status', 'server_status', $server_statusselect, $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('server_status', $server_status);

        $this->assign('menu_name', 'icon_5');
        $this->display();
    }
    
    public function add_server(){
       
        if (isset($_GET)) {
            $model = D('Server');
            $server = $model->getServerbyid($_GET['server_id']);
            foreach ($server['0'] as $key => $value) {
                $project[$key] = $value;
            }
            if ($_GET['type'] == 'view') {
                $type = "view";
                 SysUser::check_privilege('server_detail');
            } else if ($_GET['type'] == 'edit') {
                $type = "edit";
                SysUser::check_privilege('server_edit');
            }
            else if($_GET['type'] == 'add'){
                 $type = "add";
                 SysUser::check_privilege('server_add');
            }
            $this->assign('a', $type);
            $this->assign('server', $server);
        }

        if (isset($_POST) && !empty($_POST)) {
            
            if (!empty($_POST['server_name']) && !empty($_POST['server_ip']) && !empty($_POST['server_type']) && !empty($_POST['server_site']) && !empty($_POST['server_status'])) {

                unset($_POST['__hash__']);
                foreach ($_POST['server_type'] as $key=>$value){
                    if(count($_POST['server_type'])==($key+1)){
                        $type .=$value;
                    }
                    else if(count($_POST['server_type']) > 1){
                         $type .=$value.",";
                    }
                    else{
                         $type .=$value;
                    }
                   
                }
                
                $array['server_type']=$type;
                unset($_POST['server_type']);
                foreach ($_POST as $key => $vlaue) {
                    $array[$key] = $vlaue;
                }
               
                if ($_POST['submit'] == '添加') {
                    $array['created'] = date('Y-m-d H:i:s');
                    $array['created_by'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
                   
                    unset($array['server_id']);
                    $model = M('Server');
                    $project = $model->add($array);

                    if ($project) {
                        die("<script>alert('服务器添加成功');window.location='?m=server&a=index';</script>");
                    }
                    else{
                        die("<script>alert('服务器添加失败');window.location='?m=server&a=add_server&type=add';</script>");
                    }
                }
               
                else if($_POST['submit'] == '保存'){
                    $array['modified'] = date('Y-m-d H:i:s');
                    $array['modified_by'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
                    
                    $model = M('Server');
                    $server_id['server_id']=$array['server_id'];
                    unset($array['server_id']);
                    $project = $model->where($server_id)->save($array);

                    if ($project) {
                        die("<script>alert('服务器修改成功');window.location='?m=server&a=index';</script>");
                    }
                    else{
                        die("<script>alert('服务器修改失败');history.go(-1);</script>");
                    }
                }
            }
            else{
                die("<script>history.go(-1);</script>");
            }
        }
        
        
        
        $enum = new Enumeration();
        
        $server_typelist = C('server.server_type');
        $server_type = $enum->get_checkbox($server_typelist, 'server_type', 'server_type', $server['server_type'], '',$size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('server_type', $server_type);
        

        $server_sitelist = C('server.server_site');
        $server_site = $enum->get_select($server_sitelist, 'server_site', 'server_site', $server['server_site'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('server_site', $server_site);
        
        $server_statuslist = C('server.server_status');
        $server_status = $enum->get_select($server_statuslist, 'server_status', 'server_status', $server['server_status'], $size = 1, $class = '', $ext = '', $gettype = 2);
        $this->assign('server_status', $server_status);
        
        
        $this->assign('menu_name', 'icon_5');
        $this->display();
    }
    
    public function delete() {
        SysUser::check_privilege('server_del');
        if ($_GET['type'] == 'delete') {
            if ($_GET['server_id']) {
               $map['server_id']=$_GET['server_id'];
               $model=D('Server');
               $project=$model->where($map)->delete();
               if($project){
                    die("<script>alert('服务器删除成功');window.location='?m=server&a=index';</script>");
               }
            }
        }
    }

}

?>
