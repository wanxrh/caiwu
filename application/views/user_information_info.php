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

    <li><a href="#">用户信息表管理</a></li>

    </ul>

    </div>

    <div class="rightinfo">


	 <div class="tools">

    

    	<ul class="toolbar">

        <li class="click"><span></span><a href="/user_information" >返回列表</a></li>

        </ul>

    

    </div>

	<div style="font-size:14px">

	</div>

	<form name="myform" action="/user_information/edit"  method="post"  enctype="multipart/form-data">

	<input type="hidden" name="field_name" value="<?php echo $field_name?>">

    <table class="imgtable" style="width:50%">

    

    <thead>

    <tr>

    <th>字段名</th>

	<th>类型</th>

    <th>备注</th>
    <th>列入导出模版</th>
    <th>前台可查看(选中则导出excel字段)</th>
    </tr>

    </thead>

    

    <tbody>


		<tr>

		<td style="padding-top:10px"><input type="text" name="ziduanming" class="dfinput1" value="<?php echo $row['COLUMN_NAME']; ?>"></td>

		<td style="padding-top:10px">

		<select name="leixing" class="dfinput1">

			<option value="int" <?php if($row['DATA_TYPE']=="int") echo "selected";?>>int</option>

			<option value="varchar" <?php if($row['DATA_TYPE']=="varchar") echo "selected";?>>varchar</option>
			<option value="decimal" <?php if($row['DATA_TYPE']=="decimal") echo "selected";?>>decimal</option>

			<option value="text" <?php if($row['DATA_TYPE']=="text") echo "selected";?>>text</option>

			</select>

		</td>

		<td style="padding-top:10px"><input type="text" name="beizhu" class="dfinput1" value="<?php echo $row['COLUMN_COMMENT']; ?>"/></td>
		<td style="padding-top:10px"><input type="checkbox"  value="1" <?php if($dyn['template']) echo ' checked=true ' ?> name="muban" class="dfinput1"/></td>
        <td style="padding-top:10px"><input type="checkbox"  value="1" <?php if(!empty($dyn['view'])?$dyn['view']:'') echo ' checked=true ' ?> name="chakan" class="dfinput1"/></td>
		</tr>



               

        </tbody>

    </table>

	<table border="0" style="margin-top:10px">

	<tr>

	<td>

	

   <input type="button" class="btn" value="确定编辑" onclick="this.form.submit()"/>

 

	</td></tr></table>

	</form>


    </div>





</body>



</html>

