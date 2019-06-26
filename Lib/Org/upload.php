<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload File</title>
<link href="./Public/css/config.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="./Public/js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="./Public/js/common.js"></script>
<style type="text/css">
</style>
</head>
<body>
<center>
<?php

define('g_upload_file_type','gif|jpg|jpeg|png|bmp|rar|txt|doc|xls|xlsx|docx|ppt|pptx|zip|7z');
define('g_crm_path','D:\xampp\htdocs\TTMS');
define('g_upload_file_path','/Public/Upload');


$return_to = $_REQUEST['return_to'];//返回父窗口表单元素名称,如果同时需要返回原始上传文件名，请在父窗口表单中设置一个ID为$return_to_original
$return_to_org = $_REQUEST['return_to_org'];//返回父窗口表单元素名称,如果同时需要返回原始上传文件名，请在父窗口表单中设置一个ID为$return_to_original
$save_to = $_REQUEST['save_to'];//保存在指定文件夹里
$file_format = $_REQUEST[file_format];//文件格式化
$max_size = $_REQUEST['max_size'];//最大文件大小
$over_write = $_REQUEST['over_write'];//是否覆写
$thumb = $_REQUEST['thumb'];//是否创建缩略图;针对图片文件
$thumb_width = $_REQUEST['thumb_width'];//缩略图宽度
$thumb_height = $_REQUEST['thumb_height'];//缩略图宽度
$call_back = $_REQUEST['call_back'];//回调函数,只传js函数名

//如果收到表单传来的参数，则进行上传处理，否则显示表单
if(isset($_FILES['uploadinput'])){
	//建目录函数，其中参数$directoryName最后没有"/"，
	//要是有的话，以'/'打散为数组的时候，最后将会出现一个空值
	function makeDirectory($directoryName) {
		$directoryName = str_replace("\\","/",$directoryName);
		$dirNames = explode('/', $directoryName);
		$total = count($dirNames) ;
		$temp = '';
		for($i=0; $i<$total; $i++) {
			$temp .= $dirNames[$i].'/';
			if (!is_dir($temp)) {
				$oldmask = umask(0);
				if (!mkdir($temp, 0777)) exit("Can't create folder: $temp"); 
				umask($oldmask);
			}
		}
		return true;
	}

	if($_FILES['uploadinput']['name'] <> ""){
		//包含上传文件类
		require_once ('upload.class.php');
		//设置文件上传目录
		if(trim($save_to) != '')
		{			
			$savePath = $save_to;
		}
		else
		{
			$savePath = g_crm_path.g_upload_file_path;
		}
		//创建目录
		makeDirectory($savePath);
		//允许的文件类型
		
		//$file_format = array('gif','jpg','jpeg','png','bmp','rar','txt','doc','xls','xlsx','docx','ppt','pptx','zip','7z');
		if(trim($file_format) != '')
		{
			$fileFormat = explode('|',$file_format);
		}
		else
		{
			$fileFormat = explode('|',g_upload_file_type);
		}
		
		
		//文件大小限制，单位: Byte，1KB = 1000 Byte
		//0 表示无限制，但受php.ini中upload_max_filesize设置影响
		if(is_numeric($max_size))
		{
			$maxSize = $max_size;
		}
		else
		{
			$maxSize = g_upload_file_size;
		}
		
		//覆盖原有文件吗？ 0 不允许  1 允许 
		$overwrite = intval($over_write);
		//初始化上传类
		$f = new Upload($savePath, $fileFormat, $maxSize, $overwrite);
		//如果想生成缩略图，则调用成员函数 $f->setThumb();
		//参数列表: setThumb($thumb, $thumbWidth = 0,$thumbHeight = 0)
		//$thumb=1 表示要生成缩略图，不调用时，其值为 0
		//$thumbWidth  缩略图宽，单位是像素(px)，留空则使用默认值 130
		//$thumbHeight 缩略图高，单位是像素(px)，留空则使用默认值 130
		
		if($thumb == 1)
		{
			$f->setThumb(intval($thumb),intval($thumb_width),intval($thumb_height));
		}
		else
		{
			$f->setThumb(0);
		}
		
		//参数中的uploadinput是表单中上传文件输入框input的名字
		//后面的0表示不更改文件名，若为1，则由系统生成随机文件名
		if (!$f->run('uploadinput',1)){
			//通过$f->errmsg()只能得到最后一个出错的信息，
			//详细的信息在$f->getInfo()中可以得到。
			echo $f->errmsg()."<br>\n";
		}
		else
		{
			//上传结果保存在数组returnArray中
			
			$ff = $f -> getInfo();
			
			//var_dump($ff);
			//var_dump($_FILES);
			$size = $_FILES['uploadinput']['size'][0];
			$fn = $ff[0][saveName];
			$fno = $ff[0][name];
			//print_r($ff);
			echo "上传成功：".$ff[0][saveName]."</br>";
			echo "<script>";
			if($call_back!='')
			{
				echo "parent.eval('$call_back')('$fno','$fn','$size','','','');";
			}
			echo "</script>";
			echo "<input type=\"button\" name=\"\" id=\"\" value=\"确定\" onclick=\"parent.$('#".$return_to."').val('".$fn."');parent.$('#".$return_to_org."').val('".$fno."');\" />";
		}

		echo "<input type=\"button\" name=\"\" id=\"\" value=\"重新上传\" onclick=\"window.history.go(-1)\" />";
	}
}else{
?>
<form enctype="multipart/form-data" action="" method="POST">
<input name="return_to" type="hidden" value="<?php echo $return_to;?>" />
<input name="return_to_org" type="hidden" value="<?php echo $return_to_org;?>" />
<input name="save_to" type="hidden" value="<?php echo $save_to;?>" />
<input name="file_format" type="hidden" value="<?php echo $file_format;?>" />
<input name="max_size" type="hidden" value="<?php echo $max_size;?>" />
<input name="over_write" type="hidden" value="<?php echo $over_write;?>" />
<input name="thumb" type="hidden" value="<?php echo $thumb;?>" />
<input name="thumb_width" type="hidden" value="<?php echo $thumb_width;?>" />
<input name="thumb_height" type="hidden" value="<?php echo $thumb_height;?>" />
<input name="call_back" type="hidden" value="<?php echo $call_back;?>" />
支持的文件格式：
<?php
if($file_format == ""){
	echo g_upload_file_type;
}
else{
	echo $file_format;
}
?>
<br />
<input name="uploadinput[]" type="file">
<input type="submit" value="确定上传"><br />
</form> 
<?php
}
//我们上传一个已经存在了的图片文件，
//一个正常的图片文件，和一个不允许上传的文件，
//输出结果如下
/*
The uploaded file is Unallowable!

Array
(
    [0] => Array
        (
            [name] => boy.jpg
            [saveName] => boy.jpg
            [size] => 137
            [type] => image/pjpeg
            [error] => File exist already!
        )

    [1] => Array
        (
            [name] => girl.JPG
            [saveName] => girl.JPG
            [size] => 31
            [type] => image/pjpeg
            [originalHeight] => 450
            [originalWidth] => 600
        )

    [2] => Array
        (
            [name] => test.wma
            [saveName] => test.wma
            [size] => 971
            [type] => audio/x-ms-wma
            [error] => The uploaded file is Unallowable!
        )

)
*/
?>
</center>
</body>
</html>