
<?php
$row_user=$db->get_row("select * from ab11_user_record where user_id='$_SESSION[user_id]'");
$row=$db->get_results("select * from ab11_fengongsi",ARRAY_A);
$s="";
if($row){
foreach($row as $v){
	$aaa=$v[fengongsi_id]."_";
	if(strpos($row_user->quanxian,$aaa)!==false){
		$s.="\"".$v[fengongsi_name]."\",";
	}
}
}
$s="[".substr($s,0,-1)."]";
//echo $s;
?>

<script>
/*
*	全国三级城市联动 js版
*/
function Dsy(){
	this.Items = {};
}
Dsy.prototype.add = function(id,iArray){
	this.Items[id] = iArray;
}
Dsy.prototype.Exists = function(id){
	if(typeof(this.Items[id]) == "undefined") return false;
	return true;
}

function change(v){
	var str="0";
	for(i=0;i<v;i++){
		str+=("_"+(document.getElementById(s[i]).selectedIndex-1));
	}
	var ss=document.getElementById(s[v]);
	with(ss){
		length = 0;
		options[0]=new Option(opt0[v],opt0[v]);
		if(v && document.getElementById(s[v-1]).selectedIndex>0 || !v){
			if(dsy.Exists(str)){
				ar = dsy.Items[str];
				for(i=0;i<ar.length;i++){
					options[length]=new Option(ar[i],ar[i]);
				}//end for
				if(v){ options[0].selected = true; }
			}
		}//end if v
		if(++v<s.length){change(v);}
	}//End with
}

var dsy = new Dsy();



dsy.add("0",<?php echo $s?>);
<?php
$i=0;

foreach($row as $v){
	$row1=$db->get_results("select * from ab11_fenbu where fengongsi_id='$v[fengongsi_id]'",ARRAY_A);
		if($row1){
		$s="";
		foreach($row1 as $w){
			$s.="\"".$w[fenbu_name]."\",";
		}
		}
		$s="[".substr($s,0,-1)."]";
		//echo $s;
		echo 'dsy.add("0_'.$i.'",'.$s.');';
$i++;
}
?>


var s=["s_province","s_city","s_county"];//三个select的name
<?php if($row_muban->fenbu_id){ $row1=$db->get_row("select * from ab11_fenbu a,ab11_fengongsi b where fenbu_id='$row_muban->fenbu_id' and a.fengongsi_id=b.fengongsi_id");?>
var opt0 = ["<?php echo $row1->fengongsi_name?>","<?php echo $row1->fenbu_name?>","市、县级市"];//初始值
<?php }else{?>
var opt0 = ["请选择分公司","请选择分部","市、县级市"];//初始值
<?php }?>
function _init_area(){  //初始化函数
	for(i=0;i<s.length-1;i++){
	  document.getElementById(s[i]).onchange=new Function("change("+(i+1)+")");
	}
	change(0);
}
</script>