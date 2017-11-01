
<?php
$row=$db->get_results("select * from ab11_fengongsi",ARRAY_A);
$s="";
if($row){
foreach($row as $v){
	$s.="\"".$v[fengongsi_name]."\",";
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
		$j=0;
		foreach($row1 as $w){
			$s.="\"".$w[fenbu_name]."\",";
			
			
			$row2=$db->get_results("select * from ab11_fendian where fenbu_id='$w[fenbu_id]'",ARRAY_A);
			if($row2){
			$s1="";
			foreach($row2 as $k){
				$s1.="\"".$k[fendian_name]."\",";
			}
			}
			$s1="[".substr($s1,0,-1)."]";
			//echo $s1;
			if($row2){
				echo 'dsy.add("0_'.$i.'_'.$j.'",'.$s1.');';
			}
			$j++;
		}
		}
		$s="[".substr($s,0,-1)."]";
		//echo $s;
		if($row1){
			echo 'dsy.add("0_'.$i.'",'.$s.');';
		}
$i++;
}
?>


var s=["s_province","s_city","s_county"];//三个select的name
<?php if($row_edit->fengongsi_name){?>
var opt0 = ["<?php echo $row_edit->fengongsi_name?>","<?php echo $row_edit->fenbu_name?>","市、县级市"];//初始值
<?php }else{?>
var opt0 = ["请选择分公司","请选择分部","请选择分店"];//初始值
<?php }?>
function _init_area(){  //初始化函数
	for(i=0;i<s.length-1;i++){
	  document.getElementById(s[i]).onchange=new Function("change("+(i+1)+")");
	}
	change(0);
}
</script>