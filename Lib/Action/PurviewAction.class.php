<?php
require_once './Common/enumeration.class.php';
header("Content-type: text/html; charset=utf-8");
import("@.ORG.User");
class PurviewAction extends Action {


    public function index() {
       
        $user_list = D('purview')->getListUser($user);     
        
        $object = new SysUser();
        $datas = $object -> get($mark='┣',$parentid=0,$selectid=0);
        
        $this->assign("datas", $datas);
        $this->page = $user_list['show'];
        $this->list = $user_list['list'];
        

        $this->assign('menu_name','icon_8');
        $this->display();
        
        
    }
    
    
    public function add_user() {
        SysUser::check_privilege('user_add');

        if($_POST){
        
            $map['username']=trim($_POST['username']);
            $map['password']=trim($_POST['password']);
            $map['email']=trim($_POST['email']);
            $map['status']=trim($_POST['status']);
            $map['parentid'] = trim($_POST['parentid']);

            $map['created'] = date("Y-m-d H:i:s");
            $map['created_by'] =  $_COOKIE[C('COOKIE_PREFIX') . 'username'];
            $map['is_admin'] = trim($_POST['is_admin']);

            $pri_arr = implode(',',$_POST['privileges']);
            $map['privileges'] = $pri_arr;
            
            $return_add = D('purview')->addUserDetail($map);
            

            if($return_add){

                    echo "<script>alert('已经添加成功!');window.location='?m=purview&a=index'</script>";

                }else{
                    echo "<script>alert('无法添加用户! ');window.location='?m=purview&a=index'</script>";
                }
        }
        //用户结构
        $object = new SysUser();
        $listparent = $object -> get_opt($mark='┣',$parentid=0,$selectid=0);
        $listparent='<select name="parentid"><option>请选择</option>'.$listparent.'</select>';
       
                  
        //取得该用户的权限或添加或修改
        $html=$this->require_privilege();

  
  
        
        
        $this->assign('listparent',  $listparent);
        
        $this->assign('privilign', $html);
        $this->assign('menu_name','icon_8');
       
        $this->assign('a','add_user');
        
        $this->display();     
    }
    
    
    

    
    public function edit_user(){
        SysUser::check_privilege('user_edit');
        $userid=trim($_GET['userid']);
        $map['userid']= $userid;
        $select_user=D('user')->where($map)->select();

  
        //用户结构
        $object = new SysUser();
        $listparent = $object -> get_opt($mark='┣',$parentid=0,$selectid=$select_user[0]['parentid']);
   
        $listparent='<select name="parentid"><option>请选择</option>'.$listparent.'</select>';
        
        //取得该用户的权限或添加或修改
     
        $array = array('privileges');
	$privileges =D('user')->field($array)->where($map)->limit(1)->select();

        $privileges=explode(',',$privileges[0][privileges]);
    
        $html=$this->require_privilege($privileges);
       
        
        $this->assign('privilign', $html);
        
        $this->assign('listparent',  $listparent);
        $this->assign('select_user', $select_user[0]);
        $this->assign('a','update_user');
        $this->display('add_user');
        
    }
    
    function  require_privilege($privileges){
        $enum = new Enumeration();
  
        $permission = C('permission');
      
        
        for($i=0; $i<count($permission); $i++){
            
            $html .='<tr><td class="tdLeft">'.$permission[$i][module][value].'</td>';
            $html .= '<td class="tdLeft">';
 
            $chkbox = $this -> get_checkbox($permission[$i][module][key],$permission[$i][option],$privileges);
            $html .=$chkbox;
            
            
            $html .='</td>';
          
            $html .='</tr>';
           
            
        }
       
        return $html;
    }
    
    //生成checkbox
    private function get_checkbox($prefix,$array,$privileges)
    {
        
	@eval("\$array=$array;");
		
	foreach($array as $k => $v)
	{
//        	$ifchk = (strpos($privileges,$prefix.'_'.$k) !== false) ? 'checked' : '';
         

                if(in_array($prefix.'_'.$k, $privileges)){
                   $ifchk='checked';
                   
                }else{
                    $ifchk='';
                }

         
		$checkbox .= '<label><input class="privileges" type="checkbox" id="" name="privileges[]" '.$ifchk.' value="'.$prefix.'_'.$k.'" /> '.$v.'</label>&nbsp;';
	}
        return $checkbox;
}
    
    
//    public function require_selstructure(){
//        $user = M("user");
//        $where['status']='1';
//        $strun_infor_old=$user->where($where)->field("userid,parentid,username")->select();
//        
//        $strun_infor=array();
//        for($i=0; $i<count($strun_infor_old); $i++){
//            $strun_infor[$i]['id'] = $strun_infor_old[$i]['userid'];
//            $strun_infor[$i]['parentid'] = $strun_infor_old[$i]['parentid'];
//            $strun_infor[$i]['name'] = $strun_infor_old[$i]['username'];
//        }
//            
//        $str="<option value=\$id \$select>\$spacer\$name</option>";
//
//            
//        $tree = new Tree();
//        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
//        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';   
//
//
//        $tree->init($strun_infor);
//        $select_categorys = $tree->get_tree(0, $str);
//        return $select_categorys;
//    }
    
    public function update_user(){
        $user = M("user");
        $array['userid'] = trim($_REQUEST['userid']);
        $map=array();
        $map['username'] = trim($_REQUEST['username']);
        $map['password'] = trim($_REQUEST['password']);
        $map['email'] = trim($_REQUEST['email']);
        $map['status'] = trim($_REQUEST['status']);
        $map['parentid'] = trim($_REQUEST['parentid']);
        $map['modified'] = date("Y-m-d H:i:s");
        $map['modified_by'] =  $_COOKIE[C('COOKIE_PREFIX') . 'username'];
        $map['is_admin'] = trim($_POST['is_admin']);
        
        $pri_arr = implode(',',$_POST['privileges']);
        $map['privileges'] = $pri_arr;
        
  
        $resp = $user->where($array)->save($map);

       
        if($resp){
        
            echo "<script>alert('已经修改成功!');window.location='?m=purview&a=index'</script>";
           
        }else{
            echo "<script>alert('无法修改! ');window.location='?m=purview&a=index'</script>";
        }
        
    }
    
    public function delete_user(){
        $res = SysUser::check_privilege('user_add');

        $userid=$_POST['userid'];
      
        if($_POST){
            if(is_array($userid)){
                $where['userid'] = array('in', $userid);
            }else{

                $where['userid'] = trim($userid);
            }
 
            $user = D("user");
            $user_delete=$user->where($where)->delete();
            if($user_delete){

                echo "<script>alert('已删除成功!');window.location='?m=purview&a=index'</script>";

            }else{
                echo "<script>alert('无法删除! ');window.location='?m=purview&a=index'</script>";
            }
   

            
            
        }
             

    }
    
                
//    public function structure(){
//          
//            $user = M("user");
//            $where['status']='1';
//            $strun_infor_old=$user->where($where)->field("userid,parentid,username")->select();
//            
//           //处理成init可以接受的数组
//            $strun_infor=array();
//            for($i=0; $i<count($strun_infor_old); $i++){
//                $strun_infor[$i]['id'] = $strun_infor_old[$i]['userid'];
//                $strun_infor[$i]['parentid'] = $strun_infor_old[$i]['parentid'];
//                $strun_infor[$i]['name'] = $strun_infor_old[$i]['username'];
//            }
//            
//            $str="<option value=\$id \$select>\$spacer\$name</option>";

            //dump( $strun_infor);
//            
//    
//            $tree = new Tree();
//            $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
//            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';   
//      
//            $str = "<tr height='30'><td>\$spacer<span class='txt'>\$name</span><td></tr>";
//            $tree->init($strun_infor);
//            $select_categorys = $tree->get_tree(0, $str);
//            $table="<table>{$select_categorys}</table>";
//            
//            $this->assign("table", $table);
//            $this->assign('menu_name','icon_8');
//
//            $this->display();
//    }
    
    
}

?>