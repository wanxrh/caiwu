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
    </div>
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th style="text-align:center">备份名称</th>
        <th style="text-align:center">卷数</th>
        <th style="text-align:center">压缩</th>
        <th style="text-align:center">数据大小</th>
        <th style="text-align:center">备份时间</th>
        <th style="text-align:center">操作</th>
        </tr>
        </thead>
        <tbody>
         <?php foreach ($list as $val){ ?>
        <tr>  
        <td align="center"><?php echo date('Ymd-His',$val['time']);?></td>
        <td align="center"><?php echo $val['part'];?></td>
        <td align="center"><?php echo $val['compress'];?></td>
        <td align="center"><?php echo bcdiv($val['size'],1024*1024,2).'M';?></td>
        <td align="center"><?php echo date('Y-m-d H:i:s',$val['time']);?></td>
       	<td align="center">
       		<a href="/database/import/<?php echo $val['time']; ?>" class="tablelink">还原</a>
       		<a href="/database/del/<?php echo $val['time']; ?>" class="tablelink"onclick="return confirm('确定要删除吗？')"> 删除</a>
       	</td>
        </tr>
  		<?php }; ?>
        </tbody>
    </table>


    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>
