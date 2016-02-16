<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$id=$_POST[id];
$st=$_POST[st];
$jiaohuo_date = date('Y-m-d H:i:s');
$updated_at=time();
$jiaohuo_time=time();


$sql="update jxc_order set status='$st',updated_at='$updated_at',jiaohuo_time='$jiaohuo_time',jiaohuo_date='$jiaohuo_date' where id='$id'";
$db->query($sql);

$sql="update jxc_order_shujv set jiaohuo_date='$jiaohuo_date',isjh='1' where order_id='$id'";
$db->query($sql);

echo "true";
?>