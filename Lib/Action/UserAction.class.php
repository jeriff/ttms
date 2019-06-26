<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

header("Content-type: text/html; charset=utf-8");

class UserAction extends Action {
    public function login() {
        $cookie_name = C('COOKIE_PREFIX');
        if ($_POST) {
            $form = D("user");
            if ($_POST['username'] === C('administrator')) {
                setcookie($cookie_name . "userid", 1, time() + 3600 * 24, '/'); /* 有效期1天 */
                setcookie($cookie_name . "parentid", 0, time() + 3600 * 24, '/'); /* 有效期1天 */
                setcookie($cookie_name . "username", C('administrator'), time() + 3600 * 24, '/'); /* 有效期1天 */
                setcookie($cookie_name . "language", 'cn', time() + 3600 * 24, '/'); /* 有效期1天 */
                die("<script>alert('" . L('login_success') . "');window.location='index.php';</script>");
            }
            $condition['username'] = $_POST['username'];
            $condition['password'] = $_POST['password'];

            $string = 'userid,parentid,username,password,email,status';
            $list = $form->where($condition)->order('userid DESC')->field($string)->findAll();
            //$a=new model();
            //dump($a->getlastsql($form->where($condition)->order('userid DESC')->field($string)->findAll()));die();
            if ($list) {
                $username = $list[0]['username'];
                //Cookie::set($cookie_username,$_POST['username'],time()+3600000);
                setcookie($cookie_name . "username", $list[0]['username'], time() + 360000, '/');
                setcookie($cookie_name . "userid", $list[0]['userid'], time() + 3600 * 24, '/'); /* 有效期1天 */
                setcookie($cookie_name . "parentid", $list[0]['parentid'], time() + 3600 * 24, '/'); /* 有效期1天 */
                setcookie($cookie_name . "groupid", $list[0]['group'], time() + 3600 * 24, '/'); /* 有效期1天 */
                setcookie($cookie_name . "username", $list[0]['username'], time() + 3600 * 24, '/'); /* 有效期1天 */
                setcookie($cookie_name . "email", $list[0]['email'], time() + 3600 * 24, '/'); /* 有效期1天 */
                //setcookie($cookie_name . "language", 'cn', time() + 3600 * 24, '/'); /* 有效期1天 */

                //die("<script>alert('".L('success')."');window.location='index.php';</script>");
                die("<script>alert('" . L('login_success') . "');window.location='index.php';</script>");
            } else {
                //print_r("login_error");
                //die("<script>alert('".L('login_error');window.location='index.php?m=user&a=login';</script>");
                die("<script>alert('" . L('login_error') . "');window.location='index.php?m=user&a=login';</script>");
            }
        }
        $this->display();
    }
    
    public function rewrite(){
        $map['username'] = $_COOKIE[C('COOKIE_PREFIX') . 'username'];
        $array = array('username,password');
	$user_detail =D('user')->field($array)->where($map)->limit(1)->select();
 
        if($_POST){
            $where['username'] =  $_COOKIE[C('COOKIE_PREFIX') . 'username'];
 
            $maps['password'] = trim($_POST['new_password']);
            
            $resp = D('user')->where($where)->save($maps);
          
      
            if($resp){
               echo "<script>alert('已修改成功!');window.location='?m=purview&a=index'</script>";

            }else{
                echo "<script>alert('无法修改! ');window.location='?m=purview&a=index'</script>";
            }
        }
        
        $this->assign("user_detail",$user_detail[0]);
        $this->display();

    }
}
?>
