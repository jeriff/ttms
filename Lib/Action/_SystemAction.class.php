<?php

header("Content-type: text/html; charset=utf-8");
import("@.ORG.User");
class SystemAction extends Action {

    public function index() {
        SysUser::check_privilege('system_manage');
        $file = file_get_contents("Conf/config.php");
        $file_inc = file_get_contents("Conf/status.inc.php");
        //file_put_contents("Conf/config.php", $file);

        $this->assign('file_inc', $file_inc);
        $this->assign('file', $file);
        $this->assign('menu_name', 'icon_9');
        $this->display();
    }

    public function edit() {
         SysUser::check_privilege('system_edit');
        if ($_POST) {
            file_put_contents("Conf/config.php", $_POST['config']);
            file_put_contents("Conf/status.inc.php", $_POST['status']);
            echo "<script>alert('系统设置成功!');window.location='?m=index&a=index'</script>";
        }
    }

}

?>
