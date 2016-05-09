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
    <li><a href="news.php">留言</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    <?php if($user_info['cat_id']!='-1'):?>
    <div class="tools">
    	<ul class="toolbar">
        <li class="click"><span></span><a href="/message" <?php if($this->uri->segment(2)==''||$this->uri->segment(3)!='') echo 'style="color:red"';?>>留言列表</a></li>
		<li class="click"><span></span><a href="/message/add" <?php if($this->uri->segment(2)!=''&&$this->uri->segment(3)=='') echo 'style="color:red"';?>>添加留言</a></li>
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
		<th style="text-align:center"width="200px">标题</th>
		<th style="text-align:center">内容</th>
		<th style="text-align:center"width="200px">管理员回复</th>
		<th style="text-align:center" width="100px">添加时间</th>
		<?php if($user_info['cat_id']=='-1'):?>
		<th style="text-align:center" width="100px">操作</th>
		<?php endif;?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($message as $key=>$val):?>
        <tr>
        <td><?php echo $val['user_id'];?></td>
        <td><a href="/message/view/<?php echo $val['user_id'];?>" class="tablelink"><?php echo $val['title'];?></a></td>
		<td><?php echo $val['content'];?></td>
		<td><?php echo $val['content1'];?></td>
		<td><?php echo date("Y-m-d H:i:s",$val['add_time']);?></td>
		<?php if($user_info['cat_id']=='-1'):?>
       <td><a href="/message/edit/<?php echo $val['user_id'];?>" class="tablelink">查看/编辑</a>     <a href="/message/del/<?php echo $val['user_id'];?>" class="tablelink"> 删除</a></td>
       <?php endif;?>
        </tr>   
         <?php endforeach;?>   
        </tbody>
    </table>
    <?php echo $page;?>
    <?php elseif(($this->uri->segment(2)=='edit')):?>
	<div class="formbody">
    
    <div class="formtitle"><span>编辑信息</span></div>
    <form name="myform" action=""  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
	<input type="hidden" name="user_id" value="<?php echo $liuyan['user_id'];?>">
    <ul class="forminfo1">
	<li><label>标题</label><input type="text" name="title" class="dfinput" style="width:300px;color:#666666" value="<?php echo $liuyan['title'];?>" readonly="readonly"></li>
	<li><label>内容</label><textarea name="content" style="width:300px;height:100px; color:#666666" class="dfinput2" readonly="readonly"><?php echo $liuyan['content']?></textarea></li>
	<li><label>回复</label><textarea name="content1" style="width:300px;height:100px;" class="dfinput2"><?php echo $liuyan['content1']?></textarea></li>
	
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
    <?php elseif(($this->uri->segment(2)=='add')):?>
	<div class="formbody">
    
    <div class="formtitle"><span>添加留言</span></div>
    <form name="myform" action=""  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
	<input type="hidden" name="user_id" value="1">
    <ul class="forminfo1">
	<li><label>标题</label><input type="text" name="title" class="dfinput" style="width:300px;color:#666666" value=""></li>
	<li><label>内容</label><textarea name="content" style="width:300px;height:100px; color:#666666" class="dfinput2"></textarea></li>
	
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
	<?php elseif(($this->uri->segment(2)=='view')):?>
	<div class="formbody">
    <div class="formtitle"><span><?php echo $message_view['title'];?></span></div>
   <?php echo $message_view['content']?>
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
