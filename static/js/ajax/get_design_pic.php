<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$number=$_POST[number];

$row=$db->get_row("select * from jxc_design where numberext='$number'");
/*
$s="";
foreach($row as $key=>$value){
	$s.='"'.$key.'":"'.$value.'",';
}
$s="{".substr($s,0,-1)."}";
*/
//print_r($a);
if($row)
echo  json_encode($row);
else echo json_encode();



/*$s=array();
foreach($row as $key=>$value){
	$s[$key]=$value;
}
echo $s;*/
?>