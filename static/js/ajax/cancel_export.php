<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$dia_id=$_POST[dia_id];
$order_id=$_POST[order_id];


//É¾³ýjxc_export
$db->query("delete from jxc_export where order_id='$order_id'");
$db->query("update jxc_order_ext set is_export='0' where order_id='$order_id'");
$db->query("update jxc_order set status='2',isdia_export='0' where id='$order_id'");
$db->query("update jxc_diamond set xiadan_date='',kehu_name='' where id='$dia_id'");


echo "true";
?>