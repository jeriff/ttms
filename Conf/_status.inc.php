<?php

return array(
    'menu' => array(
        'icon_1' => array('title' => '我的日历', 'link' => '?m=index&a=index'),
        'icon_2' => array('title' => '我的任务', 'link' => '?m=simplifyTask&a=index'),
        'icon_11' =>array('title' => '项目日志', 'link' => '?m=question&a=index'),
        'icon_6' => array('title' => '项目管理', 'link' => '?m=project&a=index'),
        'icon_5' => array('title' => '服务器', 'link' => '?m=server&a=index'),
        'icon_8' => array('title' => '用户管理', 'link' => '?m=purview&a=index'),
        'icon_7' => array('title' => '报表', 'link' => '?m=report&a=user_task'),
        'icon_10' => array('title' => '文档管理', 'link' => '?m=document&a=index'),
        'icon_9' => array('title' => '系统设置', 'link' => '?m=system&a=index'),
        
    ),
    'task' => array(
        'task_priority' => array(
            '1' => '日常任务',
            '2' => '一般任务',
            '3' => '紧急任务',
            '4' => '重要任务',
            '5' => '紧急重要任务'
        ),
        'task_attribute' => array(
            '1' => '一般任务',
            '2' => '周期任务'
        ),
        'task_biling' => array(
            '1' => '计费',
            '2' => '不计费'
        ),
        'task_biling_type' => array(
            '1' => 'SDU内部',
            '2' => '公司内部',
            '3' => '公司对外'
        ),
        'task_biling_money' => array(
            'A' => 'A(向客户收费)',
            'B' => 'B(部门内部收费)',
            'C' => 'C(未确认的收费)',
            'D' => 'D'
        ),
        'task_type' => array(
            '1' => '日常',
            '2' => '开发',
            '3' => 'BUG修复',
            '4' => '调研',
            '5' => '文档整理',
            '6' => '系统维护',
            '7' => '会议(in office)',
            '8' => '会议(out office)',
            '9' => '休假',
           '10' => '工作Review',
          '11' => '出差'
        ),
        'task_status' => array(
            '1' => '未开始',
            '2' => '执行中',
            '3' => '已暂停',
            '4' => '已完成',
            '5' => '到期未完成',
            '99' => '已过期',
            '100' => '已废除'
        ),
		'task_category' => array(
			'日常工作' => '日常工作',
			'OA系统维护开发' => 'OA系统维护开发',
			'CRM/OMS新系统开发' => 'CRM/OMS新系统开发',
			'CRM/OMS系统维护' => 'CRM/OMS系统维护',
			'新业务开发维护' => '新业务开发维护',
			'项目系统配置' => '项目系统配置',
			'技术学习/调查' => '技术学习/调查',
			'会议' => '会议',
			'Support(部门内)' => 'Support(部门内)',
			'Support(部门间)' => 'Support(部门间)',
			'部门管理' => '部门管理',
			'请假' => '请假',
			'空闲' => '空闲',
			'其他' => '其他'
		)
    ),
    'permission' => array(
         '0'=>array(
            'module' => array('key'=>'task','value'=>'我的任务'),
            'option' =>array(
                'manage' => '管理',
                'add' => '添加',
                'edit' => '修改',
                'del' => '删除',
                'detail' => '详细'
            ),
         ),  
        '1'=>array(
            'module' => array('key'=>'project','value'=>'项目管理'),
            'option' =>array(
                'manage' => '管理',
                'add' => '添加',
                'edit' => '修改',
                'del' => '删除',
                'detail' => '详细'
            ),
        ),
       '2'=>array(
            'module' => array('key'=>'server','value'=>'服务器管理'),
            'option' =>array(
                'manage' => '管理',
                'add' => '添加',
                'edit' => '修改',
                'del' => '删除',
                'detail' => '详细'
            )
        ),
        '3'=>array(
            'module' => array('key'=>'user','value'=>'用户管理'),
            'option' =>array(
                'manage' => '管理',
                'add' => '添加',
                'edit' => '修改',
                'del' => '删除',
            )
         ) ,
        '4'=>array(
            'module' => array('key'=>'index','value'=>'报表'),
            'option' =>array(
                'manage' => '管理',
                'detail' => '详细'
            ),
         ),
         '5'=>array(
            'module' => array('key'=>'system','value'=>'系统设置'),
            'option' =>array(
                'manage' => '管理',
                'edit' => '修改'
            ),
         ),
		 '6'=>array(
			'module' => array('key'=>'document','value'=>'文档管理'),
            'option' =>array(
                'manage' => '管理',
                'edit' => '修改',
                'delete' => '删除',
               'add' => '添加',
            ),
		 )

    
    ),
    'server' => array(
        'server_type' => array(
            '1' => 'web server',
            '2' => 'db server',
            '3' => 'report server',
            '4' => 'backup server',
            '5'=>'ftp server'
        ),
        'server_site' => array(
            'shwx' => '文新',
            'shxhg' => '新慧谷',
            'bg' => '北京',
            'wx' => '无锡',
            'idc' => 'IDC',
            '其他'=>'其他',
        ),
        'server_status'=>array(
            '1'=>'运行服务',
            '2'=>'暂停服务',
            '3'=>'停止服务',
        )
    ),
    'project' => array(
        'project_status' => array(
            '6' => '已立项',
            '1' => '已上线',
            '2' => '开发中',
            '3' => '升级',
            '4' => '已下线',
            '5' => '调研中'
        ),
		'project_type' => array(
			'EC' => 'EC',
			'CC' => 'CC',
			'OTHER' => '其他',
		),
		'project_business_type' => array(
			'IB' => '呼入',
			'OB' => '呼出',
			'EMAIL' => '邮件支持',
			'OMS' => '订单处理',
			'WW' => '旺旺客服',
			'PP' => '拍拍客服',
                       'other'=>'其他',
		)
    ),
	'document' => array(
		'document_type' => array(
                                                                 'SDU文档' => 'SDU文档',
			 '需求文档' => '需求文档',
			'开发文档' => '开发文档',
			'测试文档' => '测试文档',
			'升级文档' => '升级文档',
			'相关模板' => '相关模板',
			'操作手册' => '操作手册',
		),
		'document_secret' => array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		),
		'document_whole' => array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		),
		'document_use' => array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		)
	),
    'ec_question'=>array(
        'log_type'=>array(
            '1'=>'一般事件',
            '2'=>'需求',
            '3'=>'系统调整',
            '4'=>'事故',
        ),
        'question_type'=>array(
            '1'=>'出货指示错误',
            '2'=>'库存跟新问题',
            '3'=>'报表问题',
            '4'=>'系统瘫痪',
            '5'=>'系统调整',
            '6'=>'taobao api 漏单',
            '7'=>'订单/物流信息更新问题',
        ),
        'report_party'=>array(
            '1'=>'SDU内部',
            '2'=>'运营',
            '3'=>'公司内部',
            '4'=>'客户方',
        ),
        'blame'=>array(
            '1'=>'系统及服务器环境问题',
            '2'=>'硬件及网络问题',
            '3'=>'运营操作问题',
            '4'=>'EC平台问题',
            '5'=>'仓库问题',
            '6'=>'用户体验',
            '9'=>'其它',
            '10'=>'bug及开发需求遗漏',
        ),
        
    ),
    
);
?>
