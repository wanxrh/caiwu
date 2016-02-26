<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>无标题文档</title>

<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>

</head>

<body>



	<div class="place">

    <span>位置：</span>

    <ul class="placeul">

    <li><a href="#">首页</a></li>

    <li><a href="#">工资表管理</a></li>

    </ul>

    </div>

    <div class="rightinfo">

	 <div class="tools">

    

    	<ul class="toolbar">

        <li class="click"><span></span><a href="index" >返回列表</a></li>

        </ul>

    

    </div>

	<div style="font-size:14px">

	<?php

	if($type=='1') echo "添加字段于表尾";

	if($type=='2') echo "添加字段于表头";

	if($type=='3') echo "添加字段于".$field_name."之后";

	?>

	</div>

	<form name="myform" action="/wagesmanage/add"  method="post"  enctype="multipart/form-data">

	<input type="hidden" name="type" value="<?php echo $type?>">

	<input type="hidden" name="field_name" value="<?php echo $field_name?>">

    <table class="imgtable" style="width:50%">

    

    <thead>

    <tr>

    <th>字段名</th>

	<th>类型</th>

    <th>备注</th>

    <th>选项(不填则为'输入框')</th>
    <th>列入导出模版</th>
    <th>前台可查看</th>
    <th>加入前台查询模块</th>
    <th>加入后台查询模块</th>
    </tr>

    </thead>

    

    <tbody>

		

		<?php

		for($i=1;$i<=11;$i++){

		

		?>

		<tr>

		<td style="padding-top:10px"><input type="text" name="ziduanming<?php echo $i?>" class="dfinput1" st></td>

		<td style="padding-top:10px">

		<select name="leixing<?php echo $i?>" class="dfinput1">

			<option value="int">int</option>

			<option value="varchar">varchar</option>
			<option value="float">float</option>

			<option value="text">text</option>

			</select>

		</td>

		<td style="padding-top:10px"><input type="text" name="beizhu<?php echo $i?>" class="dfinput1"/></td>
		<td style="padding-top:10px"><input type="text" name="xuanxiang<?php echo $i?>" class="dfinput1"/></td>
		<td style="padding-top:10px"><input type="checkbox"  value="1" name="muban<?php echo $i?>" class="dfinput1"/></td>
		<td style="padding-top:10px"><input type="checkbox"  value="1" name="chakan<?php echo $i?>" class="dfinput1"/></td>
		<td style="padding-top:10px"><input type="checkbox"  value="1" name="qianchaxun<?php echo $i?>" class="dfinput1"/></td>
		<td style="padding-top:10px"><input type="checkbox"  value="1" name="houchaxun<?php echo $i?>" class="dfinput1"/></td>
		</tr>

		

        <?php

		}

		?>

               

        </tbody>

    </table>

	<table border="0" style="margin-top:10px">

	<tr>

	<td>

	

   <input type="button" class="btn" value="确定添加" onclick="this.form.submit()"/>

 

	</td></tr></table>

	</form>

   



    </div>





</body>



</html>

