<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$id=$_POST[id];
$number=$_POST[number];
$contacter_name=$_POST[contacter_name];
$dia_id=$_POST[dia_id];
$exports=$_POST[exports];
$jinjia_ext=$_POST[jinjia_ext];
$arr1=explode(",",$exports);
$arr2=explode(",",$jinjia_ext);
$record['export_key'] = md5($number.','.rand(1,1000));
//$record['export_url'] = 'http://'.$_SERVER["SERVER_NAME"].base_url().'index.php/supplier?id='.$id.'&key='.$record['export_key'];
$record['export_url'] = 'supplier_order.php?id='.$id.'&key='.$record['export_key'];
$record['export_time'] =date('Y-m-d H:i:s');

$row=$db->get_results("select export_yuansu from jxc_export where order_id='$id'",ARRAY_A);//判断是否有已导出的元素
if($row){
foreach($row as $v){
	foreach($arr1 as $value){
		if(strpos($v[export_yuansu],$value)!==false){
			echo "失败";
			return;
		}
	}
}
}


//插入jxc_export
$db->query("insert into jxc_export(order_id,export_time,export_yuansu,export_url,export_key) values('$id','$record[export_time]','$exports','$record[export_url]','$record[export_key]')");


for($i=0;$i<count($arr1);$i++){    //更新各表的导出状态和金价
	if(count($arr1)>=2){
		$j=$i-1;
	}else{
		$j=$i;
	}
	if($arr1[$i]=='1'){
		$db->query("update jxc_order set isdia_export='1' where id='$id'");
	}else if($arr1[$i]=='2'){
		$row=$db->get_row("select id from jxc_order_ext where order_id='$id' order by id asc limit 0,1");
		$jinjia=$arr2[$j];//关键点，因为$export和$jinjia_ext数组下表差一位
		$db->query("update jxc_order_ext set is_export='1',jinjia='$jinjia' where id='$row->id'");
	}else if($arr1[$i]=='3'){
		$row=$db->get_row("select id from jxc_order_ext where order_id='$id' order by id asc limit 1,2");
		$jinjia=$arr2[$j];
		$db->query("update jxc_order_ext set is_export='1',jinjia='$jinjia' where id='$row->id'");
	}else if($arr1[$i]=='4'){
		$row=$db->get_row("select id from jxc_order_ext where order_id='$id' order by id asc limit 2,3");
		$jinjia=$arr2[$j];
		$db->query("update jxc_order_ext set is_export='1',jinjia='$jinjia' where id='$row->id'");
	}else if($arr1[$i]=='5'){
		$row=$db->get_row("select id from jxc_order_ext where order_id='$id' order by id asc limit 3,4");
		$jinjia=$arr2[$j];
		$db->query("update jxc_order_ext set is_export='1',jinjia='$jinjia' where id='$row->id'");
	}
	
}


$row=$db->get_results("select is_export from jxc_order_ext where order_id='$id'",ARRAY_A);//判断是否全部导出
if($row){
$a=1;
foreach($row as $v){
	$a=$v[is_export]&&$a;
}
}
$row=$db->get_row("select isdia_export from jxc_order where id='$id'");
$a=$a&&$row->isdia_export;
if($a){
	$a=1;
	$xiadan_date=date('Y-m-d H:i:s');
	$sql="update jxc_order set status='3',export_time='$xiadan_date' where id='$id'";
	$db->query($sql);
	if($dia_id!=""){
		
		$sql="update jxc_diamond set xiadan_date='$xiadan_date',kehu_name='$contacter_name' where id='$dia_id'";
		$db->query($sql);
	}
}
else $a=0;

$arr3[isok]=$a;
$arr3[export_url]=$record['export_url'];
echo json_encode($arr3);









/*
$record['status'] = 3;



$sql="update jxc_order set export_key='$record[export_key]',export_url='$record[export_url]',export_time='$record[export_time]',status='$record[status]' where id='$id'";
$db->query($sql);
if($dia_id!=""){
	$xiadan_date=date('Y-m-d H:i:s');
	$sql="update jxc_diamond set xiadan_date='$xiadan_date',kehu_name='$contacter_name' where id='$dia_id'";
	$db->query($sql);
}


echo $record['export_url'];
*/

?>