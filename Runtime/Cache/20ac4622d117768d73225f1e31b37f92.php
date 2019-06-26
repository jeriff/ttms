<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- layout::layout:header_do::0 -->
        <title><?php echo (C("title_oms_version")); ?>--用户管理</title>

    </head>
    <body>
        <!-- layout::layout:header::0 -->
        <div style="border-bottom:1px solid #81afd9;" id="quick_menu_box">
            <a onclick="window.location.reload();return false;"><img src="Public/Images/ico/refresh.png" style="vertical-align:middle" border="0" /><?php echo (L("refresh")); ?></a>
            <span style="color:#98c8ff; padding:0 5px;">|</span>
            <a href="?m=purview&a=add_user"><img src="Public/Images/ico/add.png" style="vertical-align:middle" border="0" />添加用户</a>
            <span style="color:#98c8ff; padding:0 5px;">|</span>
            <a href="?m=purview&a=index"><img src="Public/Images/ico/add.png" style="vertical-align:middle" border="0" />用户列表</a>
        </div>


        <div class="mainblock">
            <form action="?m=purview&a=<?php echo ($a); ?>" method="POST" id="" name="">
                <table cellspacing="1" cellpadding="0" border="0" style="width:98%; margin: 0 auto; margin-top: 10px;" class="tablesorter"  id="myListTable">
                <tbody>
                    <input type="hidden" value="<?php echo ($select_user["userid"]); ?>" name="userid">
                    <tr>
                        <td width="150" align="left" class="td_left" style="">所属上级：</td>
                        <td style=""><?php echo ($listparent); ?> <span class="require-field">*</span></td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left" style="">用户名：</td>
                        <td style="">
                            <input type="text"  name="username" size="20" value="<?php echo ($select_user["username"]); ?>">
                            <span class="require-field">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left" style="">密码：</td>
                        <td style=""><input type="text"  name="password" size="20" value="<?php echo ($select_user["password"]); ?>">
                            <span class="require-field">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left" style="">Email:：</td>
                        <td style=""><input type="text"  name="email" size="20" value="<?php echo ($select_user["email"]); ?>">
                            <span class="require-field">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="left" class="td_left" style="">用户状态：</td>
                        <td style="">
                        <select name="status">
                            <option>请选择</option>
                            <option <?php if($select_user['status']==0){  ?>selected <?php } ?> value="0">未激活</option>
                            <option <?php if($select_user['status']==1){  ?>selected <?php } ?> value="1">已激活</option>
                            <option <?php if($select_user['status']==9){  ?>selected <?php } ?> value="9">已删除</option>
                        </select>
                         <span class="require-field">*</span></td>
                    </tr>
                    <tr>
                        <td width="150" align="left" class="td_left" style="">是否为管理员：</td>
                        <td style="">
                        <select name="is_admin">
                        <option>请选择</option>
                        <option <?php if($select_user['is_admin']==1){  ?>selected <?php } ?> value="1">是</option>
                        <option <?php if($select_user['is_admin']==0){  ?>selected <?php } ?> value="0">否</option>
                    </select>
                         <span class="require-field">*</span></td>
                    </tr>    
                   
                 
             
                <?php echo ($privilign); ?> 
            
                        
                <tr>
                    <td align="center" colspan="2">
                        <label>
                    全选/消<input type="checkbox" value="" name="" id="select_all" class="" onclick="var c= this.checked;$('.privileges').each(function(){$(this).attr('checked',c)})" /></label>
                    
                    <input type="submit" class="btn" value="提交">
                       
                    <input type="button" value="返回" name="" class="btncancel" id="" onclick="window.location = '?m=purview&amp;a=index'">
                      
                    </label>
                    </td>
                </tr>
                </tbody>
                </table>
            </form>
        </div>
        
<!-- layout::layout:footer::0 -->
    </body>
</html>