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
	
	<div class="tools">
    
    	<form action="?act=list" method="get">
		<input type="hidden" name="a" value="a">
		时间区间：
		<select name="nian1" id="nian1" class="dfinput2" style="width:80px">

			<option value="1" >1</option>
			
			</select>年
			<select name="yue1" id="yue1" class="dfinput2" style="width:80px">
			<option value="">请选择</option>

			<option value="1" >1</option>
			
			</select>月------
			<select name="nian2" id="nian2" class="dfinput2" style="width:80px">
			
			<option value="1" >1</option>
			
			</select>年
			<select name="yue2" id="yue2" class="dfinput2" style="width:80px">
			<option value="">请选择</option>
			
			<option value="1" >1</option>
			
			</select>月
			
		&nbsp;&nbsp;&nbsp;&nbsp;工资类型：
		<select name="gongzileixing" id="gongzileixing" class="dfinput2" style="width:170px">

			<option value=""  >123</option>

			</select><script>$('#gongzileixing').val(综合)</script>
			
			职员类型：
		<select name="zhiyuanleixing" id="zhiyuanleixing" class="dfinput2" style="width:80px">
			<option value="">请选择</option>
			<option value="在编">在编</option>
			<option value="外聘">外聘</option>
			</select><script>$('#zhiyuanleixing').val('12')</script>
		
			部门：
		<select name="bumen" id="bumen" class="dfinput2" style="width:80px">
			<option value="">请选择</option>
			
			<option value="" >123</option>

			</select><script>$('#bumen').val('123')</script>
		姓名：<input type="text" name="name" id="name" class="dfinput" style="width:80px" value="">
		
		
		<input type="submit" value="查询" class="btn">

			
		<input type="button" class="btn" value="导出excel" onclick="window.location.href='excel9.php?where=&gongzileixing='"/>

		
		</form>
    
    </div>
	
	<div class="tools">
    
    	<ul class="">
        <li class="">
		
		<input type="button" class="btn" value="导出excel" onclick="window.location.href='excel1.php?where=&gongzileixing='"/>
		<input type="button" id="btn2" class="btn" value="批量删除">
		<input type="button" id="btn2" class="btn" onclick="window.location.href='gongzi_list.php?where=&st=del_jieguo'" value=" 删除所有搜索结果">
		
		<b style="color:red; font-size:18px">
		
		</b>
		</li>
        </ul>
    
    </div>
    <style>
	td { text-align:center}
	th { text-align:center}
	</style>
    <table class="tablelist" style="width:auto">
    	<thead>
    	<tr>
        <th style="text-align:center">

		<input type="checkbox" id="btn1"/>编号

		<i class="sort"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/px.gif" /></i></th>
		<th style="text-align:center">工资年月</th>
		<th style="text-align:center">工资类型</th>


		<th style="text-align:center">姓名</th>
		<th style="text-align:center">部门</th>
		<?php foreach ($columns as $v){ ?>
		<th style="text-align:center;" ><?php echo $v; ?></th>
		<?php }; ?>
        <th style="text-align:center">操作</th>
        </tr>
        </thead>
        <tbody>

        <tr>
        <td>
		<input type="checkbox" name="checkbox[]" value="" style="width:20px">
		</td>
		<td>123</td>
		<td>123</td>

        <td><a href="?act=view&id=&user_id=" class="tablelink">123</a></td>
		<td>123</td>
		
       <td>
	   <a href="?act=view&id=&user_id=" class="tablelink">查看</a>
		
       　<a href="?act=edit&id=&user_id=" class="tablelink">编辑</a>　<a href="?st=del&id=" class="tablelink"> 删除</a></td>

        </tr> 

		</tbody>
		
		
		
		
		
		
		
		
		<thead>
         <tr>
		 
		 <th>此页合计<?php //echo $sss?></th>
		 <th align="center">&nbsp;</th>
		 <th align="center">&nbsp;</th>

		<th align="center">&nbsp;</th>
		 <th align="center">&nbsp;</th>

		 
		 <th align="center">&nbsp;</th>
		 
		 </tr> 
		 </thead>
		 
		 
		 
		 <thead>
         <tr>
		 
		 <th>总合计<?php //echo $sss?></th>
		 <th align="center">&nbsp;</th>
		 <th align="center">&nbsp;</th>

		<th align="center">&nbsp;</th>
		 <th align="center">&nbsp;</th>

		 


		 <th align="center">&nbsp;</th>
		 
		 </tr> 
		 </thead>  
        
    </table>
	<table border="0" style="margin-top:10px">
	<tr>
	<td>
	</td></tr></table>
	<div style="width:1200px">
   <?php //showpage();?>
   </div> 
 
    </div>


</body>

</html>
