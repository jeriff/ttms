<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- layout::layout:header_do::0 -->
        <title><?php echo (C("title_oms_version")); ?>--项目管理</title>
        <link href="Public/css/colorbox.css" rel="stylesheet" type="text/css" />
        <script src="Public/js/jquery.colorbox-min.js" type="text/javascript" ></script>
    </head>
    <body>
        <!-- layout::layout:header::0 -->
        <div id="quick_menu_box" style="border-bottom: 1px solid #81afd9;">
            <a href="?m=system&a=index"><img src="Public/Images/config.png" width="20px" height="20px" style="vertical-align:middle" border="0" />数据库配置</a>
		<span style="color:#98c8ff; padding:0 5px;">|</span>
		<a href="?m=system&a=menu"><img src="Public/Images/dictionary.gif" width="20px" height="20px" style="vertical-align:middle" border="0" />数据字典</a>
	</div>
        <div id="system_menu">
            <table>
                <tr id="ml">
                <td width="50px"><span id="menu" class="btn1"><a href="#">菜单</a></span></td>
                <td width="50px"><span id="task" class=""><a href="#">任务</a></span></td>
                <td width="50px"><span id="server" class=""><a href="#">服务器</a></span> </td>
                <td width="50px"><span id="permission" class=""><a href="#">权限</a></span></td>
                <td width="50px"><span id="project" class=""><a href="#">项目</a></span></td>
                <td width="50px"><span id="document" class=""><a href="#">文档</a></span></td>
                <td width="50px"><span id="question" class=""><a href="#">问题</a></span></td>
                </tr>
            </table>	
        </div>
        <form action="__APP__?m=system&a=update" method="POST" onsubmit="return aa();">
            <div id="ajaxdata">
                <a id="addnew" href='#' style='width:98%;margin:0 auto;font-size:20px;margin-left:10px;'>添加</a>
                <table style='width:98%;margin: 0 auto;margin-top: 10px;' id='myListTable' class='tablesorter' border='0' cellpadding='0' cellspacing='1'>
                    <tr>
                        <td width="100px">标题</td><td colspan='2'>链接</td>
                    </tr> 
                    <?php if(is_array($task)): $i = 0; $__LIST__ = $task;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
                        <td><?php echo ($vo[title]); ?></td><td colspan='2'><input type="hidden" name="<?php echo ($key); ?>[title]" value="<?php echo ($vo[title]); ?>" /><input type="text" name="<?php echo ($key); ?>[link]" value="<?php echo ($vo[link]); ?>" size="50px"/></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <input type="hidden" name="title" id="title" value="menu" />
                    <input type="hidden" name="number" id="number" value="<?php echo ($number); ?>" />
                </table>
            </div>
            <div class="button_btn">
                <input type="submit" name="submit" id="edit" value="保存" class="btn" />
                <input type="button" value="取消" class="btncancel" />
            </div>
        </form>           
		
<script>
        $('.btncancel').live('click',function(){
            window.location = '?m=system&a=menu';
            return false;
        });
		
    function aa(){
        var num = 0;
        $("table#myListTable input").each(function(){
            if($(this).val() == ""){
                num=1;
                alert('配置项不可设为空！！');
                return false;
            }
        });
        if(num == 1){
            return false;
        }else{
            return true;
        }
    }   
    function dele(number){
        var numb='icon_'+number;
        $('tr#'+numb).remove();
        return false;
    }
   
        $('#addnew').live('click',function(){
        var title=$('input#title').val();
        var number = (parseInt($("input#number").val())+1);
         switch (title){
             case 'menu':
                  $('#myListTable').append("<tr id='icon_"+number+"'><td><input type='text' name='icon_"+number+"[title]' value='' /></td><td><input type='text' name='icon_"+number+"[link]' value='' size='50px' /></td><td><span id='dele' ><a href='#' onclick='return dele("+number+");'>删除</a></span></td></tr>");
                  $("input#number").val(number);
              break;
              
            default :
                var ml=$('input#ml').val();
                  $('#myListTable').append("<tr id='icon_"+number+"'><td><input type='text' name='k["+number+"]' value='' /></td><td><input type='text' name='v["+number+"]' value='' size='50px' /></td><td><span id='dele' ><a href='#' onclick='return dele("+number+");'>删除</a></span></td></tr>");
                  $("input#number").val(number);
        }
        });
       
        $('tr#ml span').click(function(){
            var id=$(this).attr('id');
            $('tr#ml span').removeClass('btn1');
            $('#'+id).addClass('btn1');
            $.ajax({
                type:'GET',
                url:'?m=system&a=ajaxdata&id='+id,
                dataType:'HTML',
                success:function(msg){
                    $('#ajaxdata').empty();
                    $('#ajaxdata').html(msg);  
                }
            });
        })
       
        $('tr#ml2 span').live('click',function(){
            var id=$(this).attr('id');
            var idd=$(this).attr('name');
            $('tr#ml2 span').removeClass('btn1');
            $('#'+id).addClass('btn1');
            $.ajax({
                type:'GET',
                url:'?m=system&a=ajaxdata&idd='+id+'&id='+idd,
                dataType:'HTML',
                success:function(msg){
                    $('#ajaxdata').empty();
                    $('#ajaxdata').html(msg);  
                }
            });
        })
  
</script>
        <!-- layout::layout:footer::0 -->
    </body>
</html>