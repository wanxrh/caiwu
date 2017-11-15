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
        <span>姓名：<?php echo $info['name']?></span>
		<span>工资年月：<?php echo $info['nianyue']; ?></span>
	</li>
	<li>
	<?php foreach($columns as $k=>$v){ ?>
    <?php if($k == 'nianyue') continue;
        if(in_array($k,$dyn2)){
        ?>
	<span><?php echo  $v.'：'; ?>
	<?php 
        echo $info[$k];
	?>
	</span>
	<?php if( ($k+1)%3===0) echo '</li><li>';  ?>
	<?php }
        }; ?>
	</li>
    </ul>
    </div>


   
    </div>


</body>

</html>
