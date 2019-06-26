<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- layout::layout:header_do::0 -->
    <title>时间&任务管理系统 TTMS--文档管理</title> 
</head>
<body>
<!-- layout::layout:header::0 -->
	<div id="quick_menu_box">
		<a href="javascript:;" onclick="window.location.reload();return false;"><img src="Public/Images/ico/refresh.png" style="vertical-align:middle" border="0" /><?php echo (L("refresh")); ?></a>
		<span style="color:#98c8ff; padding:0 5px;">|</span>
		<a href="?m=document&a=add&act=add"><img src="Public/Images/ico/add.png" style="vertical-align:middle" border="0" />添加文档</a>
	</div>
	<!--搜索区域-->
	<div id="search_box">
		<form action="__APP__?m=document&a=index" method="GET" id="document_search" name="document_search">
			<input type="hidden" id="m" name="m" value="document" />
			<input type="hidden" id="a" name="a" value="index" />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<label><span>所属项目:</span>
							<input type="text" id="project_name" name="project_name" value="<?php echo ($project_name); ?>" />
						</label>
						<label><span>文件名称:</span> 
							<input type="text" id="document_file" name="document_file" value="<?php echo ($document_file); ?>" />
						</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><div class="button"><input type="submit" name="" id="" value="搜索" class="btn" /></div></label>
					</td>
				</tr>
			</table>
		</form>
	</div>
<div class="mainblock" style="width:98%;margin: 0 auto;margin-top: 10px;">
	<table id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
		<thead>
			<tr>
				<th>文档名称</th>
				<th>所属项目</th>
				<th>文件名称</th>
				<th>原文件名称</th>
				<th>版本</th>
				<th>文档类型</th>
				<th>文件格式</th>
				<th>创建日期</th>
				<th>创建人</th>
				<th align="center">操作</th>
			</tr>

		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
				<td><?php echo ($vo['document_name']); ?></td>
				<td><?php echo ($vo['project_name']); ?></td>
				<td><a href="./Public/Upload/<?php echo ($vo['document_file']); ?>" ><?php echo ($vo['document_file']); ?></a></td>
				<td><?php echo ($vo['document_old_file']); ?></td>
				<td>第<?php echo ($vo['document_version']); ?>个版本</td>
				<td><?php echo ($vo['document_type']); ?></td>
				<td><?php echo ($vo['document_format']); ?></td>
				<td><?php echo ($vo['created']); ?></td>
				<td><?php echo ($vo['created_by']); ?></td>
				<td>
				<center>
					<a id="view" title="查看" href="?m=document&a=add&id=<?php echo ($vo['id']); ?>&act=view"><img src="Public/Images/view.png" style="vertical-align:middle" border="0" title="查看"/></a>
				<?php if($vo['document_open'] == 'Y' || $user == 'system' || $user == $vo['created_by']){ ?>
					<a id="delete" title="删除" href="?m=document&a=delete&id=<?php echo ($vo['id']); ?>"><img src="Public/Images/ico/close_red.gif" style="vertical-align:middle" border="0" title="删除"/></a>
					<a href="?m=document&a=add&id=<?php echo ($vo['id']); ?>&act=edit"><img src="Public/Images/edit.png" style="vertical-align:middle" border="0" title="编辑"/></a>
				<?php } ?>
				</center>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
<center>
<div class="pageNav"><?php echo ($page); ?></div>
</center>
</div>
<!-- layout::layout:footer::0 -->
</body>
<script language="javascript">
$('a#delete').live('click',function(){
	var title = $(this).attr('title'); 
	if(confirm(title+",你确定吗?")) {
		var url = $(this).attr('href'); 
		$.ajax({
			type: 'GET',
			url: url,
			dataType: 'json',
			success: function(data){
			//console.log(data);
				alert(data.info);
				window.location.reload();
			}
		});
	}
	return false;
});

</script>
</html>