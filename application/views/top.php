<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>
<script type="text/javascript">
$(function(){
	//顶部导航切换
	$(".nav li a").click(function(){
		$(".nav li a.selected").removeClass("selected")
		$(this).addClass("selected");
	})
})
</script>


</head>

<body style="background:url(<?php echo SITE_COMMON_STATIC; ?>/images/topbg.gif) repeat-x;">

    <div class="topleft">
    <a href="main.html" target="_parent"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/logo.png" title="系统首页" /></a>
    </div>

<div class="topright" style="width:200px">
     <div class="user">

    <span><i style="color:red">
    <?php echo $cat_name;?>
    </i><?php echo $this->session->userdata('user_name');?>

    <i style="color:red">
    姓名
    </i><?php echo $this->session->userdata('name');?>

    <i style="color:red">
    部门
    </i>
    </span>

    <i><a href="index.php?act=logout" style=" color:#FFFFFF" target="_parent">退出</a></i>

    </div>
</div>
</body>
</html>
