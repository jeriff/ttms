<?php
/*
    Copyright (C), 2008-2010, AnHui YinHang Technology Co., Ltd.
    File name: Tree.php
    Author: phpcms Version: 0.1.0.0  Date: 2011-08-17 17:22 GMT+8
    Description: 通用的无限级分类，可生成任何类型数据

    Modified: gao  Date: 2011-08-19 11:25 GMT-8
    Description: 去除2维数组的KEY为ID的显示
*/
/*
DEMO:
1.生成下拉列表无限分类

vendor('PHPUnit.Tree');
$tree = new tree();
$tree->init($class_category);
$treestr = $tree->get_tree(0, "<option value=\$id \$select>\$spacer\$name</option>");

2.生成页面类型分类

$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
 $str = "
    <tr>
    <td align=center>\$id</td>
    <td align=left>\$spacer\$name</td>
    <td align=center>\$types</td>
    <td align=center>\$channelid</td>
    <td align=center>\$modelid</td>
    <td align=center>
        <a href='/Content/ClassSet/edit/pid/\$id'   class='blue'>添加子栏目</a> |
        <a href='/Content/ClassSet/edit/id/\$id/pid/\$parentid'   class='blue'>修改</a> |
        <a href='/Content/ClassSet/delete/id/\$id' onclick='checkDo(this.href); return false;' class='blue'>删除</a>
    </td>
    </tr>
";

$treestr = $tree->get_tree(0, $str);

3.
*/

class Tree {
	/**
	* 生成树型结构所需要的2维数组
	* @var array
	*/
	public $arr = array();

	/**
	* 生成树型结构所需修饰符号，可以换成图片
	* @var array
	*/
	public $icon = array('│','├','└');
	public $nbsp = "&nbsp;";

	/**
	* @access private
	*/
	public $ret = '';

	/**
	* 构造函数，初始化类
	* @param array 2维数组，例如：,数组键不受约束
	* array(
	*      1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
	*      2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
	*      3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
	*      4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'),
	*      5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'),
	*      6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'),
	*      7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目二')
	*      )
	*/
	public function init($arr=array()){
		$arr_new = array();
		foreach ($arr as $k=>$v) $arr_new[$v['id']] = $v;
      	$this->arr = $arr_new;
	    $this->ret = '';
	   	return is_array($arr_new);
	}

    /**
	* 得到父级数组
	* @param int
	* @return array
	*/
	public function get_parent($myid){
		$newarr = array();
		if(!isset($this->arr[$myid])) return false;
		$pid = $this->arr[$myid]['parentid'];
		$pid = $this->arr[$pid]['parentid'];
		if(is_array($this->arr)){
			foreach($this->arr as $id => $a){
				if($a['parentid'] == $pid) $newarr[$id] = $a;
			}
		}
		return $newarr;
	}

    /**
	* 得到子级数组
	* @param int
	* @return array
	*/
	public function get_child($myid){
		$a = $newarr = array();
		if(is_array($this->arr)){
			foreach($this->arr as $id => $a){
				if($a['parentid'] == $myid) $newarr[$id] = $a;
			}
		}
		return $newarr ? $newarr : false;
	}

    /**
	* 得到当前位置数组
	* @param int
	* @return array
	*/
	public function get_pos($myid,&$newarr){
		$a = array();
		if(!isset($this->arr[$myid])) return false;
        $newarr[] = $this->arr[$myid];
		$pid = $this->arr[$myid]['parentid'];
		if(isset($this->arr[$pid])){
		    $this->get_pos($pid,$newarr);
		}
		if(is_array($newarr)){
			krsort($newarr);
			foreach($newarr as $v){
				$a[$v['id']] = $v;
			}
		}
		return $a;
	}

    /**
	* 得到树型结构
	* @param int myid，表示获得这个ID下的所有子级
	* @param string str生成树型结构的基本代码，例如："<option value=\$id \$select>\$spacer\$name</option>"
	* @param int sid 被选中的ID，比如在做树型下拉框的时候需要用到
	* @return string
	*/
	public function get_tree($myid, $str, $sid = 0, $adds = '', $str_group = ''){
		$number=1;
		$child = $this->get_child($myid);
		if(is_array($child)){
		    $total = count($child);
			foreach($child as $key => $value){
				$j=$k='';
				if($number==$total){
					$j .= $this->icon[2];
				}else{
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';
				$select = $value['id']==$sid ? 'selected' : '';
				@extract($value);
				$parentid == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
				$this->ret .= $nstr;
				$nbsp = $this->nbsp;
				$this->get_tree($value['id'], $str, $sid, $adds.$k.$nbsp,$str_group);
				$number++;
			}
		}
		return $this->ret;
	}

    /**
	* 同上一方法类似,但允许多选
	*/
	public function get_tree_multi($myid, $str, $sid = 0, $adds = ''){
		$number=1;
		$child = $this->get_child($myid);
		if(is_array($child)){
		    $total = count($child);
			foreach($child as $key => $value){
				$j=$k='';
				if($number==$total){
					$j .= $this->icon[2];
				}else{
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';

				$select = $this->have($sid,$value['id']) ? 'selected' : '';
				@extract($a);
				eval("\$nstr = \"$str\";");
				$this->ret .= $nstr;
				$this->get_tree_multi($value['id'], $str, $sid, $adds.$k.'&nbsp;');
				$number++;
			}
		}
		return $this->ret;
	}

	 /**
	* @param integer $myid 要查询的ID
	* @param string $str   第一种HTML代码方式
	* @param string $str2  第二种HTML代码方式
	* @param integer $sid  默认选中
	* @param integer $adds 前缀
	*/
	public function get_tree_category($myid, $str, $str2, $sid = 0, $adds = ''){
		$number=1;
		$child = $this->get_child($myid);
		if(is_array($child)){
		    $total = count($child);
			foreach($child as $key => $value){
				$j=$k='';
				if($number==$total){
					$j .= $this->icon[2];
				}else{
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';

				$select = $this->have($sid,$value['id']) ? 'selected' : '';
				@extract($a);
				if (empty($html_disabled)) {
					eval("\$nstr = \"$str\";");
				} else {
					eval("\$nstr = \"$str2\";");
				}
				$this->ret .= $nstr;
				$this->get_tree_category($value['id'], $str, $str2, $sid, $adds.$k.'&nbsp;');
				$number++;
			}
		}
		return $this->ret;
	}
	
	/**
	 * DWZ无限级导航生成
	 * @param $myid 表示获得这个ID下的所有子级
	 * @param $str 末级样式
	 * @param $str2 目录级别样式
	 * @param $style 目录样式 默认 filetree 可增加其他样式如'tree treeFolder'
	 * @param $recursion 递归使用 外部调用时为FALSE
	 * @author run.gao2012@gmail.com 2012-04-26
	 */
	function get_menu($myid, $str = "\r\t\t\t<a href='\$url' \$target \$external \$navid>\$name</a>", $str2 = "\r\t\t\t<a href='\$url' \$target \$external \$navid>\$name</a>", $style='tree treeFolder collapse', $recursion=false) {
        
		$child = $this->get_child($myid);
        if(!$recursion) $this->str .="\r\t\t<ul class='$style'>";
        foreach($child as $id=>$a) {
        	@extract($a);
            $this->str .= $recursion ? "\r\t\t<ul>\r\t\t<li>" : "\r\t\t<li>";
            $recursion = false;
            if($this->get_child($id)){
            	eval("\$nstr = \"$str2\";");
            	$this->str .= $nstr;
                $this->get_menu($id, $str, $str2, $style, true);
            } else {
                eval("\$nstr = \"$str\";");
                $this->str .= $nstr;
            }
            $this->str .=$recursion ? "\r</li>\r</ul>": "\r\t\t</li>";
        }
        if(!$recursion)  $this->str .="\r\t\t</ul>";
        return $this->str;
    }
    
	/**
	 * 同上一类方法，jquery treeview 风格，可伸缩样式（需要treeview插件支持）
	 * @param $myid 表示获得这个ID下的所有子级
	 * @param $effected_id 需要生成treeview目录数的id
	 * @param $str 末级样式
	 * @param $str2 目录级别样式
	 * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制
	 * @param $style 目录样式 默认 filetree 可增加其他样式如'filetree treeview-famfamfam'
	 * @param $currentlevel 计算当前层级，递归使用 适用改函数时不需要用该参数
	 * @param $recursion 递归使用 外部调用时为FALSE
	 */
    function get_treeview($myid,$effected_id='example',$str="<span class='file'>\$name</span>", $str2="<span class='folder'>\$name</span>" ,$showlevel = 0 ,$style='filetree ' , $currentlevel = 1,$recursion=FALSE) {
        $child = $this->get_child($myid);
        if(!defined('EFFECTED_INIT')){
           $effected = ' id="'.$effected_id.'"';
           define('EFFECTED_INIT', 1);
        } else {
           $effected = '';
        }
		$placeholder = 	'<ul><li><span class="placeholder"></span></li></ul>';
        if(!$recursion) $this->str .='<ul'.$effected.'  class="'.$style.'">';
        foreach($child as $id=>$a) {

        	@extract($a);
			if($showlevel > 0 && $showlevel == $currentlevel && $this->get_child($id)) $folder = 'hasChildren'; //如设置显示层级模式@2011.07.01
        	$floder_status = isset($folder) ? ' class="'.$folder.'"' : '';
            $this->str .= $recursion ? '<ul><li'.$floder_status.' id=\''.$id.'\'>' : '<li'.$floder_status.' id=\''.$id.'\'>';
            $recursion = FALSE;
            if($this->get_child($id)){
            	eval("\$nstr = \"$str2\";");
            	$this->str .= $nstr;
                if($showlevel == 0 || ($showlevel > 0 && $showlevel > $currentlevel)) {
					$this->get_treeview($id, $effected_id, $str, $str2, $showlevel, $style, $currentlevel+1, TRUE);
				} elseif($showlevel > 0 && $showlevel == $currentlevel) {
					$this->str .= $placeholder;
				}
            } else {
                eval("\$nstr = \"$str\";");
                $this->str .= $nstr;
            }
            $this->str .=$recursion ? '</li></ul>': '</li>';
        }
        if(!$recursion)  $this->str .='</ul>';
        return $this->str;
    }

	/**
	 * 获取子栏目json
	 * Enter description here ...
	 * @param unknown_type $myid
	 */
	public function creat_sub_json($myid, $str='') {
		$sub_cats = $this->get_child($myid);
		$n = 0;
		if(is_array($sub_cats)) foreach($sub_cats as $c) {
			$data[$n]['id'] = iconv(CHARSET,'utf-8',$c['catid']);
			if($this->get_child($c['catid'])) {
				$data[$n]['liclass'] = 'hasChildren';
				$data[$n]['children'] = array(array('text'=>'&nbsp;','classes'=>'placeholder'));
				$data[$n]['classes'] = 'folder';
				$data[$n]['text'] = iconv(CHARSET,'utf-8',$c['catname']);
			} else {
				if($str) {
					@extract(array_iconv($c,CHARSET,'utf-8'));
					eval("\$data[$n]['text'] = \"$str\";");
				} else {
					$data[$n]['text'] = iconv(CHARSET,'utf-8',$c['catname']);
				}
			}
			$n++;
		}
		return json_encode($data);
	}
	private function have($list,$item){
		return(strpos(',,'.$list.',',','.$item.','));
	}
			
	/**
	 * 获取节点所有子节点ID号
	 * @param $catid 节点ID号
	 * @param $init 第一次加载将情况static变量
	 * */
	public function get_arrchildid($myid, $init = true) {
		static $childid;
		if($init) $childid = '';
		if(!is_array($this->arr)) return false;
		foreach($this->arr as $id => $a){
			if($a['parentid'] == $myid) {
				$childid = $childid ? $childid.','.$a['id'] : $a['id'];
				$this->get_arrchildid($a['id'], false);
			}
		}
		return $childid ;
	}
	
	/**
	 * 获取该节点所有父节点ID号
	 * @param $id 节点ID号
	 * */
	public function get_arrparentid($id, $arrparentid = '') {
		if(!is_array($this->arr)) return false;
		$parentid = $this->arr[$id]['parentid'];
		if($parentid > 0) $arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
		if($parentid) $arrparentid = $this->get_arrparentid($parentid, $arrparentid);
		return $arrparentid;
	}
	
}
?>