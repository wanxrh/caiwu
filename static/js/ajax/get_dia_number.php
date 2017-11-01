<?php
session_start();
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$para1=$_POST[para1];
$para2=$_POST[para2];
$para3=$_POST[para3];
$para4=$_POST[para4];
$para5=$_POST[para5];
$para6=$_POST[para6];
$zhengshu=$_POST[zhengshu];

//角色判断1
if($_SESSION[juese]=="总经理"){
  	//$sql="select * from jxc_diamond where sell_status=1";
	$sql="select id,number,zhengshu,price,status from jxc_diamond where para1='$para1' and para2='$para2' and para3='$para3' and para4='$para4' and para5='$para5' and para6='$para6' and zhengshu='$zhengshu' and sell_status='1'";
  }else if($_SESSION[juese]=="区域经理"){
  	$arr_shopid=explode(",",$_SESSION[shopid]);
	//print_r($arr_shopid);
	$s="";
	foreach($arr_shopid as $k=>$v){
		if($v){
			$s.=" sellshopid='".$v."' or";
		}
	}
	
	$s=" and (".substr($s,0,-3).")";
	//echo $s;
	//$sql="select * from jxc_diamond where sell_status=1".$s;
	$sql="select id,number,zhengshu,price,status from jxc_diamond where para1='$para1' and para2='$para2' and para3='$para3' and para4='$para4' and para5='$para5' and para6='$para6' and zhengshu='$zhengshu' and sell_status='1'".$s;
  }else{
  	
	//$sql="select * from jxc_diamond where sell_status=1 and sellshopid='$_SESSION[shopid]'";
	$sql="select id,number,zhengshu,price,status from jxc_diamond where para1='$para1' and para2='$para2' and para3='$para3' and para4='$para4' and para5='$para5' and para6='$para6' and zhengshu='$zhengshu' and sell_status='1' and sellshopid='$_SESSION[shopid]'";
  }
//角色判断2




$row=$db->get_row($sql);
//$row=$db->get_row("select id,number,zhengshu,price,status from jxc_diamond where para1='$para1' and para2='$para2' and para3='$para3' and para4='$para4' and para5='$para5' and para6='$para6' and zhengshu='$zhengshu'");
if($row) echo json_encode($row);
else echo "无符合钻石";
/*
$s="";
foreach($row as $key=>$value){
	$s.='"'.$key.'":"'.$value.'",';
}
$s="{".substr($s,0,-1)."}";
*/
//print_r($a);
//if($row)
//echo  json_encode($row);
//else echo json_encode();



/*$s=array();
foreach($row as $key=>$value){
	$s[$key]=$value;
}
echo $s;*/
?>