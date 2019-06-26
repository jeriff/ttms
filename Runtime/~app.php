<?php  return array ( 'app_debug' => false, 'app_domain_deploy' => false, 'app_sub_domain_deploy' => false, 'app_plugin_on' => false, 'app_file_case' => false, 'app_group_depr' => '.', 'app_group_list' => '', 'app_autoload_reg' => false, 'app_autoload_path' => 'Think.Util.', 'app_config_list' => array ( 0 => 'taglibs', 1 => 'routes', 2 => 'tags', 3 => 'htmls', 4 => 'modules', 5 => 'actions', ), 'cookie_expire' => 3600, 'cookie_domain' => '', 'cookie_path' => '/', 'cookie_prefix' => 'ttms_', 'default_app' => '@', 'default_group' => 'Home', 'default_module' => 'Index', 'default_action' => 'index', 'default_charset' => 'utf-8', 'default_timezone' => 'PRC', 'default_ajax_return' => 'JSON', 'default_theme' => 'default', 'default_lang' => 'zh-cn', 'db_type' => 'Mysql', 'db_host' => 'localhost', 'db_name' => 'ttms', 'db_user' => 'root', 'db_pwd' => '', 'db_port' => 3306, 'db_prefix' => 'ttms_', 'db_suffix' => '', 'db_fieldtype_check' => false, 'db_fields_cache' => true, 'db_charset' => 'utf8', 'db_deploy_type' => 0, 'db_rw_separate' => false, 'data_cache_time' => -1, 'data_cache_compress' => false, 'data_cache_check' => false, 'data_cache_type' => 'File', 'data_cache_path' => './Runtime/Temp/', 'data_cache_subdir' => false, 'data_path_level' => 1, 'error_message' => '您浏览的页面暂时发生了错误！请稍后再试～', 'error_page' => '', 'html_cache_on' => false, 'html_cache_time' => 60, 'html_read_type' => 0, 'html_file_suffix' => '.shtml', 'lang_switch_on' => true, 'lang_auto_detect' => true, 'log_exception_record' => true, 'log_record' => false, 'log_file_size' => 2097152, 'log_record_level' => array ( 0 => 'EMERG', 1 => 'ALERT', 2 => 'CRIT', 3 => 'ERR', ), 'page_rollpage' => 5, 'page_listrows' => 20, 'session_auto_start' => true, 'show_run_time' => false, 'show_adv_time' => false, 'show_db_times' => false, 'show_cache_times' => false, 'show_use_mem' => false, 'show_page_trace' => false, 'show_error_msg' => true, 'tmpl_engine_type' => 'Think', 'tmpl_detect_theme' => false, 'tmpl_template_suffix' => '.html', 'tmpl_content_type' => 'text/html', 'tmpl_cachfile_suffix' => '.php', 'tmpl_deny_func_list' => 'echo,exit', 'tmpl_parse_string' => '', 'tmpl_l_delim' => '{', 'tmpl_r_delim' => '}', 'tmpl_var_identify' => 'array', 'tmpl_strip_space' => false, 'tmpl_cache_on' => true, 'tmpl_cache_time' => -1, 'tmpl_action_error' => 'Public:success', 'tmpl_action_success' => 'Public:success', 'tmpl_trace_file' => './../ThinkPHP2.1/Tpl/PageTrace.tpl.php', 'tmpl_exception_file' => './../ThinkPHP2.1/Tpl/ThinkException.tpl.php', 'tmpl_file_depr' => '/', 'taglib_begin' => '{', 'taglib_end' => '}', 'taglib_load' => true, 'taglib_build_in' => 'cx', 'taglib_pre_load' => '', 'tag_nested_level' => 3, 'tag_extend_parse' => '', 'token_on' => true, 'token_name' => '__hash__', 'token_type' => 'md5', 'url_case_insensitive' => false, 'url_router_on' => false, 'url_route_rules' => array ( ), 'url_model' => 1, 'url_pathinfo_model' => 2, 'url_pathinfo_depr' => '/', 'url_html_suffix' => '', 'var_group' => 'g', 'var_module' => 'm', 'var_action' => 'a', 'var_router' => 'r', 'var_page' => 'p', 'var_template' => 't', 'var_language' => 'l', 'var_ajax_submit' => 'ajax', 'var_pathinfo' => 's', 'default_language' => 'zh-cn', 'administrator' => 'superman', 'title_all_rights' => '©Copyrights www.transcosmos-cn.com All rights reserved.', 'title_oms_version' => '时间&任务管理系统 TTMS', 'menu' => array ( 'icon_1' => array ( 'title' => '我的日历', 'link' => '?m=index&a=index', ), 'icon_2' => array ( 'title' => '我的任务', 'link' => '?m=simplifyTask&a=index', ), 'icon_11' => array ( 'title' => '项目日志', 'link' => '?m=question&a=index', ), 'icon_6' => array ( 'title' => '项目管理', 'link' => '?m=project&a=index', ), 'icon_5' => array ( 'title' => '服务器', 'link' => '?m=server&a=index', ), 'icon_8' => array ( 'title' => '用户管理', 'link' => '?m=purview&a=index', ), 'icon_7' => array ( 'title' => '报表', 'link' => '?m=report&a=user_task', ), 'icon_10' => array ( 'title' => '文档管理', 'link' => '?m=document&a=index', ), 'icon_9' => array ( 'title' => '系统设置', 'link' => '?m=system&a=index', ), ), 'task' => array ( 'task_priority' => array ( 1 => '日常任务', 2 => '一般任务', 3 => '紧急任务', 4 => '重要任务', 5 => '紧急重要任务', ), 'task_attribute' => array ( 1 => '一般任务', 2 => '周期任务', ), 'task_biling' => array ( 1 => '计费', 2 => '不计费', ), 'task_biling_type' => array ( 1 => 'SDU内部', 2 => '公司内部', 3 => '公司对外', ), 'task_biling_money' => array ( 'A' => 'A(向客户收费)', 'B' => 'B(部门内部收费)', 'C' => 'C(未确认的收费)', 'D' => 'D', ), 'task_type' => array ( 1 => '日常', 2 => '开发', 3 => 'BUG修复', 4 => '调研', 5 => '文档整理', 6 => '系统维护', 7 => '会议(in office)', 8 => '会议(out office)', 9 => '休假', 10 => '工作Review', 11 => '出差', ), 'task_status' => array ( 1 => '未开始', 2 => '执行中', 3 => '已暂停', 4 => '已完成', 5 => '到期未完成', 99 => '已过期', 100 => '已废除', 6 => '其他', ), 'task_category' => array ( '日常工作' => '日常工作', 'OA系统维护开发' => 'OA系统维护开发', 'CRM/OMS新系统开发' => 'CRM/OMS新系统开发', 'CRM/OMS系统维护' => 'CRM/OMS系统维护', '新业务开发维护' => '新业务开发维护', '项目系统配置' => '项目系统配置', '技术学习/调查' => '技术学习/调查', '会议' => '会议', 'Support(部门内)' => 'Support(部门内)', 'Support(部门间)' => 'Support(部门间)', '部门管理' => '部门管理', '请假' => '请假', '空闲' => '空闲', '其他' => '其他', ), ), 'permission' => array ( 0 => array ( 'module' => array ( 'key' => 'task', 'value' => '我的任务', ), 'option' => array ( 'manage' => '管理', 'add' => '添加', 'edit' => '修改', 'del' => '删除', 'detail' => '详细', ), ), 1 => array ( 'module' => array ( 'key' => 'project', 'value' => '项目管理', ), 'option' => array ( 'manage' => '管理', 'add' => '添加', 'edit' => '修改', 'del' => '删除', 'detail' => '详细', ), ), 2 => array ( 'module' => array ( 'key' => 'server', 'value' => '服务器管理', ), 'option' => array ( 'manage' => '管理', 'add' => '添加', 'edit' => '修改', 'del' => '删除', 'detail' => '详细', ), ), 3 => array ( 'module' => array ( 'key' => 'user', 'value' => '用户管理', ), 'option' => array ( 'manage' => '管理', 'add' => '添加', 'edit' => '修改', 'del' => '删除', ), ), 4 => array ( 'module' => array ( 'key' => 'index', 'value' => '报表', ), 'option' => array ( 'manage' => '管理', 'detail' => '详细', ), ), 5 => array ( 'module' => array ( 'key' => 'system', 'value' => '系统设置', ), 'option' => array ( 'manage' => '管理', 'edit' => '修改', ), ), 6 => array ( 'module' => array ( 'key' => 'document', 'value' => '文档管理', ), 'option' => array ( 'manage' => '管理', 'edit' => '修改', 'delete' => '删除', 'add' => '添加', ), ), ), 'server' => array ( 'server_type' => array ( 1 => 'web', 2 => 'db', 3 => 'report', 4 => 'backup', 5 => 'ftp', 6 => '其他', ), 'server_site' => array ( 'shwx' => '文新', 'shxhg' => '新慧谷', 'bg' => '北京', 'wx' => '无锡', 'idc' => 'IDC', 'other' => '其他', ), 'server_status' => array ( 1 => '运行服务', 2 => '暂停服务', 3 => '停止服务', ), ), 'project' => array ( 'project_status' => array ( 6 => '已立项', 1 => '已上线', 2 => '开发中', 3 => '升级', 4 => '已下线', 5 => '调研中', ), 'project_type' => array ( 'EC' => 'EC', 'CC' => 'CC', 'OTHER' => '其他', ), 'project_business_type' => array ( 'IB' => '呼入', 'OB' => '呼出', 'EMAIL' => '邮件支持', 'OMS' => '订单处理', 'WW' => '旺旺客服', 'PP' => '拍拍客服', ), ), 'document' => array ( 'document_type' => array ( 'SDU文档' => 'SDU文档', '需求文档' => '需求文档', '开发文档' => '开发文档', '测试文档' => '测试文档', '升级文档' => '升级文档', '相关模板' => '相关模板', '操作手册' => '操作手册', ), 'document_secret' => array ( 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', ), 'document_whole' => array ( 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', ), 'document_use' => array ( 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', ), ), 'ec_question' => array ( 'log_type' => array ( 1 => '一般事件', 2 => '需求', 3 => '系统调整', 4 => '事故', ), 'question_type' => array ( 1 => '出货指示错误', 2 => '库存跟新问题', 3 => '报表问题', 4 => '系统缓慢/瘫痪/宕机', 5 => '系统调整', 6 => 'taobao', ), 'report_party' => array ( 1 => 'SDU内部', 2 => '运营', 3 => '公司内部', 4 => '客户方', ), 'blame' => array ( 1 => '系统及服务器环境问题', 2 => '硬件及网络问题', 3 => '运营操作问题', 4 => 'EC平台问题', 5 => '仓库问题', 6 => '用户体验', 9 => '其它', 10 => 'bug及开发需求遗漏', ), ), ); ?>