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
            <a href="?m=server&a=add_server&type=add"><img src="Public/Images/ico/add.png" style="vertical-align:middle" border="0" /><?php echo (L("add")); ?></a>
        </div>

        <!--搜索区域-->
        <div id="search_box">
            <form action="__APP__?m=server&a=index" method="GET" id="project_search">
                <input type="hidden" id="m" name="m" value="server"/>
                 <input type="hidden" id="a" name="a" value="index"/>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <label><span>服务器名称:</span> <input size="15" name="server_name" type="text"   maxlength="50" value="<?php echo ($server_name); ?>" /></label>
                            <label><span>服务器IP:</span> <?php echo ($server_ip); ?></label>
                            <label><span>服务器状态:</span> <?php echo ($server_status); ?></label>
                            <label><span>服务器站点:</span> <?php echo ($server_site); ?></label>
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
                        <th>服务器名称</th>
                        <th>服务器IP</th>
                        <th>服务器类型</th>
                        <th>服务器状态</th>
                        <th>服务器站点</th>
                         <th>创建 / 最后修改</th>
                        <th align="center">操作</th>
                    </tr>

                </thead>
                <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                        <td><?php echo ($vo["server_name"]); ?></td>
                        <td><?php echo ($vo["server_ip"]); ?></td>
                        <td><?php $type=explode(',',$vo[server_type]); foreach($type as $key=>$value){ if(count($type)>1 && count($type)!=($key+1) ) { echo $server['server_type'][$value]." | "; } else if(count($type)==($key+1)){ echo $server['server_type'][$value]; } else{ echo $server['server_type'][$value]; }  } ?></td>
                        <td><?php echo $server['server_status'][$vo['server_status']]; ?></td>
                        <td><?php echo $server['server_site'][$vo['server_site']]; ?></td>
                        <td><?php echo ($vo["created_by"]); ?> / <?php echo ($vo["modified_by"]); ?></td>
                        <td align="center">
                            
                            <a  href='?m=server&a=add_server&server_id=<?php echo ($vo["server_id"]); ?>&type=edit' title=""><img title="修改" src="public/images/edit.png" border="0" align="absmiddle" /></a>
                           <a  href='?m=server&a=add_server&server_id=<?php echo ($vo["server_id"]); ?>&type=view' title=""><img title="查看" src="public/images/view.png" border="0" align="absmiddle" /></a>
                            <a id="delete" title="删除" href="?m=server&a=delete&server_id=<?php echo ($vo["server_id"]); ?>&type=delete"><img src="Public/Images/ico/close_red.gif" style="vertical-align:middle" border="0" title="删除"/></a>
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