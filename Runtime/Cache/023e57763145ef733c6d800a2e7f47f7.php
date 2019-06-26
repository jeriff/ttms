<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- layout::layout:header_do::0 -->
        <title><?php echo (C("title_oms_version")); ?>--项目管理</title>

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
            <form action="?m=purview&a=delete_user" method="post" id="user_delete" name="">
                <table style="width:98%;margin: 0 auto;margin-top: 10px;" id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <thead>
                        <tr>
                            <th width="40"></th>
                            <th width="40">管理员</th>
                            <th>用户名</th>
                            <th>用户状态</th>
                            <th>邮箱地址</th>
                            <th align="center">操作</th>
                        </tr>

                    </thead>
                    <!--
                    <tbody>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                        <td><input type="checkbox" value="<?php echo ($vo["userid"]); ?>" name="userid[]"></td>
                        <td><?php echo ($vo["username"]); ?></td>
                        <td>
                            <?php if($vo["status"] == 0): ?>未激活<?php endif; ?>
                            <?php if($vo["status"] == 1): ?>已激活<?php endif; ?>
                            <?php if($vo["status"] == 9): ?>不可用<?php endif; ?>
                        </td>
                        <td><?php echo ($vo["email"]); ?></td>
                        <td align="center">
                                        &nbsp;
                        <a href="?m=purview&a=edit_user&userid=<?php echo ($vo["userid"]); ?>"><img border="0" align="absmiddle" src="Public/Images/edit.png" title="编 辑"></a>
                                        &nbsp;
                        
                        </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                       
                    </tbody>
                    -->
                     <?php echo ($datas); ?>
                    <tfoot>
                        <tr>
                            <td align="center" colspan="6">
                        <label> <input type="submit" value="删除" class="btn"></label></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>

        
        
        <!-- layout::layout:footer::0 -->

    </body>
</html>