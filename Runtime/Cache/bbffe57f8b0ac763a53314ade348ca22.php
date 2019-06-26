<?php if (!defined('THINK_PATH')) exit();?><script src="Public/js/jquery.validate.js" ></script>
<script src="Public/js/jquery.form.js" ></script>

<style type="text/css">
    #project_width {
        width: 800px;
        display: marker;
    }
    #project_width label {display:block;float:left;}
    #project_width br {clear:both;}
</style>
<div class="mainblock">
    <form action="__APP__?m=SimplifyTask&a=add" method="POST" id="task_add" name="task_add">
        <input type="hidden" id="task_id" name="task_id" value="<?php echo ($edit['task_id']); ?>" />
        <table style="width:98%;margin: 0 auto;margin-top: 10px;" id="myListTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
            <tr>
                <td width="100px;">任务名称：</td>
                <td colspan='3'><input type="text" id="task_name" maxlength="50" name="task_name" value="<?php echo ($edit['task_name']); ?>"/>
                <span class="error" style="color:#CC0000"></span></td>
            </tr>
			<tr>
                <td>预计工时：</td>
                <td><input type="text" id="man_day" name="man_day" maxlength="5" value="<?php echo ($edit['man_day']); ?>" />
                <span class="error" style="color:#CC0000"></span></td>
				<td>实际工时：</td>
                <td><input type="text" id="true_man_day" name="true_man_day" maxlength="5" value="<?php echo ($edit['true_man_day']); ?>" />
                <span class="error" style="color:#CC0000"></span></td>
            </tr>
            <tr>
                <td>所属项目：</td>
                <td colspan='3' id="project_width" ><?php echo ($project); ?>
                    <span class="project_error" style="color:#CC0000"></span>
                    </td>
            </tr>
            <tr>
                <td>日期：</td>
                <td><input type="text" style="width: 140px;" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'});"  id="begin_time" name="begin_time" value="<?php echo ($edit["begin_time"]); ?>" />
                <span class="error" style="color:#CC0000"></span></td>
                <td>时间从：</td><td><span id="bgtime"><?php echo ($btime); ?><span class="error" style="color:#CC0000"></span></span>
                    &nbsp;&nbsp;&nbsp;&nbsp;至&nbsp;&nbsp;&nbsp;&nbsp;
                    <span id="edtime"><?php echo ($etime); ?><span class="error" style="color:#CC0000"></span></span>
                     
                </td>
            </tr>
            <tr>
                <td>状态：</td>
                <td><?php echo ($task_status); ?><span class="error" style="color:#CC0000"></span></td>
                <td>类型：</td>
                <td><?php echo ($task_type); ?><span class="error" style="color:#CC0000"></span></td>
            </tr>
            <tr>
                <td>备注：</td>
                <td colspan="3"><textarea style="width:95%;height:100px;" maxlength="300" id="remark" name="remark"><?php echo ($edit['remark']); ?></textarea></td>
            </tr>
            <tr>
                <td colspan="4">
            <center>
                <input type="submit" class="btn" value="保存"/>
            </center>
            </td>
            </tr>
        </table>
    </form>
</div>
<script>
    $(document).ready(function(){
//        $.validator.methods.compareDate = function(value, element, param) {
//            //var startDate = jQuery(param).val() + ":00";补全yyyy-MM-dd HH:mm:ss格式
//            //value = value + ":00";
//            
//            var startDate = $(param).val();
//            
//            var date1 = new Date(Date.parse(startDate.replace("-", "/")));
//            var date2 = new Date(Date.parse(value.replace("-", "/")));
//            console.log(Date.parse(startDate.replace("-", "/")), Date.parse(value.replace("-", "/")));
//            return date1 < date2;
//        };
        $("#btime").live('change',function(){
            var btime=$(this).val();
            var etime=$("#etime").val();
          $.ajax({
                type:'GET',
                url:'?m=simplifytask&a=checktime&btime='+btime+'&etime='+etime,
                dataType:'html',
                success:function(msg){
                    $("#edtime").empty();
                    $("#edtime").html(msg);
                }
            })
        })
      
        $("form#task_add").validate({
		rules: {
			task_name: "required", 
                        man_day: {
                            required: true,
                            number: true,
                            max:8
                        },
						true_man_day: {
                            required: true,
                            number: true,
                            max:8
                        },
                        project_id: "required",
                        begin_time: "required",
                        end_time:  "required",
                        task_status: "required",
                        task_type: "required",
                        btime:"required",
                        etime:"required"
		},
		messages: {
			task_name: "请输入任务名称",
                        man_day: {
                            required: '请输入执行工时',
                            number: '工时必须为数字',
                            max: $.validator.format("工时不能大于 8 小时")
                        },
						true_man_day: {
                            required: '请输入实际工时',
                            number: '工时必须为数字',
                            max: $.validator.format("工时不能大于 8 小时")
                        },
                        project_id: '请选择项目名称',
                        begin_time: '请输入开始时间',
                        end_time: '请输入开始时间',
                        task_status: "请选择任务状态",
                        task_type: "请选择任务类型",
                        btime:"请选择任务开始时间",
                        etime:"请选择任务结束时间"
		},
                errorPlacement: function(error, element) {
                    if ( element.is(":radio") )
                        error.appendTo( $("span.project_error") );
                    else if ( element.is(":checkbox") )
                        error.appendTo ( element.next() );
                    else 
                        error.appendTo( element.next() );
                },
                invalidHandler: function(form, validator) {
                    window.setTimeout('$.fn.colorbox.resize()',10);
                    return false;
                },
                submitHandler: function(form) {
//                    $('#cboxLoadedContent').html('<img src="./Public/images/colorbox/loading.gif" /> 处理中，请等待...');
                    var options = {
                        dataType: 'json',
                        type:'POST',
                        success: function(data) {
//                            console.log(data);
                            $.colorbox({ 
                                title: '添加任务', 
                                width: "20%",
                                height: "20%",
                                html: '<div class="color_msg">'+ data.info + '</div>',
                                onClosed:function(){
                                    window.location.reload();
                                }
                            });
                        }
                    };
                    $(form).ajaxSubmit(options);
                    return false; 
                }
	});
    });
    
//    function in_time(){
//        var operator = $('#operator').val();
//        if(operator == 'jason.guo'){
//            var begin_time = $("#begin_time").val();
//            var man_day = $("#man_day").val();
//            if(begin_time != '' && man_day != ''){
//                var str = begin_time;
//                var new_str = str.replace(/:/g,'-');
//                new_str = new_str.replace(/ /g,'-');
//                var arr = new_str.split("-");
//                var datum = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
//                //document.write("<br><b>转换后的UNIX时间戳为</b>: "+(datum.getTime()/1000));
//                var aInterval = man_day.split(".");
//                aInterval[0] = parseInt(aInterval[0]);
//                if(aInterval.length == 2){
//                    aInterval[1] = parseInt(aInterval[1]);
//                    var iInterval = (60*aInterval[0] + aInterval[1]*6) * 60 * 1000;
//                }else{
//                    var iInterval = 60*aInterval[0] * 60 * 1000;
//                }
//                var datum = new Date(datum.getTime() + iInterval);
//                var end_time = datum.toLocaleString();
//                end_time = end_time.replace(/年/g,'-');
//                end_time = end_time.replace(/月/g,'-');
//                end_time = end_time.replace(/日/g,'');
//                $("#end_time").val(end_time);
//                var datum = new Date(datum.getTime() + (1 * 60 * 60 * 1000));
//                var espiration_time = datum.toLocaleString();
//                espiration_time = espiration_time.replace(/年/g,'-');
//                espiration_time = espiration_time.replace(/月/g,'-');
//                espiration_time = espiration_time.replace(/日/g,'');
//                $("#espiration_time").val(espiration_time);
//            }
//        }
//    }
</script>