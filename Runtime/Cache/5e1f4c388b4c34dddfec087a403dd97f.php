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
            textarea{width:95%;height:100px;}
        </style>
    </head>
    <body>
        <!-- layout::layout:header::0 -->
        <div id="quick_menu_box" style="border-bottom:1px solid #81afd9;">
            <a onclick="window.location.reload();return false;"><img src="Public/Images/ico/refresh.png" style="vertical-align:middle" border="0" /><?php echo (L("refresh")); ?></a>
        </div>

        <form action="?m=question&a=update" method="POST" enctype="multipart/form-data">
            <table id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1" style="margin: 0 auto;margin-bottom:20px;width:98%;margin-top: 10px;">
                <tbody>
                    <tr>
                        <td>项目名称：</td>
                        <td colspan="3">
                           <?php echo ($project); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>记录类型</td>
                        <td><?php echo ($log_type); ?></td>
                        <td>问题类型</td>
                        <td><?php echo ($question_type); ?></td>
                    </tr>
                     <tr>
                        <td>报告方</td>
                        <td><?php echo ($report_party); ?></td>
                        <td>报告时间</td>
                        <td><input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});" id="report_date" name="report_date" value="<?php echo ($model["report_date"]); ?>"/></td>
                    </tr>
                     <tr>
                        <td>报告人</td>
                        <td><input type="text" name="report_user" value="<?php echo ($model["report_user"]); ?>"></td>
                         <td>产生工时（时）</td>
                        <td><input type="text" name="process_time" value="<?php echo ($model["process_time"]); ?>">(时)</td>
                    </tr>
                     <tr>
                        <td>事件内容</td>
                        <td><textarea name="question_contetn"><?php echo ($model["question_contetn"]); ?></textarea></td>
                        <td>影响</td>
                        <td><textarea name="affect"><?php echo ($model["affect"]); ?></textarea></td>
                    </tr>
                     <tr>
                        <td>原因</td>
                        <td><textarea name="reason"><?php echo ($model["reason"]); ?></textarea></td>
                        <td>对策</td>
                        <td><textarea name="countermeasure"><?php echo ($model["countermeasure"]); ?></textarea></td>
                    </tr>
                    <tr>
                       
                        <td>责任归类</td>
                        <td><?php echo ($blame); ?></td>
                        <td>备注</td>
                        <td><textarea name="remark"><?php echo ($model["remark"]); ?></textarea></td>
                    </tr>
                    <tr>
                        <td rowspan="2">处理人</td>
                        <td rowspan="2"><?php echo ($user_array); ?></td>
                        <td>处理时间</td>
                        <td><input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});" id="time" name="time" value="<?php echo ($model["time"]); ?>"/></td>
                    </tr>
                     <tr>
                        <td>上传证据</td>
                        <td><input type="file" name="attachment" />(多个文件打包上传)</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" align="center">
                            <input type="hidden" name="id" value="<?php echo ($model["id"]); ?>"/>
                            <input type="submit" name="submit" id="save" value="保存" class="btn" />
                            <input type="button" name="submit"  value="返回" class="btncancel" />
                        </td>
                    </tr>
                </tfoot>

            </table>
        </form>
        <!-- layout::layout:footer::0 -->
    </body>
<script>
    $('.btncancel').live('click',function(){
            window.location = '?m=question&a=index';
            return false;
        });
</script>
</html>