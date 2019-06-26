<?php
/*各种涉及数据查询操作的函数*/

/**
* @func:用户权限判断
* @param:$do 用户动作
*/

function chk_user_privilege($do)
{
	$userid = trim($_COOKIE[g_cookies_prefix.'userid']);
	if(!chk_privilege($userid,$do))
	{
		die("<script>alert('Access Denied,No Permission!');window.history.go(-1);</script>");

	}
}


function chk_privilege($userid,$do)
{
	if($do == '')return false;
	if(!is_numeric($userid))return false;
	if($userid == 1)return true;
	
	require_once 'mysql.class.php';
	$sql = "SELECT CONCAT_WS(',',r.privileges,u.privileges) as privileges FROM ".g_cookies_prefix."user u INNER JOIN ".g_cookies_prefix."role r ON u.roleid = r.roleid AND u.userid = $userid";
	$dbc = new DB_MYSQL();
	$dbc -> connect(g_db_host, g_db_user, g_db_pass, g_db_name, 0, 'utf8');
	$r = $dbc -> get_one($sql);
	$privileges = $r['privileges'];
	unset($dbc);
	return (strpos($privileges,$do)!==false) ? true : false;

}
?>