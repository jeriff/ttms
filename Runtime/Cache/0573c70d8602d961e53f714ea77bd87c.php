<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- layout::layout:header_do::0 -->
        <title><?php echo (C("title_oms_version")); ?>--我的桌面</title>
        <link rel='stylesheet' type='text/css' href='Public/js/fullcalendar/demos/cupertino/theme.css' />
        <link rel='stylesheet' type='text/css' href='Public/js/fullcalendar/fullcalendar/fullcalendar.css' />
        <link rel='stylesheet' type='text/css' href='Public/js/fullcalendar/fullcalendar/fullcalendar.print.css' media='print' />
        <script type='text/javascript' src='Public/js/fullcalendar/jquery/jquery-ui-1.8.17.custom.min.js'></script>
        <script type='text/javascript' src='Public/js/fullcalendar/fullcalendar/fullcalendar.js'></script>
        <link href="Public/css/colorbox.css" rel="stylesheet" type="text/css" />
        <script src="Public/js/jquery.colorbox-min.js" ></script>
		
        <script type='text/javascript'>
            
            var username;
            $('#uesrname').live("change",function(){
                username=$(this).val();
                $('#calendar').fullCalendar('destroy');
                fullcalendar();
            });
            
            $(document).ready(function() {
                fullcalendar();
				
				$("a.colorbox").colorbox({
                overlayClose:false
            }
         );
            });
  
            function fullcalendar(){
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
               
                $('#calendar').fullCalendar({
                    firstDay:1,
                    defaultView: 'agendaWeek',
                    currentTimezone:'Asia/Shanghai',
                    monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],  
                    monthNamesShort: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],  
                    dayNames: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],  
                    dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],  
                    today: ['今天'],  
                    buttonText: {  
                        today: '今天',  
                        month: '月',  
                        week: '周',  
                        day: '日' 
                    },
                    theme: true,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    editable: false,
//                    slotMinutes:30,
//                    minTime:9,
//                    maxTime:24,
                    allDayDefault:false,
                    eventSources: [//增加多个源
                        {
                           
                            url: 'index.php?m=index&a=gettask&user_name='+username
                        }
                    ]
                    
                });
            }
        </script>
        <style type='text/css'>

            #calendar {
                padding: 10px;
                width: 71%;
                background-color: #fff;
                margin:10px auto;
            }

        </style>

    </head>
    <body>
        <!-- layout::layout:header::0 -->


        <div style="width:100%;">
            <div style="width:100px; margin: 0 auto;margin-top: 10px;"><?php echo ($listparent); ?></div>
        </div>
        <div id='calendar'></div>

        <!-- layout::layout:footer::0 -->
    </body>
</html>