<?php
/*数据字典*/
require_once ('form.class.php');
//if(g_enumeration_data_source){require_once ('../Common/dictionary.lib.php');}//调用生成好的类库
/*
 * 该类获取数据字典里的值，也可以传入sql语句，也可以传入数组
 * 程序会自动判断，从数据字典表里获取值；或者数据字典生成的静态数组里获取值
 */
class Enumeration extends Form
{
	private $type;//取值类型
	private $dbc;
	private $sql;
	private $table = 'dictionary';
	
	function __construct()
	{
		global $dbc;
		$this -> dbc = &$dbc;
		$this -> type = g_enumeration_data_source;//0从数据库取值,1从文件取值
	}
	

	//构造函数
	function Dictionary()
	{
		$this -> __construct();
	}
	
	//如果type=0,从数据库获取数据
	private function get_val($obj,$gettype=0)
	{
		switch ($gettype)
		{
			default:
			case 0 :	//默认从数据字典表或者数据字典数组获取 $obj = dicionaryname
			
					if(!$obj)return false;
					if($this -> type == 0)
					{
						$this -> sql = "SELECT * FROM ".g_tbl_prefix.$this -> table." WHERE 1=1 AND dictionaryname = '".$obj."' AND active =1 LIMIT 1 ";
						$r = $this -> dbc -> get_one($this -> sql);
						$v = $r['dictionaryvalue'];
						@eval("\$v=$v;");
						return $v;
					}
					else
					{
						global $g_dictionary;
						return $g_dictionary[$obj];
						
					}			
			
				break;
			case 1 :	//传入一条sql语句，从数据库获取 $obj = array('sql'=>'','k'=>'','v'=>''|array('v1','v2','v3'))
					$this -> sql = $obj['sql'];

					$q = $this -> dbc -> query($this -> sql);
					$arr = array();
					while($r = $this -> dbc -> fetch_array($q))
					{
						$v_tmp = array();
						
						if(is_array($obj['v']))
						{
							
							foreach($obj['v'] as $k => $v)
							{
								array_push($v_tmp,$r[$v]); 
							}
							
						}
						else
						{
							array_push($v_tmp,$r[$obj['v']]); 
						}
						
						$arr[$r[$obj['k']]] = implode(' ',$v_tmp);
						
					};
					
					return $arr;
				
				break;
			case 2 :	//传入默认数组 $obj = array('k'=>'v')
					return $obj;
				break;
		}
		

	}
	

	
	//单选按钮组
	public function get_radio($obj, $name, $id = '', $value = '', $cols = 5, $class = '', $ext = '', $width = 100,$gettype=0)
	{		
		return parent::radio($this -> get_val($obj,$gettype), $name, $id, $value, $cols, $class, $ext, $width);
	}
	
	
	//下拉框
	public function get_select($obj, $name, $id = '', $value = '', $size = 1, $class = '', $ext = '',$gettype=0)
	{
		return parent::select($this -> get_val($obj,$gettype), $name, $id, $value, $size, $class, $ext);
	}
	
	
	//复选框
	public function get_checkbox($obj, $name, $id = '', $value = '', $cols = 5, $class = '', $ext = '', $width = 100,$gettype=0)
	{
		return parent::checkbox($this -> get_val($obj,$gettype), $name, $id, $value, $cols, $class, $ext, $width);
	}
	
	//下拉框复选
	public function get_multiple($obj, $name, $id = '', $value = '', $size = 3, $class = '', $ext = '',$gettype=0)
	{
		return parent::multiple($this -> get_val($obj,$gettype), $name, $id, $value, $size, $class, $ext);
	}
	
	
}
?>