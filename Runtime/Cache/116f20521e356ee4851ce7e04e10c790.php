<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- layout::layout:header_do::0 -->
    <title>时间&任务管理系统 TTMS--报表管理</title> 
    <style type="text/css">
    #daohang {background-color: white; padding: 5px;font-size:5px;font-color:white;font-weight:45px}
   
    #checkmainblock {background-color:#98c8ff} 
    /*
    #checkchartdiv_orders {background-color:#98c8ff}
    */
    </style>
</head>
<body>
<!-- layout::layout:header::0 -->
	<div id="quick_menu_box">
		<a href="__APP__?m=Report&a=task_export" ><img src="Public/Images/ico/arrow_down.gif" style="vertical-align:middle" border="0" />导入导出</a>
		<span style="color:#98c8ff; padding:0 5px;">|</span>
		<a href="javascript:;" onclick="window.location.reload();return false;"><img src="Public/Images/ico/refresh.png" style="vertical-align:middle" border="0" /><?php echo (L("refresh")); ?></a>
	</div>
	<!--搜索区域-->
	<div id="search_box">
		<form action="__APP__?m=Report&a=user_task" method="GET" id="task_search" name="task_search">
			<input type="hidden" id="m" name="m" value="Report" />
			<input type="hidden" id="a" name="a" value="user_task" />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<label><span>频率:</span> <?php echo ($task_frequency); ?></label>
						<span>任务时间:</span><label>
						<input type="text" id="week_time" name="week_time" class="Wdate" onFocus="WdatePicker({isShowWeek:true,dateFmt:'yyyy-M-d DD WW'})" value="<?php echo ($week_time); ?>"/>
						</label>
						<div class="button"><input type="submit" name="" id="" value="搜索" class="btn" /></div>
					</td>
				</tr>
			</table>
		</form>
	</div>
        <div id="daohang">
                <table>
                    <tr>
                　　　<span id="checkmainblock" ><a href="#">任务详细</a></sapn>
                    </tr>
                    <tr>
                　　　<span id="checkchartdiv_orders" ><a href="#">任务树状图</a></span>
                </tr>
                </table>
            </div>
<div class="mainblock" style="width:98%;margin: 0 auto;margin-top: 10px;" >
	<table id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
		<thead>
			<tr>
				<th>执行人</th>
				<th>任务数量</th>
				<th>预计总工时</th>
				<th colspan='2'>实际总工时</th>
				
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
				<td><?php echo ($vo['operator']); ?>
				<a rel="?m=report&a=task_count" onclick="get_child_count(this.rel,'<?php echo ($vo["operator"]); ?>','<?php echo ($vo["userid"]); ?>')"><img align='right' src="Public/Images/ico/layout_button_down.gif" style="vertical-align:middle;" border="0" title="查看统计"/>
				</td>
				<td><?php echo ($vo['task_id']); ?></td>
				<td><?php echo ($vo['man_day']); ?></td>
				<td><?php echo ($vo['true_man_day']); ?></td>
				
			</tr>
			<tr id="task_<?php echo ($vo['userid']); ?>" style="display:none;">
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>
<?php if($data != ''): ?><hr>
	<input type="hidden" id="data" name="data" value='<?php echo ($data); ?>' />
	<div id="chartdiv_orders" align="center" style="display:none;">FusionCharts. </div><?php endif; ?>
<!-- layout::layout:footer::0 -->
</body>
<span id="chart" style="margin-top:20px; margin-left:20px; width:800px; height:300px;"></span>
<script language="JavaScript" src="./Public/js/FusionChartsFree/JSClass/FusionCharts.js"></script>
<script language="javascript">
$(document).ready(function(){
var data = $("#data").val();
	if(data != ''){
		var get_report_tid = data.replace(/"/g,"'");
		var chart = new FusionCharts("Public/js/FusionChartsFree/Charts/FCF_MSColumn2D.swf", "ChartId", "1000", "400", true);
		chart.setDataXML(get_report_tid);
		chart.render("chartdiv_orders");
	}
        
        
        
        $("#checkmainblock").click(function(){
            $(".mainblock").css("display","block");
            $("#chartdiv_orders").css("display","none");
            $("#checkmainblock").css("background-color","#98c8ff");
            $("#checkchartdiv_orders").css("background-color","white");
        })      
        
        
        $("#checkchartdiv_orders").click(function(){
            $(".mainblock").css("display","none");
            $("#chartdiv_orders").css("display","block");
            $("#checkmainblock").css("background-color","white");
            $("#checkchartdiv_orders").css("background-color","#98c8ff");
        })      
});
function get_child_count(url,operator,userid){
	var task_frequency = $("#task_frequency").val();
	var week_time = $("#week_time").val();
	$.ajax({
		type: 'POST',
		url: url,
		data: "week_time="+week_time+"&task_frequency="+task_frequency+"&operator="+operator,

		success: function(data){
			//console.log(data);
			if(data){
				$("#task_"+userid).html(data); 
				$("#task_"+userid).toggle('slow');
			}
		}
	});
	return false;
}
</script>
</html>