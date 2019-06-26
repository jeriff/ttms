<?php if (!defined('THINK_PATH')) exit();?><div id="top_box">
    <div id="top_box_up">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" height="37"><span class="ttms"><?php echo (C("title_oms_version")); ?></span></td>
                <td align="left" width="140"><span>欢迎您,<a target="" href="?m=user&a=rewrite" ><?php echo $_COOKIE[C('COOKIE_PREFIX').'username'];?> </a>
                        <a href="logout.php">[<?php echo (L("lab_logout")); ?>]</a></span></td>
            </tr>
        </table>
    </div>
    <div id="top_box_down">
        <ul class="top_menu">
            <?php 
            $menu = C('menu');
            foreach($menu as $key => $value){
                if($key == $menu_name){
                    echo '<li class="current"><a href="'.$value['link'].'" class="'.$key.'">'.$value['title'].'</a><span></span></li>';
                } else {
                    echo '<li><a href="'.$value['link'].'" class="'.$key.'">'.$value['title'].'</a><span></span></li>';
                }
            }
            ?>
        </ul>

    </div>
</div>