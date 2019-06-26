<?php

header("Content-type: text/html; charset=utf-8");
import("@.ORG.User");
import("@.Org.form");

class SystemAction extends Action {

    public function index() {
       
        SysUser::check_privilege('system_manage');
        $con = include 'Conf/config.php';
        $localserver=C('DB_HOST');
        $model = D('Server');
        $list= $model->getServer2();
        $serverlist["localhost"]="localhost";
        foreach ($list["list"] as $k => $v){
            $serverlist[$v["server_ip"]]=$v["server_ip"];
        }
        $this->server=Form::select($serverlist,'server','server',$localserver);
        $this->assign('con', $con);
		 $this->assign('menu_name', 'icon_9');
        $this->display();
    }

    public function menu() {
        $task = include 'Conf/menu.inc.php';
        $title = "menu";
        $number = "-1";
        foreach ($task as $k => $v) {
            $n = explode("_", $k);
            if ($number < $n[1]) {
                $number = $n[1];
            }
        }
        $this->assign('number', $number);
        $this->assign('task', $task);
        $this->assign('title', $title);
		$this->assign('menu_name', 'icon_9');
        $this->display();
    }

    public function ajaxdata() {
        $idd = $_GET["idd"];
        $id = $_GET["id"];
        $status = include"Conf/$id.inc.php";


        switch ($id) {
            case menu:
                $string = "<a id='addnew' href='#'style='width:98%;margin:0 auto;font-size:20px;margin-left:10px;'>添加</a>";
                foreach ($status as $k => $v) {
                    $n = explode("_", $k);
                    if ($number < $n[1]) {
                        $number = $n[1];
                    }
                }
                $string.="<table style='width:98%;margin: 0 auto;margin-top: 10px;' id='myListTable' class='tablesorter' border='0' cellpadding='0' cellspacing='1'>";
                $string.="<tr><td>标题</td><td colspan='2'>链接</td></tr>";
                foreach ($status as $k => $v) {
                    $string.="<tr><td width='100px'>" . $v["title"] . "</td><td colspan='2'><input type='hidden' name='" . $k . "[title]' size='50px' value=" . $v["title"] . " /><input type='text' name='" . $k . "[link]' size='50px' value=" . $v["link"] . " /></td>";
                }
                $string.="<input type='hidden' id='title'  name='title' value='" . $id . "'>";
                $string.=" <input type='hidden' name='number' id='" . number . "' value='" . $number . "' />";
                $string.="</table>";
                break;

            case permission:
                $number = 1;
                $string = "<div id='system_menu'><table><tr id='ml2'>";
                if ($idd == "") {
                    $idd = "我的任务";
                }
                foreach ($status as $k => $v) {
                    foreach ($v as $ko => $vo) {
                        if($vo["value"]!=""){
                            //$is_admin = $SimplifyTask::getAdmin();
                            $string.="<td width='80px'><span id='" . $vo["value"] . "' name='" . $id . "'";
                                if ($idd == $vo["value"]) {
                                    $class = "btn1";
                                } else {
                                    $class = "";
                                }
                            $string.="class='" . $class . "'><a href='#'>" . $vo["value"] . "</a></span></td>";
                        }
                    }
                }
                $string.="</tr></table></div>";
                $string.="<table style='width:98%;margin-top: 10px; margin: 0 auto;' id='myListTable' class='tablesorter' border='0' cellpadding='0' cellspacing='1'>";
                $string.="<tr><td>编号</td><td colspan='2'>配置值</td></tr>";
                $string.= "<div><a id='addnew' href='#'style='width:98%;font-size:20px;margin-left:10px;'>添加</a></div>";
                foreach ($status as $k => $v) {
                    foreach ($v as $kx => $vx) {
                        if ($idd == $vx["value"]) {
                            $string.="<input type='hidden' id='arr' name='arr' value='" . $k . "'/>";
                            foreach ($v["option"] as $ky => $vy) {
                                $string.="<tr><td width='100px'>" . $ky . "</td><td colspan='2'><input type='text' name='" . $k . "[" . $ky . "]' size='50px' value=" . $vy . " /></td>";
                            }
                        }
                    }
                }
                $string.="<input type='hidden' id='number' name='number' value='" . $number . "' />";
                $string.="<input type='hidden' id='title'  name='title' value='" . $id . "' />";
                $string.="<input type='hidden' name='ml' value='" . $idd . "'";
                $string.="</tr></table>";
                break;

            default :
                $number = 1;
                $string = "<div id='system_menu'><table><tr id='ml2'>";
                if ($idd == "") {
                    switch ($id) {
                        case task:
                            $idd = task_status;
                            break;
                        case server:
                            $idd = server_type;
                            break;
                        case project:
                            $idd = project_status;
                            break;
                        case document:
                            $idd = document_type;
                            break;
                        case question:
                            $idd = log_type;
                            break;
                    }
                }
                $SimplifyTask = D("SimplifyTask");
                foreach ($status as $k => $v) {
                    if($k!="task_priority" && $k!="task_attribute" && $k!="task_biling" && $k!="task_biling_type" && $k!="task_biling_money" && $k!="task_category"){
                        $string.="<td width='80px'><span id='" . $k . "' name='" . $id . "'";
                        if ($idd == $k) {
                            $class = "btn1";
                        } else {
                            $class = "";
                        }
                        $k = $SimplifyTask::getmenuname($k);
                        $string.="class='" . $class . "'><a href='#'>" . $k . "</a></span></td>";
                        }
                }
                $string.="</tr></table></div>"; 
                $string.="<table style='width:98%;margin-top: 10px; margin: 0 auto;' id='myListTable' class='tablesorter' border='0' cellpadding='0' cellspacing='1'>";
                $string.="<tr><td>编号</td><td colspan='2'>配置值</td></tr>";
                $string.= "<div><a id='addnew' href='#'style='width:98%;font-size:20px;margin-left:10px;'>添加</a></div>";
                foreach ($status as $k => $v) {
                    foreach ($v as $ko => $vo) {
                        if ($idd == $k) {
                            $string.="<tr><td width='100px'>" . $ko . "</td><td colspan='2'><input type='text' name='" . $k . "[" . $ko . "]' size='50px' value=" . $vo . " /></td>";
                        }
                    }
                }
                $string.="<input type='hidden' id='number' name='number' value='" . $number . "' />";
                $string.="<input type='hidden' id='title'  name='title' value='" . $id . "' />";
                $string.="<input type='hidden' name='ml' value='" . $idd . "'";
                $string.="</tr></table></div>";
                break;
        }

        die($string);
    }

    public function update() {
        $title = $_POST["title"];
        $string = "<?php\r\n";
        $string.="return array(\r\n";
        switch ($title) {
            case menu:
                foreach ($_POST as $k => $v) {
                    if ($k <> "__hash__" && $k <> "submit" && $k <> "title" && $k <> "number") {
                        if ($k <> "" || $v <> "") {
                            $string.="'" . $k . "' => array( 'title' => '" . $v[title] . "','link'=>'" . $v[link] . "'),\r\n";
                        } else {
                            echo "<script>alert('菜单项修改失败!');window.location='?m=system&a=menu'</script>";
                        }
                    }
                }
                break;

            case permission:
                $status = include "Conf\\$title.inc.php";
                $arr = $_POST["arr"];
                $key = $_POST["k"];
                $vol = $_POST["v"];
                foreach ($key as $k => $v) {
                    foreach ($vol as $ko => $vo) {
                        if ($k == $ko) {
                            $_POST[$arr][$v] = $vo;
                        }
                    }
                }

                foreach ($status as $k => $v) {
                    $string.="\t'" . $k . "' => array(\r\n";
                    $string.="\t\t'module' => array('key'=>'" . $v[module][key] . "','value'=>'" . $v[module][value] . "'),\r\n";
                    $string.="\t\t'option'=>array(\r\n";
                    if ($k == $arr) {
                        foreach ($_POST[$arr] as $ko => $vo) {
                            $string.="\t\t\t'" . $ko . "'=>'" . $vo . "',\r\n";
                        }
                    } else {
                        foreach ($v[option] as $ko => $vo) {
                            $string.="\t\t\t'" . $ko . "'=>'" . $vo . "',\r\n";
                        }
                    }
                    $string.="\t\t),\r\n";
                    $string.="\t),\r\n";
                }

                break;

            default :
                $status = include "Conf\\$title.inc.php";
                $ml = $_POST["ml"];
                $key = $_POST["k"];
                $vol = $_POST["v"];
                foreach ($key as $k => $v) {
                    foreach ($vol as $ko => $vo) {
                        if ($k == $ko) {
                            $_POST[$ml][$v] = $vo;
                        }
                    }
                }
                foreach ($status as $k => $v) {
                    $string.="\t'" . $k . "' => array(\r\n";
                    if ($k == $ml) {
                        foreach ($_POST[$ml] as $ko => $vo) {
                            $string.="\t\t'" . $ko . "' => '" . $vo . "',\r\n";
                        }
                        $string.="\t),\r\n";
                    } else {
                        foreach ($v as $ko => $vo) {
                            $string.="\t\t'" . $ko . "' => '" . $vo . "',\r\n";
                        }
                        $string.="\t),\r\n";
                    }
                }
        }
        $string.=");\r\n?>";
        $num = file_put_contents("Conf/$title.inc.php", $string);
        import("ORG.Io.Dir");
        Dir::del(Runtime);
        if ($num >= 0) {
            echo "<script>alert('菜单项修改成功!');window.location='?m=system&a=menu'</script>";
        } else {
            echo "<script>alert('系统设置失败!');window.location='?m=system&a=index'</script>";
        }
    }

}

?>
