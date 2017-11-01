<?php
include_once('../sysmanage/configs/config.inc.php');
include_once('../sysmanage/class/mysql.class.php');
$db = new db(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
if($_GET[act]=="shanchu"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
		$db->query("delete from ab22_gongzibiao where id='$arr[$i]'");
		//echo $arr[$i];
		
	}
	echo "1";
}














if($_GET[act]=="zhengshikehu"){
	$add_time=time();
	$shenhe_time=time();
	$shenhe_date=date("Y-m-d");
	$str=$_POST['str'];
	$id=$_POST['id'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
		
		$row_user=$db->get_row("select * from ab12_user_record where user_id='$arr[$i]'");
		
		//给介绍人，销售中心增加相应的购物券
		$row_jiangjinbili=$db->get_row("select * from ab12_jiangjinbili where jiangjinbili_id='1'");
		$add_time=time();
		if($row_user->jieshaoren_user_id){
			$row_jieshaoren=$db->get_row("select * from ab12_user_record where user_id='$row_user->jieshaoren_user_id'");
			$gouwuquan_add=$row_user->touzijine*$row_jiangjinbili->jieshaojiangli*0.01;
			//$row_jieshaoren_gouwuquan=$row_jieshaoren->jieshaoren_gouwuquan+$gouwuquan_add;
			//$db->query("update ab12_user_record set jieshaoren_gouwuquan='$row_jieshaoren_gouwuquan' where user_id='$row_user->jieshaoren_user_id'");
			$jiangjin=$row_jieshaoren->jiangjin+$gouwuquan_add;
			//echo "update ab12_user_record set jiangjin='$jiangjin' where user_id='$row_user->jieshaoren_user_id'"; exit;
			$db->query("update ab12_user_record set jiangjin='$jiangjin' where user_id='$row_user->jieshaoren_user_id'");
			//记录
			$db->query("insert into ab12_zhuanhuan_record(user_id,zhuanhuan_type,shuliang,zhuanruzhanghao,add_time)
			values('$row_user->user_id','介绍人','$gouwuquan_add','$row_user->jieshaoren_user_id','$add_time')");
		}
		
		if($row_user->xiaoshouzhongxin_user_id){
			$row_xiaoshouzhongxin=$db->get_row("select * from ab12_user_record where user_id='$row_user->xiaoshouzhongxin_user_id'");
			$gouwuquan_add=$row_user->touzijine*$row_jiangjinbili->xiaoshoubutie*0.01;
			//$row_xiaoshouzhongxin_gouwuquan=$row_xiaoshouzhongxin->xiaoshouzhongxin_gouwuquan+$gouwuquan_add;
			//$db->query("update ab12_user_record set xiaoshouzhongxin_gouwuquan='$row_xiaoshouzhongxin_gouwuquan' where user_id='$row_user->xiaoshouzhongxin_user_id'");
			$jiangjin=$row_xiaoshouzhongxin->jiangjin+$gouwuquan_add;
			$db->query("update ab12_user_record set jiangjin='$jiangjin' where user_id='$row_user->xiaoshouzhongxin_user_id'");
			//记录
			$db->query("insert into ab12_zhuanhuan_record(user_id,zhuanhuan_type,shuliang,zhuanruzhanghao,add_time)
			values('$row_user->user_id','销售中心','$gouwuquan_add','$row_user->xiaoshouzhongxin_user_id','$add_time')");
		}
		//开通扣除
		$db->query("insert into ab12_zhuanhuan_record(user_id,zhuanhuan_type,shuliang,zhuanruzhanghao,add_time)
			values('$row_user->user_id','开通扣除','$row_user->touzijine','$row_user->xiaoshouzhongxin_user_id','$add_time')");
		
		
		$shenhe_time=time();
		$shenhe_date=date("Y-m-d");
		$db->query("update ab12_user_record set is_shenhe='1',shenhe_time='$shenhe_time',shenhe_date='$shenhe_date' where user_id='$arr[$i]'");
		
		//记录管理员减少的购物券
				$db->query("insert into ab12_zhuanhuan_record(user_id,zhuanhuan_type,shuliang,zhuanruzhanghao,add_time)
				values('$row_user->xiaoshouzhongxin_user_id','管理员激活账户','$row_user->touzijine','$row_user->user_id','$add_time')");
		
		
	}
	echo "1";
}
if($_GET[act]=="zhengshikehu_xiaoshouzhongxin"){
	session_start();
	$add_time=time();
	$shenhe_time=time();
	$shenhe_date=date("Y-m-d");
	$str=$_POST['str'];
	$id=$_POST['id'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	$touzijine_all="";
	//销售中心剩余购物券
	$row_xiaoshouzhongxin=$db->get_row("select * from ab12_user_record where user_id='$_SESSION[user_id]'");
	$row1=$db->get_row("select sum(shuliang)shuliang_all from ab12_zhuanhuan_record where user_id='$_SESSION[user_id]'");
	$gouwuquan=$row_xiaoshouzhongxin->gouwuquan;
	$touzijine_all='';
	for($i=0;$i<count($arr);$i++){
		$row_user=$db->get_row("select * from ab12_user_record where user_id='$arr[$i]'");
		$touzijine_all+=$row_user->touzijine;
		//$db->query("update ab12_user_record set is_shenhe='1',shenhe_time='$shenhe_time' where user_id='$arr[$i]'");
	}
	//echo $touzijine_all; exit;
	$shengyu_gouwuquan=$gouwuquan-$touzijine_all;
	if($shengyu_gouwuquan<0){
		echo "购物券不足！";
		exit;
	}else{
		for($i=0;$i<count($arr);$i++){
			//更新销售中心减少的购物券
			$db->query("update ab12_user_record set gouwuquan='$shengyu_gouwuquan' where user_id='$_SESSION[user_id]'");
			
			
			$row_user=$db->get_row("select * from ab12_user_record where user_id='$arr[$i]'");
		
			//给介绍人，销售中心增加相应的购物券
			$row_jiangjinbili=$db->get_row("select * from ab12_jiangjinbili where jiangjinbili_id='1'");
			$add_time=time();
			if($row_user->jieshaoren_user_id){
				$row_jieshaoren=$db->get_row("select * from ab12_user_record where user_id='$row_user->jieshaoren_user_id'");
				$gouwuquan_add=$row_user->touzijine*$row_jiangjinbili->jieshaojiangli*0.01;
				//$row_jieshaoren_gouwuquan=$row_jieshaoren->jieshaoren_gouwuquan+$gouwuquan_add;
				//$db->query("update ab12_user_record set jieshaoren_gouwuquan='$row_jieshaoren_gouwuquan' where user_id='$row_user->jieshaoren_user_id'");
				$jiangjin=$row_jieshaoren->jiangjin+$gouwuquan_add;
				//echo $gouwuquan; exit;
				$db->query("update ab12_user_record set jiangjin='$jiangjin' where user_id='$row_user->jieshaoren_user_id'");
				//记录
				$db->query("insert into ab12_zhuanhuan_record(user_id,zhuanhuan_type,shuliang,zhuanruzhanghao,add_time)
				values('$row_user->user_id','介绍人','$gouwuquan_add','$row_user->jieshaoren_user_id','$add_time')");
			}
			
			if($row_user->xiaoshouzhongxin_user_id){
				$row_xiaoshouzhongxin=$db->get_row("select * from ab12_user_record where user_id='$row_user->xiaoshouzhongxin_user_id'");
				$gouwuquan_add=$row_user->touzijine*$row_jiangjinbili->xiaoshoubutie*0.01;
				//$row_xiaoshouzhongxin_gouwuquan=$row_xiaoshouzhongxin->xiaoshouzhongxin_gouwuquan+$gouwuquan_add;
				//$db->query("update ab12_user_record set xiaoshouzhongxin_gouwuquan='$row_xiaoshouzhongxin_gouwuquan' where user_id='$row_user->xiaoshouzhongxin_user_id'");
				$jiangjin=$row_xiaoshouzhongxin->jiangjin+$gouwuquan_add;
				$db->query("update ab12_user_record set jiangjin='$jiangjin' where user_id='$row_user->xiaoshouzhongxin_user_id'");
				//echo "update ab12_user_record set jiangjin='$jiangjin' where user_id='$row_user->xiaoshouzhongxin_user_id'"; exit;
				//记录
				$db->query("insert into ab12_zhuanhuan_record(user_id,zhuanhuan_type,shuliang,zhuanruzhanghao,add_time)
				values('$row_user->user_id','销售中心','$gouwuquan_add','$row_user->xiaoshouzhongxin_user_id','$add_time')");
			}
			//开通扣除
			$db->query("insert into ab12_zhuanhuan_record(user_id,zhuanhuan_type,shuliang,zhuanruzhanghao,add_time)
			values('$row_user->user_id','开通扣除','$row_user->touzijine','$row_user->user_id','$add_time')");
			
			$shenhe_time=time();
			$shenhe_date=date("Y-m-d");
			$db->query("update ab12_user_record set is_shenhe='1',shenhe_time='$shenhe_time',shenhe_date='$shenhe_date' where user_id='$arr[$i]'");
			
			//记录销售中心减少的购物券
				$db->query("insert into ab12_zhuanhuan_record(user_id,zhuanhuan_type,shuliang,zhuanruzhanghao,add_time)
				values('$row_user->xiaoshouzhongxin_user_id','销售中心激活账户','$row_user->touzijine','$row_user->user_id','$add_time')");
		
		}
			
			
			echo '1';
			exit;
	}
	
	
}
if($_GET[act]=="xiaoshouzhongxin"){
	$shenhe_time=time();
	$str=$_POST['str'];
	$id=$_POST['id'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
		$row_user=$db->get_row("select * from ab12_user_record where user_id='$arr[$i]'");
		$touzijine=$row_user->touzijine;
		$row=$db->query("update ab12_user_record set user_cat='2' where user_id='$arr[$i]'");
		
	}
	echo "1";
}
if($_GET[act]=="querentixian"){
	$shenhe_time=time();
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
		$db->query("update ab12_zhuanhuan_record set status_tixian='1' where zhuanhuan_id='$arr[$i]'");
		
	}
	echo "1";
}






if($_GET[act]=="auto_complete"){
	$fahuoren=$_POST['fahuoren'];
	$row=$db->get_row("select * from ab1_fahuoren_record where fahuoren='$fahuoren' order by fahuoren_id desc");
	echo json_encode($row);
}
if($_GET[act]=="piliangshanchu"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("delete from ab1_order where order_id='$arr[$i]'");
		
	}
	echo "123";
}
if($_GET[act]=="piliangdaochu1"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	
	echo $str;
}
if($_GET[act]=="piliangdaochu2"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	
	echo $str;
}
if($_GET[act]=="piliangshenhe"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	$fahuoshijian=time();
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("update ab1_order set status_id='2',fahuoshijian='$fahuoshijian' where order_id='$arr[$i]'");
		
	}
	echo "123";
}
if($_GET[act]=="piliangtuidan"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("update ab1_order set status_id='3' where order_id='$arr[$i]'");
		
	}
	echo "123";
}
if($_GET[act]=="piliangshangbao"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("update ab1_order set status_id='1' where order_id='$arr[$i]'");
		
	}
	echo "123";
}

if($_GET[act]=="order1"){
	$str=$_POST['str'];
	$vala=$_POST['vala'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("update ab1_order set zhuanyunleibie='$vala' where order_id='$arr[$i]'");
		
	}
	echo "123";
}
if($_GET[act]=="order2"){
	$str=$_POST['str'];
	$vala=$_POST['vala'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("update ab1_order set chengyun_id='$vala' where order_id='$arr[$i]'");
		
	}
	echo "123";
}
if($_GET[act]=="order3"){
	$str=$_POST['str'];
	$vala=$_POST['vala'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("update ab1_order set chengyundanhao='$vala' where order_id='$arr[$i]'");
		$vala++;
		
	}
	echo "123";
}
if($_GET[act]=="order4"){
	$str=$_POST['str'];
	$vala=$_POST['vala'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
		$edate=strtotime($vala);
		$row=$db->query("update ab1_order set daodariqi='$edate' where order_id='$arr[$i]'");
		
	}
	echo "123";
}
if($_GET[act]=="order5"){
	$str=$_POST['str'];
	$vala=$_POST['vala'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("update ab1_order set zhuanyunjiage='$vala' where order_id='$arr[$i]'");
		$vala++;
	}
	echo "123";
}
if($_GET[act]=="order6"){
	$str=$_POST['str'];
	$vala=$_POST['vala'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->query("update ab1_order set jiesuanfangshi='$vala' where order_id='$arr[$i]'");
		
	}
	echo "123";
}
if($_GET[act]=="chankankuaijianxinxi"){
	$vala=$_POST['vala'];
	$row=$db->get_row("select * from ab1_order where sanyudanhao='$vala'");
	
	echo $row->order_id;
}








if($_GET[act]=="edit_danhao"){
	$huowuid=$_POST['huowuid'];
	$content=$_POST['content'];
	$row=$db->query("update fz21_huowu set danhao='$content' where huowuid='$huowuid'");
	if($row) echo  "1";
	else echo "0";
}else if($_GET[act]=="edit_meiguodanhao"){
	$huowuid=$_POST['huowuid'];
	$content=$_POST['content'];
	$row=$db->query("update fz21_huowu set meiguodanhao='$content' where huowuid='$huowuid'");
	if($row) echo  "1";
	else echo "0";
}else if($_GET[act]=="edit_guojidanhao"){
	$huowuid=$_POST['huowuid'];
	$content=$_POST['content'];
	$row=$db->query("update fz21_huowu set guojidanhao='$content' where huowuid='$huowuid'");
	if($row) echo  "1";
	else echo "0";
}else if($_GET[act]=="edit_yongjin"){
	$userid=$_POST['userid'];
	$content=$_POST['content'];
	$row=$db->query("update fz21_user_record set yongjin='$content' where userid='$userid'");
	if($row) echo  "1";
	else echo "0";
}else if($_GET[act]=="change_status"){
	$huowuid=$_POST['huowuid'];
	$status=$_POST['status'];
	$row=$db->query("update fz21_huowu set status='$status' where huowuid='$huowuid'");
	if($row) echo  "1";
	else echo "0";
}else if($_GET[act]=="select_shop"){
	$huowuid=$_POST['huowuid'];
	$shopid=$_POST['shopid'];
	$row=$db->query("update fz21_huowu set shopid='$shopid' where huowuid='$huowuid'");
	if($row) echo  "1";
	else echo "0";
}else if($_GET[act]=="dakuanshue"){
	$userid=$_POST['userid'];
	$str=$_POST['str'];
	$linshi_yongjin=$_POST['linshi_yongjin'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("select * from fz21_huowu where huowuid='$arr[$i]'");
		if($row->caigou_num){
			$a=$row->price*$row->caigou_num;
		}else{
			$a=$row->price*$row->num;
		}
		$s=$s+$a;
	}
	if($linshi_yongjin=="临时佣金率"){	
		$row_user=$db->get_row("select * from fz21_user_record where userid='$userid'");
		if(!$row_user->yongjin) echo $row_user->name."的佣金率还没设置，请先设置！";
		else echo $s*($row_user->yongjin);
	}else{
		echo $s*($linshi_yongjin);
	}
}else if($_GET[act]=="quedingdakuan"){
	$userid=$_POST['userid'];
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("update fz21_huowu set is_dakuan='1' where huowuid='$arr[$i]'");
	}
	echo "操作成功";
}else if($_GET[act]=="quedinggoumai"){
	$userid=$_POST['userid'];
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("update fz21_huowu set status='2' where huowuid='$arr[$i]'");
	}
	echo "操作成功";
}else if($_GET[act]=="quedingyouji"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
		$db->query("update fz21_huowu set status='3' where huowuid='$arr[$i]'");
	}
	echo "操作成功";
}else if($_GET[act]=="quedingdanhao"){
	$userid=$_POST['userid'];
	$str=$_POST['str'];
	$danhao=$_POST['danhao'];
	$edate=$_POST['edate'];
	$company=$_POST['company'];
	$qishidi=$_POST['qishidi'];
	$mudidi=$_POST['mudidi'];
	$youfei=$_POST['youfei'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("update fz21_huowu set danhao='$danhao' where huowuid='$arr[$i]'");
	}
	$row=$db->get_row("select * from fz21_kuaidi where danhao='$danhao' and company='$company'");
	if(!$row){
		$db->query("insert into fz21_kuaidi(danhao,company,qishidi,mudidi,youfei,edate) values('$danhao','$company','$qishidi','$mudidi','$youfei','$edate')");
	}
	echo "操作成功";
}else if($_GET[act]=="quedingdanhao1"){
	$userid=$_POST['userid'];
	$str=$_POST['str'];
	$danhao=$_POST['danhao'];
	$edate=$_POST['edate'];
	$company=$_POST['company'];
	$qishidi=$_POST['qishidi'];
	$mudidi=$_POST['mudidi'];
	$youfei=$_POST['youfei'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("update fz21_huowu set meiguodanhao='$danhao' where huowuid='$arr[$i]'");
	}
	$row=$db->get_row("select * from fz21_kuaidi where danhao='$danhao' and company='$company'");
	if(!$row){
		$db->query("insert into fz21_kuaidi(danhao,company,qishidi,mudidi,youfei,edate) values('$danhao','$company','$qishidi','$mudidi','$youfei','$edate')");
	}
	echo "操作成功";
}else if($_GET[act]=="quedingdanhao2"){
	$userid=$_POST['userid'];
	$str=$_POST['str'];
	$danhao=$_POST['danhao'];
	$edate=$_POST['edate'];
	$company=$_POST['company'];
	$qishidi=$_POST['qishidi'];
	$mudidi=$_POST['mudidi'];
	$youfei=$_POST['youfei'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("update fz21_huowu set guojidanhao='$danhao' where huowuid='$arr[$i]'");
	}
	$row=$db->get_row("select * from fz21_kuaidi where danhao='$danhao' and company='$company'");
	if(!$row){
		$db->query("insert into fz21_kuaidi(danhao,company,qishidi,mudidi,youfei,edate) values('$danhao','$company','$qishidi','$mudidi','$youfei','$edate')");
	}
	echo "操作成功";
}else if($_GET[act]=="quedingruku"){
	$userid=$_POST['userid'];
	$str=$_POST['str'];
	$danhao=$_POST['danhao'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("update fz21_huowu set status='6' where huowuid='$arr[$i]'");
	}
	echo "操作成功";
}else if($_GET[act]=="quedingshouhuo"){
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
		$ruxiaoshoudian_date=time();
		$db->query("update fz21_huowu set chuku_status='3',ruxiaoshoudian_date='$ruxiaoshoudian_date' where huowuid='$arr[$i]'");
		//$row=$db->get_row("update fz21_huowu set status='6' where huowuid='$arr[$i]'");
	}
	echo "操作成功";
}else if($_GET[act]=="qunshop"){
	$shopid=$_POST['shopid'];
	$str=$_POST['str'];
	$danhao=$_POST['danhao'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("update fz21_huowu set shopid='$shopid' where huowuid='$arr[$i]'");
	}
	echo "操作成功";
}else if($_GET[act]=="yeschuku"){
	$userid=$_POST['userid'];
	$str=$_POST['str'];
	$str=substr($str,0,-1);
	$arr=explode(",",$str);
	$s="";
	for($i=0;$i<count($arr);$i++){
	
		$row=$db->get_row("update fz21_huowu set chuku_status='2' where huowuid='$arr[$i]'");
	}
	echo "出库成功";
}
else if($_GET[act]=="chushou_record"){
	$shopid=$_POST['shopid'];
	$huowuid=$_POST['huowuid'];
	$id=$_POST['id'];
	$taobaobianhao=$_POST['taobaobianhao'];
	$edate=$_POST['edate'];
	$price=$_POST['price'];
	$num=$_POST['num'];
	$youfei=$_POST['youfei'];
	$danhao=$_POST['danhao'];
	$company=$_POST['company'];
	$qishidi=$_POST['qishidi'];
	$mudidi=$_POST['mudidi'];
	$beizhu=$_POST['beizhu'];
	$arr=explode("-",$edate);
	$edate=mktime(date("H"),date("i"),date("s"),$arr[1],$arr[2],$arr[0]);
	$db->query("insert into fz21_order(shopid,huowuid,maijiaid,taobaobianhao,price,num,youfei,danhao,beizhu,edate) values('$shopid','$huowuid','$id','$taobaobianhao','$price','$num','$youfei','$danhao','$beizhu','$edate')");
	$db->query("update fz21_huowu set chuku_status='4' where huowuid='$huowuid'");
	
	$row=$db->get_row("select * from fz21_kuaidi where danhao='$danhao' and company='$company'");
	if(!$row){
		$db->query("insert into fz21_kuaidi(danhao,company,qishidi,mudidi,youfei,edate) values('$danhao','$company','$qishidi','$mudidi','$youfei','$edate')");
	}
	
	if($row) echo "1";
	else echo "0";
}else if($_GET[act]=="tuikuan_record"){
	$huowuid=$_POST['huowuid'];
	$tuikuan_num=$_POST['tuikuan_num'];
	$tuikuan_date=$_POST['tuikuan_date'];
	$tuikuan_user=$_POST['tuikuan_user'];
	$tuikuan_beizhu=$_POST['tuikuan_beizhu'];
	$is_tuihuo=$_POST['is_tuihuo'];
	$shopid=$_POST['shopid'];
	$orderid=$_POST['orderid'];
	$arr=explode("-",$tuikuan_date);
	$tuikuan_date=mktime(date("H"),date("i"),date("s"),$arr[1],$arr[2],$arr[0]);
	$row=$db->get_row("update fz21_order set tuikuan_num='$tuikuan_num',tuikuan_date='$tuikuan_date',tuikuan_user='$tuikuan_user',tuikuan_beizhu='$tuikuan_beizhu',is_tuihuo='1'  where orderid='$orderid' ");
	$db->query("update fz21_huowu set chuku_status='3' where huowuid='$huowuid'");//退货更新
	if($row) echo "1";
	else echo "0";
}else if($_GET[act]=="change_caigou_num"){
	$huowuid=$_POST['huowuid'];
	$caigou_num=$_POST['caigou_num'];
	$row=$db->get_row("update fz21_huowu set caigou_num='$caigou_num' where huowuid='$huowuid'");
	echo "修改成功";
}
?>