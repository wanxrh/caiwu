<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$order_id=$_POST[order_id];
$cbjinjia=$_POST[cbjinjia];
$tuonumber=$_POST[tuonumber];

if($tuonumber=='1'){
	$row=$db->get_row("select * from jxc_order_ext where order_id='$order_id' limit 0,1");
	$db->query("update jxc_order_ext set chengben='$cbjinjia',is_wancheng='1' where id='$row->id'");
}
if($tuonumber=='2'){
	$row=$db->get_row("select * from jxc_order_ext where order_id='$order_id' limit 1,2");
	$db->query("update jxc_order_ext set chengben='$cbjinjia',is_wancheng='1' where id='$row->id");
}
if($tuonumber=='3'){
	$row=$db->get_row("select * from jxc_order_ext where order_id='$order_id' limit 2,3");
	$db->query("update jxc_order_ext set chengben='$cbjinjia',is_wancheng='1' where id='$row->id");
}
if($tuonumber=='4'){
	$row=$db->get_row("select * from jxc_order_ext where order_id='$order_id' limit 3,4");
	$db->query("update jxc_order_ext set chengben='$cbjinjia',is_wancheng='1' where id='$row->id");
}

$row=$db->get_row("select * from jxc_order_ext where order_id='$order_id' and is_wancheng<>'1'");//判断是否所有托都已经完成
if($row) echo "success";
else{
	$db->get_row("update jxc_order set status='4' where id='$order_id'");
	echo "success_all";
}

?>