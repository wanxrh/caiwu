<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>
<script src="<?php echo SITE_COMMON_STATIC; ?>/js/validator.js" type="text/javascript"></script><!--表单验证js-->
<script src="<?php echo SITE_COMMON_STATIC; ?>/js/utils.js" type="text/javascript"></script><!--表单验证js-->
<script src="<?php echo SITE_COMMON_STATIC; ?>/js/action.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });

  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>


</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="main.php">首页</a></li>
    <li><a href="#">数据</a></li>
    </ul>
    </div>

    <div class="rightinfo">
    <div class="tools">
	<form id='form' action="" method="post">
        <ul class="toolbar">
        <li><span></span><a href="#" onclick="$('#form').submit();">立即备份</a></li>
        </ul>
	</form>
    </div>
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th style="text-align:center">表名</th>
        <th style="text-align:center">数据量</th>
        <th style="text-align:center">数据大小</th>
        <th style="text-align:center">创建时间</th>
        <th style="text-align:center">更新时间</th>
        </tr>
        </thead>
        <tbody>
         <?php foreach ($list as $val){ ?>
        <tr>  
        <td align="center"><?php echo $val['Name'];?></td>
        <td align="center"><?php echo $val['Rows'];?></td>
        <td align="center"><?php echo bcdiv($val['Data_length'],1024,2).'KB';?></td>
        <td align="center"><?php echo $val['Create_time'];?></td>
       <td align="center"><?php echo $val['Update_time'];?></td>
        </tr>
  		<?php }; ?>
        </tbody>
    </table>


    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>
