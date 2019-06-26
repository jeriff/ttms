<?php
header("Content-type: text/html; charset=utf-8");

$arr=include_once('conf/config.php');
//$cookie_name=$arr['COOKIE_PREFIX'];
$cookie_name='ttms_username';



//Cookie::delete($cookie_name);
if($cookie_name){
setcookie($cookie_name, '', time() - 360000, '/');
}
die("<script>alert('已登出');window.location='index.php';</script>");

?>