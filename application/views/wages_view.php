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
    <li><a href="main.php">首页</a></li>
    <li><a href="#">我的工资</a></li>
    </ul>
    </div>
    
    <div class="rightinfo" style="width:4000px">

   <div class="formbody" style="width:1200px">
    
    <div class="formtitle"><span>查看工资</span></div>
    <ul class="forminfo">
	<li>
		<span>工资年月：<?php echo $info['nianyue']; ?></span>
	</li>
	<li>
	<?php foreach($dyn as $k=>$v){ ?>
    <?php if($v['column_name'] == 'nianyue') continue?>
	<span><?php echo  $columns[$v['column_name']].'：'; ?>
	<?php 
		if($v['options']){
			$a = explode(',', $v['options']);
			echo isset($a[$info[$v['column_name']]])?$a[$info[$v['column_name']]]:'';
		}else{
			echo $info[$v['column_name']];
		} 		
	?>
	</span>
	<?php if( ($k+1)%3===0) echo '</li><li>';  ?>
	<?php }; ?>
	</li>
    </ul>
    </div>


   
    </div>


</body>

</html>
