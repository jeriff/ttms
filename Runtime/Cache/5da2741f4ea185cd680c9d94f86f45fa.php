<?php if (!defined('THINK_PATH')) exit();?><div class="mainblock" style="width:700px;">
<table id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1" style="width:98%;margin: 0 auto;margin-top: 10px;">
	<tr>
		<td>任务名称：</td>
		<td><?php echo ($view['task_name']); ?></td>
		<td>所属项目：</td>
		<td><?php echo ($project_name); ?></td>
	</tr>
	<tr>
		<td>开始时间：</td>
		<td><input type="text" style="width: 64%;" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});" id="begin_time" name="begin_time" value="<?php echo ($view['begin_time']); ?>"/></td>
		<td>结束时间：</td>
		<td><input type="text" style="width: 64%;" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});" id="end_time" name="end_time" value="<?php echo ($view['end_time']); ?>"/></td>
	</tr>
	<tr>
		<td>任务类型：</td>
		<td><?php echo ($task['task_type'][$view['task_type']]); ?></td>
		<td>任务状态：</td>
		<td><?php echo ($task['task_status'][$view['task_status']]); ?></td>
	</tr>
    <tr>
		<td>预计工时：</td>
		<td><?php echo ($view['man_day']); ?> &nbsp;小时</td>
        <td>实际工时：</td>
        <td><?php echo ($view['true_man_day']); ?> &nbsp;小时</td>
    </tr>
	<tr>

		<td>备注：</td>
		<td colspan="3"><textarea style="width:95%;height:100px;" id="remark" name="remark"><?php echo ($view["remark"]); ?></textarea></td>
	</tr>
</table>
</div>