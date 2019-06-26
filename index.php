<?php
$arr=include_once('conf/config.php');
$cookie_name=$arr['COOKIE_PREFIX'].'username';
$check_cookie=$_COOKIE[$cookie_name];
//print_r($_SERVER['REQUEST_URI']);
if($_GET['m'] != 'user'){

	if($check_cookie){
	
	}else{
	
	//header('Location: index.php?m=user&a=login');    
	die("<script>window.location='?m=user&a=login';</script>");
	
	}
}


// 定义ThinkPHP框架路径
define('THINK_PATH', './../ThinkPHP2.1');
//定义项目名称和路径
define('APP_NAME', 'TTMS');
define('APP_PATH', '.');
// 加载框架入口文件
require(THINK_PATH."/ThinkPHP.php");
//实例化一个网站应用实例
App::run();
?>