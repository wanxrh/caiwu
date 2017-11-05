<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>无标题文档</title>

<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>

</head>


<body>


	<?php if($this->uri->segment(1)=='wages_management'&&$this->uri->segment(2)!='export'):?>
	<div class="place">

    <span>位置：</span>

    <ul class="placeul">

    <li><a href="#">首页</a></li>

    <li><a href="#">工资表导出字段选择</a></li>

    </ul>

    </div>

    <div class="rightinfo">
	<span style="color:red">*备注为空，不能导出</span>
	<form name="myform" action="/wages_management/edit"  method="post"  enctype="multipart/form-data">



    <table class="imgtable" style="width:50%">

    

    <thead>

    <tr>
	 <th width="100px"><input type="checkbox" value="1" id="selectAll" onclick="checkAll()" >模版选择</th>

    <th>字段名</th>

	<th>类型</th>

    <th>备注</th>

    </tr>

    </thead>

    <tbody>

		<?php foreach ($cols as $row){ ?>
		<?php $aaa=",".$row['Field'].",";?>
		<tr style="border-bottom:1px dashed #cccccc">
		 <td align="center"> <span style="margin-left:10px;"></span>
		<?php if($row['Field']!='user_id'&&$row['Field']!='id'&&$row['Field']!='add_time'&&$row['Field']!='gongzileixing'&&$row['Field']!='nianyue1'){?>
		<input type="checkbox" name="checkbox[]" value="<?php echo $row['Field']?>" style="width:20px" <?php if(strpos($row_user['mubanxuanze'],$aaa)!==false) echo "checked";?> >
		<?php }?>
		</td>
		<td><?php echo $row['Field']?></td>

		<td><?php echo $row['Type']?></td>

		<td><?php echo $row['Comment']?></td>

		<td>
		<?php if($row['Field']!="id"&&$row['Field']!="user_id"&&$row['Field']!="nianyue"&&$row['Field']!="add_time"&&$row['Field']!="nianyue"){?>
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
	
    <input type="button" class="btn" value="确定" onclick="this.form.submit()"/>

	</form>
    </div>

<script type="text/javascript">
	function checkAll() 
	{ 
	var checkedOfAll=$("#selectAll").attr("checked"); 
	$("input[name='checkbox[]']").attr("checked", checkedOfAll); 
	}  
</script>
<?php elseif(($this->uri->segment(1)=='user_management')&&$this->uri->segment(2)!='export'):?>
	<div class="place">

    <span>位置：</span>

    <ul class="placeul">

    <li><a href="#">首页</a></li>

    <li><a href="#">用户表导出字段选择</a></li>

    </ul>

    </div>

    <div class="rightinfo">
	<span style="color:red">*备注为空，不能导出</span>
	<form name="myform" action="/user_management/edit"  method="post"  enctype="multipart/form-data">



    <table class="imgtable" style="width:50%">

    

    <thead>

    <tr>
	 <th width="100px"><input type="checkbox" value="1" id="selectAll" onclick="checkAll()" >模版选择</th>

    <th>字段名</th>

	<th>类型</th>

    <th>备注</th>

    </tr>

    </thead>

    <tbody>

		<?php foreach ($cols as $row){ ?>
		<?php $aaa=",".$row['Field'].",";?>
		<tr style="border-bottom:1px dashed #cccccc">
		 <td align="center"> <span style="margin-left:10px;"></span>
		<?php if($row['Field']!='user_id'&&$row['Field']!='cat_id'&&$row['Field']!='bumen_id'&&$row['Field']!='add_time'&&$row['Field']!='mubanxuanze'&&$row['Field']!='mubanxuanze1'&&$row['Field']!='admin_list_ziduan'&&$row['Field']!='yibanyonghu_list_ziduan'){?>
		<input type="checkbox" name="checkbox[]" value="<?php echo $row['Field']?>" style="width:20px" <?php if(strpos($row_user['mubanxuanze1'],$aaa)!==false) echo "checked";?> >
		<?php }?>
		</td>
		<td><?php echo $row['Field']?></td>

		<td><?php echo $row['Type']?></td>

		<td><?php echo $row['Comment']?></td>

		

		</tr>
		<?php }; ?>
        </tbody>

    </table>
	<table border="0" style="margin-top:10px">

	<tr>

	<td>

	</td></tr></table>
	
    <input type="button" class="btn" value="确定" onclick="this.form.submit()"/>

	</form>
    </div>

<script type="text/javascript">
	function checkAll() 
	{ 
	var checkedOfAll=$("#selectAll").attr("checked"); 
	$("input[name='checkbox[]']").attr("checked", checkedOfAll); 
	}  
</script>
<?php elseif(($this->uri->segment(2)=='export')):?>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="main.php">首页</a></li>
    <li><a href="#">导出</a></li>
    </ul>
    </div>
	<div class="tools">
    
    	<ul style="margin-left:15px;margin-top:15px;">
        <li>
		<?php if($_GET['flag']=="yonghu"){?>
		<input type="button" class="btn" value="导出用户模板" onclick="window.location.href='/user_management/export?flag=yonghu&status=1'"/>
		<?php }else{?>
		<input type="button" class="btn" value="导出工资模板" onclick="window.location.href='/wages_management/export?flag=gongzi&status=1'"/>
		<?php }?>
		</li>
        </ul>
    
    </div>
<?php endif;?>

</body>



</html>

