<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- layout::layout:header_do::0 -->
        <link href="Public/css/colorbox.css" rel="stylesheet" type="text/css" />
        <script src="Public/js/jquery.colorbox-min.js" ></script>
        <title>时间&任务管理系统 TTMS--我的任务</title> 
    </head>
    <body>
        <!-- layout::layout:header::0 -->
        <div id="quick_menu_box">
            <a href="javascript:;" onclick="window.location.reload();return false;"><img src="Public/Images/ico/refresh.png" style="vertical-align:middle" border="0" /><?php echo (L("refresh")); ?></a>
            <span style="color:#98c8ff; padding:0 5px;">|</span>
            <a class="colorbox" title="任务添加" href="__APP__?m=SimplifyTask&a=add"><img src="Public/Images/ico/add.png" style="vertical-align:middle" border="0" />添加任务</a>
        </div>
        <!--搜索区域-->
        <div id="search_box">
            <form action="__APP__?m=SimplifyTask&a=index" method="GET" id="task_search" name="task_search">
                <input type="hidden" id="m" name="m" value="<?php echo ($m); ?>" />
                <input type="hidden" id="a" name="a" value="<?php echo ($a); ?>" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <label><span>任务时间:</span>
                                <input type="text" id="week_time" name="week_time" class="Wdate" onFocus="WdatePicker({isShowWeek:true,dateFmt:'yyyy-M-d 第W周'})" value="<?php echo ($week_time); ?>"/>
                            </label>
                            <label><span>任务类型:</span> <?php echo ($task_type); ?></label>
                            <label><span>任务状态:</span> <?php echo ($task_status); ?></label>
                            <!--<label><span>任务分配人:</span><input size="15" name="assignment" type="text" class="txt" id="assignment" maxlength="50" value="<?php echo ($assignment); ?>" /></label>-->
                           <label style="width:300px;"><span>任务执行人:</span><?php echo ($listparent); ?></label>
                            <label><div class="button"><input type="submit" name="" id="" value="搜索" class="btn" /></div></label>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="mainblock" style="width:98%;margin: 0 auto;margin-top: 10px;">
            <div style="line-height: 2.5;height: 8px;">
                <span style="float:left;margin-top:-8px;" >
                    预计总工时：<span style="color:#ff0000;" ><?php echo ($list['man_day']); ?></span>小时&nbsp;
					实际总工时：<span style="color:#ff0000;" ><?php echo ($list['true_man_day']); ?></span>小时
                    <input type="text" style="color:blue;" id="" name="" value="<?php echo ($date[0]); ?>" readonly=true />~~
                    <input type="text" style="color:blue;" id="" name="" value="<?php echo ($date[1]); ?>" readonly=true />
                </span>
            </div>
            <table id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                <thead>
                    <tr>
                        <th>任务名称</th>
                        <th>状态</th>
                        <th>任务类型</th>
                        <th>执行人</th>
                        <th>预计工时</th>
                        <th>实际工时</th>
                        <th>开始时间</th>
                        <th>结束时间</th>
                        <th align="center">操作</th>
                    </tr>

                </thead>
                <tbody>
                    <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr title="<?php echo ($vo["remark"]); ?>">
                        <td><?php echo ($vo['task_name']); ?></td>
                        <td><?php echo $task['task_status'][$vo['task_status']]; ?></td>
                        <td><?php echo $task['task_type'][$vo['task_type']]; ?></td>
                        <td><?php echo ($vo['created_by']); ?></td>
                        <td><?php echo ($vo['man_day']); ?></td>
                        <td><?php echo ($vo['true_man_day']); ?></td>
                        <td><?php echo ($vo['begin_time']); ?></td>
                        <td><?php echo ($vo['end_time']); ?></td>
                        <td align="center">
                                <a class="colorbox" id="view" title="任务查看" href="?m=SimplifyTask&a=view&task_id=<?php echo ($vo['task_id']); ?>"><img src="Public/Images/view.png" style="vertical-align:middle" border="0" title="查看"/></a>
                                <?php if(($vo['created_by'] == $user || $is_admin == 1)){ ?>
                                <a id="delete" title="任务删除" href="?m=SimplifyTask&a=delete&task_id=<?php echo ($vo['task_id']); ?>"><img src="Public/Images/ico/close_red.gif" style="vertical-align:middle" border="0" title="删除"/></a>
                                <a class="colorbox" title="任务编辑" href="?m=SimplifyTask&a=add&task_id=<?php echo ($vo['task_id']); ?>"><img src="Public/Images/edit.png" style="vertical-align:middle" border="0" title="编辑"/></a>
                                <?php } ?>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <div id="win"></div>
            <center>
                <div class="pageNav"><?php echo ($list["show"]); ?></div>
            </center>
        </div>
        <!-- layout::layout:footer::0 -->
    </body>
<script language="javascript">
    $(document).ready(function(){
        $("a.colorbox").colorbox({
		overlayClose:false
		});
        $('a#delete').bind('click',function(){
            if(confirm("你确定要删除吗?")) {
                var url = $(this).attr('href'); 
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    success: function(data){
//                        console.log(data);
                        $.colorbox({
                            html:data.info,
                            width: '20%',
                            height: '20%',
                            onClosed:function(){
                                window.location.reload();
                            }
                        });
                    }
                });
            }
            return false;
        });
    });
    
</script>
</html>