<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- layout::layout:header_do::0 -->
        <title><?php echo (C("title_oms_version")); ?>--项目管理</title>

    </head>
    <body>
        <!-- layout::layout:header::0 -->
        <div id="quick_menu_box">
            <a onclick="window.location.reload();return false;"><img src="Public/Images/ico/refresh.png" style="vertical-align:middle" border="0" /><?php echo (L("refresh")); ?></a>
            <span style="color:#98c8ff; padding:0 5px;">|</span>
            <a href="?m=question&a=add"><img src="Public/Images/ico/add.png" style="vertical-align:middle" border="0" /><?php echo (L("add")); ?></a>
            <span style="color:#98c8ff; padding:0 5px;">|</span>
            <a href="#" id="export" rel="?m=question&a=select"><img src="Public/Images/ico/arrow_down.gif" style="vertical-align:middle" border="0" />导出</a>
        </div>

        <!--搜索区域-->
        <div id="search_box">
            <form action="__APP__?m=question&a=index" method="GET">
                <input type="hidden" id="m" name="m" value="question"/>
                <input type="hidden" id="a" name="a" value="index"/>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <label><span>项目名称:</span> <input size="15" name="project_name" type="text"   maxlength="50" value="<?php echo ($project_name); ?>" /></label>
                            <label><span>记录类型:</span> <?php echo ($log_type); ?></label>
                            <label><span>问题类型:</span> <?php echo ($question_type); ?></label>
                            <label><span>报告方:</span> <?php echo ($report_party); ?></label>
                            <!--                            <label><span>责任归类:</span> <?php echo ($blame); ?></label>-->
                            <div class="button"><input type="submit" name="" id="" value="<?php echo (L("search")); ?>" class="btn" /></div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <!--列表开始-->
        <table id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1" style="width:98%;margin: 0 auto;margin-top: 10px;">
            <thead>
                <tr>
                    <th>项目名称</th>
                    <th>记录类型</th>
                    <th>问题类型</th>
                    <th>报告方</th>
                    <th>责任归类</th>
                    <th>证据</th>
                    <th>处理时间</th>
                    <th align="center">操作</th>
                </tr>

            </thead>
            <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                    <td><?php echo ($vo["project_name"]); ?></td>
                    <td><?php $log_type=C('ec_question.log_type'); echo $log_type[$vo['log_type']]; ?></td>
                    <td><?php $question_type=C('ec_question.question_type'); echo $question_type[$vo['question_type']]; ?></td>
                    <td><?php $report_party=C('ec_question.report_party'); echo $report_party[$vo['report_party']]; ?></td>
                    <td><?php $blame=C('ec_question.blame'); echo $blame[$vo['blame']]; ?></td>
                    <td><a href="Public/Attachment/<?php echo ($vo["attachment"]); ?>" target="_blank"><?php echo ($vo["attachment"]); ?></a></td>
                    <td><?php echo ($vo["time"]); ?></td>
                    <td align="center">
                        <a  href='?m=question&a=edit&id=<?php echo ($vo["id"]); ?>' title=""><img title="修改" src="public/images/edit.png" border="0" align="absmiddle" /></a>
                        <a id="delete" title="删除" href="?m=question&a=delete&id=<?php echo ($vo["id"]); ?>"><img src="Public/Images/ico/close_red.gif" style="vertical-align:middle" border="0" title="删除"/></a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        </form>
        <center style="margin-bottom: 20px;">
            <div class="pageNav"><?php echo ($page); ?></div>
        </center>


        <!-- layout::layout:footer::0 -->
    </body>
    <script src="Public/js/artDialog/plugins/iframeTools.js"></script>
    <script>
        $('#delete').live('click',function(){
            if(confirm("你确定要删除此项目吗?")){
                return ture;
            }else
            {
                return false;
            }
        });
        $("#export").live('click',function(){
            var url = $(this).attr('rel');
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function(data){
                    if(data){
                        art.dialog({
                            title: '选择要导出的时间',
                            lock: true,
                            content: data
                        });
                    }
                }
            });
            return false;
        });
        
    </script>
</html>