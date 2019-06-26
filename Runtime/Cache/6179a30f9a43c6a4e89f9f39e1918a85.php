<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- layout::layout:header_do::0 -->
        <title><?php echo (C("title_oms_version")); ?>--项目管理</title>
        <script>
            $("input.Wdate").live('click', function(){WdatePicker({dateFmt:'yyyy-MM-dd'});});
			
        </script>
<style>
	.pro_length{
		width:250px;
	}
	
	.require-span{
	width:250px;
	}
</style>
    </head>
    <body>
        <!-- layout::layout:header::0 -->
        <div id="quick_menu_box" style="border-bottom:1px solid #81afd9;">
            <a onclick="window.location.reload();return false;"><img src="Public/Images/ico/refresh.png" style="vertical-align:middle" border="0" /><?php echo (L("refresh")); ?></a>
        </div>

        <form action="?m=project&a=add_project" method="POST">
            <table id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1" style="margin: 0 auto;margin-bottom:20px;width:98%;margin-top: 10px;">
                <tbody><tr>
                        <td align="left" width="150" class="td_left"><?php echo (L("project_name")); ?>：</td>
                        <td><input type="text" id="project_name" size="45" name="project_name" value="<?php echo ($project["project_name"]); ?>" />
                            <span class="require-field">*</span></td>
                    </tr>
					<tr>
                    <td align="left" class="td_left">所属项目组：</td>
                        <td><input type="text" id="project_group" size="45" name="project_group" value="<?php echo ($project["project_group"]); ?>"/>
                        </td>
					</tr>
					<tr>
                    <td align="left" class="td_left">项目类型：</td>
                        <td><?php echo ($project_type); ?>
                        </td>
					</tr>
					<tr>
                    <td align="left" class="td_left">项目业务类型：</td>
                        <td><?php echo ($project_business_type); ?>
                        </td>
					</tr>
                    <tr>
                        <td align="left" class="td_left"><?php echo (L("server_ip")); ?>：</td>
                        <td><?php echo ($server_ip); ?>
                        <span class="require-field">*</span></td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left"><?php echo (L("project_site")); ?>：</td>
                        <td><?php echo ($project_site); ?>
                            <span class="require-field">*</span></td>
                    </tr>
					<tr>
						<td align="left" class="td_left">项目联系人：</td>
						<td>
						<div class="bottom_left">
						<div style="float:left; width:150px;">SDU联系人：</div>
						<input type="text" id="project_SDU_email" name="project_SDU_email" value="<?php echo ($project["project_SDU_email"]); ?>" class="pro_length"/><br>
						<div style="float:left; width:150px;">PM联系人：</div>
						<input type="text" id="project_PM_email" name="project_PM_email" value="<?php echo ($project["project_PM_email"]); ?>" class="pro_length"/><br>
						<div style="float:left; width:150px;">BD联系人：</div>
						<input type="text" id="project_BD_email" name="project_BD_email" value="<?php echo ($project["project_BD_email"]); ?>" class="pro_length"/><br>
						<div style="float:left; width:150px;">TL联系人：</div>
						<input type="text" id="project_TL_email" name="project_TL_email" value="<?php echo ($project["project_TL_email"]); ?>" class="pro_length"/><br>
						<div style="float:left; width:150px;">SV联系人：</div>
						<input type="text" id="project_SV_email" name="project_SV_email" value="<?php echo ($project["project_SV_email"]); ?>" class="pro_length"/><br>
						</div>
						<div class="bottom_right">*联系人为邮件地址，格式（june.gao@transcosmos-cn.com）</div>
						</td>
					</tr>
                    <tr>
                        <td align="left" class="td_left">预计启动时间：</td>
                        <td><input type="text" id="project_appraisetime" class="Wdate" name="project_appraisetime" value="<?php echo ($project["project_appraisetime"]); ?>" />
                            <span class="require-field">*</span></td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left"><?php echo (L("project_ontime")); ?>：</td>
                        <td><input type="text" id="project_ontime" class="Wdate" name="project_ontime" value="<?php echo ($project["project_ontime"]); ?>" />
                            <span class="require-field">*</span></td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left">项目测试环境：</td>
                        <td>
						<div class="bottom_left"><div class="value_copy">
						<div style="float:left; width:150px;">OMS测试地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_test_oms" name="project_test_oms" value="<?php echo ($project["project_test_oms"]); ?>" class="pro_length"/></div>
						<div class="value_copy">
						<div style="float:left; width:150px;">CRM测试地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_test_crm" name="project_test_crm" value="<?php echo ($project["project_test_crm"]); ?>" class="pro_length" /></div>
						<div class="value_copy">
						<div style="float:left; width:150px;">FTP测试地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_test_ftp" name="project_test_ftp" value="<?php echo ($project["project_test_ftp"]); ?>" class="pro_length"/></div>
						<div class="value_copy">
						<div style="float:left; width:150px;">EC_REPORT测试地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_test_ecreport" name="project_test_ecreport" value="<?php echo ($project["project_test_ecreport"]); ?>" class="pro_length"/></div>
						<div class="value_copy">
						<div style="float:left; width:150px;">报表测试地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_test_report" name="project_test_report" value="<?php echo ($project["project_test_report"]); ?>" class="pro_length"/></div>
						</div>
                            <div class="require-field bottom_right">*格式(172.16.216.225 / ttms)</div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left">项目正式环境：</td>
                        <td>
						<div class="bottom_left"><div class="value_copy">
						<div style="float:left; width:150px;">OMS地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_official_oms" name="project_official_oms" value="<?php echo ($project["project_official_oms"]); ?>" class="pro_length"/></div>
						<div class="value_copy">
						<div style="float:left; width:150px;">CRM地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_official_crm" name="project_official_crm" value="<?php echo ($project["project_official_crm"]); ?>" class="pro_length"/></div>
						<div class="value_copy">
						<div style="float:left; width:150px;">FTP地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_official_ftp" name="project_official_ftp" value="<?php echo ($project["project_official_ftp"]); ?>" class="pro_length"/></div>
						<div class="value_copy">
						<div style="float:left; width:150px;">EC_REPORT地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_official_ecreport" name="project_official_ecreport" value="<?php echo ($project["project_official_ecreport"]); ?>" class="pro_length"/></div>
						<div class="value_copy">
						<div style="float:left; width:150px;">报表地址：</div><?php echo ($select_ip); ?>
						<input type="text" id="project_official_report" name="project_official_report" value="<?php echo ($project["project_official_report"]); ?>" class="pro_length"/></div>
						</div>
                            <div class="require-field bottom_right">*格式(172.16.216.225 / ttms)</div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left"><?php echo (L("project_status")); ?>：</td>
                        <td><?php echo ($project_status); ?>
                            <span class="require-field">*</span></td>
                    </tr>
                    <tr id="offline"  style=" display: none;">
                        <td align="left" class="td_left"><?php echo (L("project_offlinetime")); ?>：</td>
                        <td><input type="text" class="Wdate" id="project_offlinetime" name="project_offlinetime" value="<?php echo ($project["project_offlinetime"]); ?>" />
                            <span class="require-field">*</span></td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left"><?php echo (L("project_info")); ?>：</td>
                        <td><textarea class="txtarea " id="project_info" name="project_info" style="width:250px; height:50px;"><?php echo ($project["project_info"]); ?></textarea></td>
                    </tr>
                    <tr>
                        <td align="left" class="td_left"><?php echo (L("project_remark")); ?>：</td>
                        <td><textarea class="txtarea " id="project_remark" name="project_remark" style="width:250px; height:50px;"><?php echo ($project["project_remark"]); ?></textarea></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="hidden" name="project_id" value="<?php echo ($project["project_id"]); ?>"/>
                            <?php if($a =='edit'){ ?>
                            <input type="submit" name="submit" id="save" value="<?php echo (L("save")); ?>" class="btn" />
                            <input type="button" name="submit"  value="<?php echo (L("return")); ?>" class="btncancel" />
                            <?php  } else if($a == 'view'){ ?>
                            <input type="button" name="submit"  value="<?php echo (L("return")); ?>" class="btncancel" />
                            <?php }else if($a =='add'){ ?>
                            <input type="submit" name="submit" id="add" value="<?php echo (L("add")); ?>" class="btn" />
                            <input type="button" value="<?php echo (L("cancel")); ?>" class="btncancel" />
                            <?php } ?>
                        </td>
                    </tr>
                </tfoot>

            </table>
        </form>
        <!-- layout::layout:footer::0 -->
    </body>
    <script>
		$('div.value_copy select').live('change',function(){
			var val = $(this).val();
			$(this).next('input').val(val);
		});
        $('.btncancel').live('click',function(){
            window.location = '?m=project&a=index';
            return false;
        });
        $(document).ready(function() {
            if($('#project_status').val() == '4'){
                $('#offline').show();
            }
            else{
                $('#offline').hide();
                $('#project_offlinetime').attr('value','');
            }
        });
        $('#project_status').live("change",function(){
          
            if($(this).val() == '4'){
                $('#offline').show();
            }
            else{
                $('#project_offlinetime').attr('value','');
                $('#offline').hide();
            }
        });
        
        $('.btn').live('click',function(){
            if($('#project_name').val()==''){
                 art.dialog({
                    title: '消息',
                    content: '项目名称不能为空',
                    okValue:'确定',
                    lock: true,
                    ok: function(){
                        return true;
                    }
                });
                return false;
            }
            /*else if($('#project_url').val()==''){
                 art.dialog({
                    title: '消息',
                    content: '项目地址不能为空，请按照右侧给出的格式填写',
                     okValue:'确定',
                     lock: true,
                    ok: function(){
                        return true;
                    }
                });
                return false;
            }*/
            else if($('#server_ip').val()==''){
                 art.dialog({
                    title: '消息',
                    content: '请选择项目的服务器IP地址',
                    okValue:'确定',
                    lock: true,
                    ok: function(){
                        return true;
                    }
                });
                return false;
            }
            else if($('#project_site').val()==''){
                 art.dialog({
                    title: '消息',
                    content: '请选择项目的站点地址',
                     okValue:'确定',
                     lock: true,
                    ok: function(){
                        return true;
                    }
                });
                return false;
            }
            if($('#project_status').val()==''){
                 art.dialog({
                    title: '消息',
                    content: '请选择项目的状态',
                     okValue:'确定',
                     lock: true,
                    ok: function(){
                        return true;
                    }
                });
                return false;
            }
            if($('#project_appraisetime').val()==''){
                 art.dialog({
                    title: '消息',
                    content: '项目的预计上线时间不能为空',
                    okValue:'确定',
                    lock: true,
                    ok: function(){
                        return true;
                    }
                });
                return false;
            }
            if($('#project_ontime').val()==''){
                 art.dialog({
                    title: '消息',
                    content: '项目的上线时间不能为空',
                    okValue:'确定',
                    lock: true,
                    ok: function(){
                        return true;
                    }
                });
                return false;
            }
           
            else if(($('#project_status').val() == '4' && $('#project_offlinetime').val()=='') || ($('#project_status').val() == '4' && $('#project_offlinetime').val()=='0000-00-00')){
                art.dialog({
                    title: '消息',
                    content: '下线时间不能为空',
                    okValue:'确定',
                    lock: true,
                    ok: function(){
                        return true;
                    }
                });
                return false;
            }
        });
    </script>
</html>