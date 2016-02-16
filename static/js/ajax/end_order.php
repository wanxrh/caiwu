<?php
include_once('../../sysmanage/configs/config.inc.php');
include_once('../../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
function create_sj($id,$number)
		{
			//$result = $this->Mglobal->select_byid('order',$id);
			$result=$db->get_row("select * from jxc_order where id='$id'");
			if(!$result)
				return false;
			$record['record_time'] = date('Y-m-d H:i:s');
			$record['shuju_number'] = date('Ymd').$id;
			$record['order_id'] = $id;
			$record['order_number'] = $number;
			$record['order_time'] = $result->record_time;
			$record['shopid'] = $result->shopid;
			$record['shopname'] = $result->shopname;
			$record['order_allmoney'] = $result->allmoney;
			$record['diamond_jinjia'] = $result->dia_jinjia;
			$record['diamond_shoujia'] = $result->price;
			$record['jietuo_chengben'] = $result->jietuo_chengben;
			//$this->Mglobal->insert_record('order_shuju',$record);
			$sql="insert into jxc_order_shujv(record_time,shuju_number,order_id,order_number,order_time,shopid,shopname,order_allmoney,diamond_jinjia,diamond_shoujia,jietuo_chengben) values('$record[record_time]','$record[shuju_number]','$record[order_id]','$record[order_number]','$record[order_time]','$record[shopid]','$record[shopname]','$record[order_allmoney]','$record[diamond_jinjia]','$record[diamond_shoujia]','$record[jietuo_chengben]')";
		}
$id=$_POST[id];
$dia_id=$_POST[dia_id];
$st=$_POST[st];
$number=$_POST[number];
$end_time=date('Y-m-d H:i:s');
$shuju_number = date('Ymd').$id;
if($number == ''||$id == '') return;



$sql="update jxc_order set dia_status='$st',status='$st',end_time='$end_time',shuju_number='$shuju_number' where id='$id' and number='$number'";
$db->query($sql);
$db->query("update jxc_order_ext set chengben='0',is_wancheng='0' where order_id='$id'");


if($st == 4){
	if($dia_id!=""){ //更新钻石表（已交货，出售的分店信息）
	$row=$db->get_row("select * from jxc_order where id='$id'");
	$xiadan_date=date('Y-m-d H:i:s');
	$sql="update jxc_diamond set status='4',sellshopid='$row->shop_id',sellshopname='$row->shop_name' where id='$dia_id'";
	$db->query($sql);
	}
	create_sj($id,$number);//插入收据表
}

echo "true";
?>