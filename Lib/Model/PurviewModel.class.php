<?php
class PurviewModel extends Model {


  
    public function addUserDetail($map) {

        $form = M("user");
        
        $add = $form->add($map);
        if ($add) {
            return $add;
        } else {
            return '0';
        }
    }
    
    public function getListUser(){
        $user = M('user');
        import("@.ORG.Page"); //导入分页类 
	$count = $user->where($map)->count();
	$page = new Page ($count, 20); 
	$show = $page->show();
		
	//$array = array('tid','pay_time','buyer_nick','payment','status','last_status','last_status_by','lock_by','createddate');  
	$array = array('userid','parentid','username','email','status','created');
	$list = $user->field($array)->where($map)->limit($page->firstRow.','.$page->listRows)->order('userid desc')->select();
        return array('list'=>$list,'show' =>$show);
    }
}
