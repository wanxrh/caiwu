<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	//$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	//move_uploaded_file($tempFile,$targetFile);
		
	$temp_category = $_POST[temp_category]; 
	$iscreate_design = $_POST[iscreate_design]; 
	$gongfei = $_POST[gongfei]; 
	$factory = $_POST[factory]; 
	
	$arr=explode(',',$temp_category);		
	if(count($arr)!=3){
		
		return;
	}else{
		$image_name = $_FILES['Filedata']['name'];
		//$image_name = strtolower($image_name);
		$brr = explode('.',$image_name);
		$image_folder = $arr[2];
	}
	$targetPath = $_SERVER['DOCUMENT_ROOT'].$_REQUEST['folder'] . '/'.$image_folder.'/';
	$filename = $_FILES['Filedata']['name'];
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	if(file_exists($targetFile)&&$iscreate_design==1){
		echo "exists";
		return;
	}
	move_uploaded_file($tempFile,$targetFile);
	
	if($iscreate_design==-1){
		$record['created_at'] = time();
        $record['name'] = $filename;//$_FILES['Filedata']['name'];
		$record['url'] = $image_folder.'/'.$record['name'];
		$db->query("insert into jxc_uploadpic(created_at,name,url) values('$record[created_at]','$record[name]','$record[url]')");
	}else{
		$record['number']=$brr[0];
		$record['design_name']='自动创建未命名';
		$record['category_id']=$arr[0];
		$record['category_name']=$arr[1];
		$record['image_folder']=$arr[2];
		$record['image_url']=$arr[2].'/'.$filename;
		$record['gongfei']=$gongfei;
		$record['factory']=$factory;
		
		$record['created_at'] = $record['updated_at'] =time();
		$db->query("insert into jxc_design(number,design_name,category_id,category_name,image_folder,image_url,gongfei,factory,created_at,updated_at) values('$record[number]','$record[design_name]','$record[category_id]','$record[category_name]','$record[image_folder]','$record[image_url]','$record[gongfei]','$record[factory]','$record[created_at]','$record[updated_at]')");
	}
	echo "2";
	
	
	
	
	
}




?>