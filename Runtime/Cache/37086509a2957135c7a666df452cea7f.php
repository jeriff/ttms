<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- layout::layout:header_do::0 -->
        <title><?php echo (C("title_oms_version")); ?>--项目管理</title>
        <script>
            $("input.Wdate").live('click', function(){WdatePicker({dateFmt:'yyyy-MM-dd'});});
        </script>

    </head>
    <body>
        <!-- layout::layout:header::0 -->
        <div id="quick_menu_box">
            <a onclick="window.location.reload();return false;"><img src="Public/Images/ico/refresh.png" style="vertical-align:middle" border="0" /><?php echo (L("refresh")); ?></a>
            <span style="color:#98c8ff; padding:0 5px;">|</span>
            <a href="?m=project&a=add_project&type=add"><img src="Public/Images/ico/add.png" style="vertical-align:middle" border="0" /><?php echo (L("add")); ?></a>
        </div>

        <!--搜索区域-->
        <div id="search_box">
            <form action="__APP__?m=project&a=index" method="GET" id="project_search" name="project_search">
                <input type="hidden" id="m" name="m" value="project"/>
                <input type="hidden" id="a" name="a" value="index"/>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <label><span><?php echo (L("project_site")); ?>:</span> <?php echo ($project_site); ?></label>
                            <label><span><?php echo (L("project_status")); ?>:</span> <?php echo ($project_status); ?></label>
                            <label><span><?php echo (L("project_ontime")); ?>:</span> <input size="15" name="project_ontime" type="text" class="Wdate"  maxlength="50" value="<?php echo ($project_ontime); ?>" /></label>
                            <label><span><?php echo (L("server_ip")); ?>:</span> <?php echo ($server_ip); ?></label>
                            <br/>
                            <label style="width:225px;"><span><?php echo (L("project_name")); ?>:</span> <input size="15" name="project_name" type="text" class="txt" id="tid" maxlength="50" value="<?php echo ($project_name); ?>" /></label>
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
                    <th><?php echo (L("project_name")); ?></th>
                    <th><?php echo (L("project_site")); ?></th>
                    <th><?php echo (L("project_status")); ?></th>
                    <th><?php echo (L("project_ontime")); ?></th>
                    <th><?php echo (L("project_offlinetime")); ?></th>
                    <th><?php echo (L("server_ip")); ?></th>
                    <th><?php echo (L("create")); ?> / <?php echo (L("project_last_status_by")); ?></th>
                    <th align="center"><?php echo (L("action")); ?></th>
                </tr>

            </thead>
            <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                    <td><?php echo ($vo["project_name"]); ?></td>
                    <td><?php echo $server['server_site'][$vo['project_site']]; ?></td>
                    <td><?php echo $status['project_status'][$vo['project_status']]; ?></td>
                    <td><?php echo ($vo["project_ontime"]); ?></td>
                    <td><?php if( $vo["project_status"] =='4'): ?><?php echo ($vo["project_offlinetime"]); ?><?php endif; ?></td>
                    <td><?php echo ($vo["server_ip"]); ?></td>
                    <td><?php echo ($vo["created_by"]); ?> / <?php echo ($vo["modified_by"]); ?></td>
                    <td align="center">
                        <a  href='?m=project&a=add_project&project_id=<?php echo ($vo["project_id"]); ?>&type=edit' title=""><img title="<?php echo (L("edit")); ?>" src="public/images/edit.png" border="0" align="absmiddle" /></a>
                        <a  href='?m=project&a=add_project&project_id=<?php echo ($vo["project_id"]); ?>&type=view' title=""><img title="<?php echo (L("view")); ?>" src="public/images/view.png" border="0" align="absmiddle" /></a>
                        <a id="delete" title="删除" href="?m=project&a=delete&project_id=<?php echo ($vo["project_id"]); ?>&type=delete"><img src="Public/Images/ico/close_red.gif" style="vertical-align:middle" border="0" title="删除"/></a>
						<a title="相关文档" href="?m=Document&a=index&project_name=<?php echo urlencode($vo['project_name']);?>"><img src="Public/Images/ico/images.jpg" style="vertical-align:middle" border="0" title="相关文档"/></a>
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
    <script>
        $('#delete').live('click',function(){
            if(confirm("你确定要删除此项目吗?")){
                return ture;
            }else
            {
                return false;
            }
        });
    </script>
</html>