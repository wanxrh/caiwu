<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$id=$_POST[id];
$payway2=$_POST[payway2];


$db->query("update jxc_order set payway2='$payway2' where id='$id'");



echo "success";

?>