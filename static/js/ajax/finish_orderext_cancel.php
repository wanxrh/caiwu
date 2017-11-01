<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$extid=$_POST[extid];


$db->query("update jxc_order_ext set chengben='0',is_wancheng='0' where id='$extid'");



echo "success";

?>