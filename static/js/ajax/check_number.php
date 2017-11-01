<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$number=$_POST[number];



$sql="select * from jxc_diamond where number='$number'";
$row=$db->get_row("select * from jxc_diamond where number='$number'");


if($row){
	echo "1";
}else{
	echo "0";
}

?>