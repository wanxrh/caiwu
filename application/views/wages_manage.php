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

        <li class="click"><span></span><a href="#"  style="color:red" >表名：工资表</a></li>

        </ul>

    

    </div>

	<form name="myform" action="/wagesmanage/addview"  method="post"  enctype="multipart/form-data">

	<div style="font-size:14px">

	添加字段: <input type="radio" name="type" value="1" checked="checked">于表结尾

	<input type="radio" name="type" value="2">于表头

	<input type="radio" name="type" value="3">于&nbsp;&nbsp;之后

	<select name="field_name"  class="dfinput" style="width:100px">

	<?php foreach ($cols as $row){ ?>
	<option value="<?php echo $row['Field']?>"><?php echo $row['Field']?></option>
	<?php }; ?>


	</select>

	<input type="submit" value="执行" style="background-color:#999999; width:50px; height:20px">

	</div>

	</form>

    <table class="imgtable" style="width:50%">

    

    <thead>

    <tr>

    <th>字段名</th>

	<th>类型</th>

    <th>备注</th>

	<th>操作</th>

    </tr>

    </thead>

    

    <tbody>

		

		<?php foreach ($cols as $row){ ?>

		<tr style="border-bottom:1px dashed #cccccc">

		<td><?php echo $row['Field']?></td>

		<td><?php echo $row['Type']?></td>

		<td><?php echo $row['Comment']?></td>

		<td>
		<?php if($row['Field']!="id"&&$row['Field']!="user_id"&&$row['Field']!="add_time"){?>
		<a href="/wagesmanage/info?field_name=<?php echo $row['Field']?>" class="tablelink">编辑</a>&nbsp;|&nbsp;
		<a href="/wagesmanage/del?field_name=<?php echo $row['Field']?>"onclick="return confirm('确定要删除吗？')" class="tablelink">删除</a>
		<?php }?>
		</td>

		</tr>
		<?php }; ?>
        </tbody>

    </table>

	<table border="0" style="margin-top:10px">

	<tr>

	<td>

	</td></tr></table>

    </div>





</body>



</html>

