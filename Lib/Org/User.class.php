<?php

//得到层级的用户列表
////<td>&nbsp;<input type="text" id="userid" name="userid[]" class="txtHiden" value="'.$val['userid'].'" style="width:50px;" readonly="readonly" /></td>
class SysUser {

    public function get($mark = '┗', $parentid = 0, $selectid = 0) {

        $array = array('userid,username,parentid,status,email,is_admin');

        $user_list = D('user')->field($array)->where('parentid=' . $parentid)->select();


        foreach ($user_list as $val) {
			$bgColor = (9 == $val['status']) ? 'style="text-decoration:line-through;color:#ff0000;"' : '';
            $html .= '<tr>
            <td align="center"><input type="checkbox" value="' . $val['userid'] . '" name="userid[]"></td>';

            $guanliyuan = ($val['is_admin'] == 1 ? '<img width="20" src="Public/Images/administrator.png" border="0" align="absmiddle" />' : '');

            $html.=' <td align="center">' . $guanliyuan . '</td>';
            $html .='<td>&nbsp;' . $mark .'<span '.$bgColor.'>'. $val['username'] . '</span></td>
            <td>&nbsp;' . $val['status'] . '</td>
            <td>&nbsp;' . $val['email'] . '</td>
            <td align="center">
            &nbsp;
            <a href="?m=purview&a=edit_user&userid=' . $val['userid'] . '" title="Edit"><img src="Public/Images/edit.png" border="0" align="absmiddle" /></a>
            &nbsp;
            </td>
            </tr>';


            $html .= $this->get('┊┈┈' . $mark, $val['userid'], $selectid);
        }


        return $html;
    }

    //得到层级的用户列表
    public function get_opt($mark = '┗', $parentid = 0, $selectid = 0) {

        $array = array('userid,username,parentid,status,email');

        $user_list = D('user')->field($array)->where('parentid=' . $parentid)->select();

        foreach ($user_list as $val) {
            $html .='<option value="' . $val['userid'] . '"' . $this->set_attr($selectid, $val['userid'], 'selected') . '>' . $mark . $val['username'] . '</option>';
            $html .= $this->get_opt('&nbsp;&nbsp;&nbsp;' . $mark, $val['userid'], $selectid);
        };

        return $html;
    }
    
     public function get_cid( $parentid ) {
         $array = array('username,userid,status');
        $username = D('user')->field($array)->where('parentid=' . $parentid .' and status != 9')->select();
        if(!empty($username)){
            foreach($username as $val){
                if(!empty($val['username'])){
                    $name_arr .= $val['username'].',';
                    $name_arr .= $this->get_cid($val['userid']);
                }
            }
        }
        return $name_arr;
    }
    
     public function get_task($mark = '┗', $id = 0, $selectid = 0) {
        $html = '<option value="' . $_COOKIE[C('COOKIE_PREFIX') .'username'] . '"' . $this->set_attr($selectid,$_COOKIE[C('COOKIE_PREFIX') .'username'], 'selected') . '>' . $mark . $_COOKIE[C('COOKIE_PREFIX') .'username'] . '</option>';
        $html .= $this->get_optname('┆-'.$mark, $id, $selectid);
        return $html;
    }
     
     public function get_optname($mark = '┗', $parentid = 0, $selectid = 0) {
        $array = array('userid,username,parentid,status,email');
        $user_list = D('user')->field($array)->where('parentid=' . $parentid .' and status != 9' )->select();        
        foreach ($user_list as $val) {
            $html .='<option value="' . $val['username'] . '"' . $this->set_attr($selectid, $val['username'], 'selected') . '>' . $mark . $val['username'] . '</option>';
            $html .= $this->get_optname('┆-'. $mark, $val['userid'], $selectid);
        };

        return $html;
    }

    //设置选中状态
    private function set_attr($v1, $v2, $attr) {

        return ($v1 == $v2) ? $attr : '';
    }

    //检查是否有权限
    public function check_privilege($right) {
        $username=$_COOKIE[C('COOKIE_PREFIX') . 'username'];
        if($username!='system'){
            $map['username'] = $username;
            $array = array('privileges');
            $privileges = D('user')->field($array)->where($map)->limit(1)->select();

            $privileges_arr = explode(",", $privileges[0][privileges]);

            if (in_array($right, $privileges_arr)) {
                return true;
            } else {               
                die("<script>alert('无权操作!');window.history.go(-1);</script>");

            }
        }
    }
    
    
    //取得某个id下的所有子id的name
    public function get_arrparentname($id,&$user_arr){
        $array = array('userid,username,parentid');
        $user_list = D('user')->field($array)->where('parentid=' . $id)->select();
        if(is_array($user_list)){
            foreach ($user_list as $key=>$val) {
                $user_arr[$val['username']] = $val['username'];
                $this->get_arrparentname($val['userid'],$user_arr);         
            }
        } 
        return $user_arr;
 }
 
    
    

   

}

?>