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
    <li><a href="news.php">公告</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    <?php if($user_info['cat_id']=='-1'):?>
    <div class="tools">
    	<ul class="toolbar">
        <li class="click"><span></span><a href="/system_notice"<?php if($this->uri->segment(2)==''||$this->uri->segment(3)!='') echo 'style="color:red"';?>>公告列表</a></li>
		<li class="click"><span></span><a href="/system_notice/add"<?php if($this->uri->segment(2)!=''&&$this->uri->segment(3)=='') echo 'style="color:red"';?>>添加公告</a></li>
        </ul>
    </div>
     <?php endif;?>
    <?php if($this->uri->segment(2)==''):?>
    <style>
	td { text-align:center}
	th { text-align:center}
	</style>
    <table class="tablelist">
    	<thead>
    	<tr>
        <th style="text-align:center" width="100px">编号<i class="sort"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/px.gif" /></i></th>
		<th style="text-align:center">标题</th>
		<th style="text-align:center" width="200px">添加时间</th>
		<?php if($user_info['cat_id']=='-1'):?>
		<th style="text-align:center" width="200px">操作</th>
		 <?php endif;?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($news as $key=>$val):?>
        <tr>
        <td><?php echo $val['news_id'];?></td>
        <td><a href="/system_notice/view/<?php echo $val['news_id'];?>" class="tablelink"><?php echo $val['title'];?></a></td>
		<td><?php echo date("Y-m-d H:i:s",$val['add_time']);?></td>
		<?php if($user_info['cat_id']=='-1'):?>
       <td><a href="/system_notice/edit/<?php echo $val['news_id'];?>" class="tablelink">查看/编辑</a>     <a href="/system_notice/del/<?php echo $val['news_id'];?>" class="tablelink"onclick="return confirm('确定要删除吗？')"> 删除</a></td>
        <?php endif;?>
        </tr>   
         <?php endforeach;?>   
        </tbody>
    </table>
    <?php echo $page;?>
	<?php elseif(($this->uri->uri_string()=='system_notice/add')):?>
	 <div class="formbody">
    
    <div class="formtitle"><span>添加公告</span></div>
    <form name="myform" action="?act=add_1"  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
    <ul class="forminfo1">
    <input type="hidden" name="cat_id" value="1">
	<li><label>标题</label><input type="text" name="title" class="dfinput" style="width:300px"></li>
	<script charset="utf-8" src="<?php echo SITE_COMMON_STATIC; ?>/js/keditor/kindeditor-min.js"></script>
		<script charset="utf-8" src="<?php echo SITE_COMMON_STATIC; ?>/js/keditor/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true
				});
			});
		</script>
	<!--<li><label>摘要</label><textarea name="zhaiyao" class="dfinput" style="width:640px;height:50px;"></textarea></li>-->
	<li><label>内容</label><textarea name="content" style="width:800px;height:400px;visibility:hidden;"></textarea></li>
	
    <li><label>&nbsp;</label><input type="submit" class="btn" value="确定" /></li>
    </ul>
    </form>
    	<script>
		function validate()
		{
			//alert($('#user_name').val());
			var validator = new Validator('myform');
			//validator.isNullOption('cat_id','请选择角色');required
			validator.required('title',"请输入标题");
			//validator.required('content',"请输入内容");
			
			if(validator.passed()){
				return true;
			}else{
				return false;
			}
		 }
		</script>
    </div>
    <?php elseif(($this->uri->segment(2)=='edit')):?>
	<div class="formbody">
    
    <div class="formtitle"><span>编辑信息</span></div>
    <form name="myform" action="#"  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
	<input type="hidden" name="news_id" value="<?php echo $news['news_id'];?>">
    <ul class="forminfo1">
	<li><label>标题</label><input type="text" name="title" class="dfinput" style="width:300px" value="<?php echo $news['title'];?>"></li>
	<script charset="utf-8" src="<?php echo SITE_COMMON_STATIC; ?>/js/keditor/kindeditor-min.js"></script>
		<script charset="utf-8" src="<?php echo SITE_COMMON_STATIC; ?>/js/keditor/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true
				});
			});
		</script>
	<li><label>内容</label><textarea name="content" style="width:640px;height:400px;visibility:hidden;"><?php echo $news['content']?></textarea></li>
	
    <li><label>&nbsp;</label><input type="submit" class="btn" value="确定" /></li>
    </ul>
    </form>
    	<script>
	function validate()
	{
		//alert($('#user_name').val());
		var validator = new Validator('myform');
		//validator.isNullOption('cat_id','请选择角色');required
		validator.required('title',"请输入标题");
		//validator.required('content',"请输入内容");
		
		if(validator.passed()){
			return true;
		}else{
			return false;
		}
	 }
	</script>
    </div>
	<?php elseif(($this->uri->segment(2)=='view')):?>
	<div class="formbody">
    
    <div class="formtitle"><span><?php echo $news_view['title'];?></span></div>
   <?php echo $news_view['content']?>
    	<script>
		function validate()
		{
			//alert($('#user_name').val());
			var validator = new Validator('myform');
			//validator.isNullOption('cat_id','请选择角色');required
			validator.required('title',"请输入标题");
			//validator.required('content',"请输入内容");
			
			if(validator.passed()){
				return true;
			}else{
				return false;
			}
		 }
		</script>
    </div>
	<?php endif;?>
    </div>


</body>

</html>
