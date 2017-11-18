<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/My97DatePicker/WdatePicker.js"></script>
</head>


<body>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="main.php">首页</a></li>
    <li><a href="#">我的工资</a></li>
    </ul>
    </div>
    
    <div class="rightinfo" style="width:4000px">

   <div class="formbody" style="width:1200px">
    
    <div class="formtitle"><span>编辑工资</span></div>
    <form name="myform" action="/wageslist/edit?id=<?php echo $_GET['id']; ?>"  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
    <input name="id" type="hidden" value="<?php echo $_GET['id']; ?>">
    <ul class="forminfo">
	<li>
        <span>姓名：<?php echo $info['name']?></span>
		<span>工资年月：<input class="dfinput2" style="width:80px"  name="nianyue" value="<?php echo $info['nianyue']; ?>"/></span>
		<span>工资类型：
		<select class="dfinput2"  name="gongzileixing">
		<option value="">请选择</option>
		<?php foreach($gongzi_type as $v){ ?>
		<option <?php if($info['gongzileixing'] ==$v['gongzileixing_name'] ){?>selected="selected" <?php }?> value="<?php echo $v['gongzileixing_name'];?>"><?php echo $v['gongzileixing_name'];?></option>
		<?php }; ?>
		</select>
		</span>
	</li>
	<li>
	<?php foreach($dyn2 as $k=>$v){ ?>
    <?php if($v['column_name'] == 'gongzileixing' || $v['column_name'] == 'nianyue') continue;?>
	<span><?php echo  $columns[$v['column_name']].'：'; ?>
	<?php if($v['options']){ ?>
	<select class="dfinput2"  name="<?php echo $v['column_name']; ?>">
		<option value="">请选择</option>
		<?php foreach(explode(',', $v['options']) as $vv){ ?>
		<option <?php if($info[$v['column_name']] ==$vv ) echo 'selected="true"'; ?> value="<?php echo $vv;?>"><?php echo $vv;?></option>
		<?php }; ?>
	</select>
	<?php }else{ ?>
	<input name="<?php echo $v['column_name']; ?>"class="dfinput2"  value="<?php echo $info[$v['column_name']]; ?>" >
	<?php }; ?>
	</span>
	<?php if( ($k+1)%3===0) echo '</li><li>';  ?>
	<?php }; ?>
	</li>
	<li><label>&nbsp;</label><input type="submit" class="btn" value="确定" /></li>
    </ul>
    </form>
    </div>


   
    </div>


</body>
<script type="text/javascript">
    $("input[name='nianyue']").focus(function () {
        WdatePicker({
            skin: 'whyGreen',
            dateFmt: 'yyyy-MM'

        });
    });
</script>
</html>
