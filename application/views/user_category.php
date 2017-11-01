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
    <li><a href="#">部门管理</a></li>
    </ul>
    </div>

    <div class="rightinfo">
    <div class="tools">

    	<ul class="toolbar">
        <li class="click"><span></span><a href="/user_category"  <?php if($this->uri->segment(2)==''||$this->uri->segment(3)!='') echo 'style="color:red"';?>>类别列表</a></li>
		<li class="click"><span></span><a href="/user_category/add"  <?php if($this->uri->segment(2)!=''&&$this->uri->segment(3)=='') echo 'style="color:red"';?>>添加类别</a></li>
        </ul>

    </div>
    <style>
	td { text-align:center}
	th { text-align:center}
	</style>
	<?php if($this->uri->segment(2)=='index'||$this->uri->segment(2)==''):?>
    <table class="tablelist" style="width:50%">
    	<thead>
    	<tr>
        <th style="text-align:center"><!--<input type="checkbox" id="btn1"/> -->编号<i class="sort"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/px.gif" /></i></th>
		<th style="text-align:center">类别名称</th>
        <th style="text-align:center">操作</th>
        </tr>
        </thead>
        <tbody>

		<?php foreach($user_category as $key=>$val):?>
        <tr>
        <td><?php echo $val['cat_id']?></td>
        <td><?php echo $val['cat_name']?></td>
       	<td><a href="/user_category/edit/<?php echo $val['cat_id']?>" class="tablelink">查看/编辑</a>     <a href="/user_category/del/<?php echo $val['cat_id']?>" class="tablelink"onclick="return confirm('确定要删除吗？')"> 删除</a></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <?php echo $page;?>
	<?php elseif(($this->uri->uri_string()=='user_category/add')):?>
   <div class="formbody">

    <div class="formtitle"><span>添加类别</span></div>
    <form name="myform" action="#"  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
    <ul class="forminfo">
	<li><label>类别名称</label><input type="text" name="cat_name" class="dfinput" style="width:300px"></li>

    <li><label>&nbsp;</label><input type="submit" class="btn" value="确定" /></li>
    </ul>
    </form>
    	<script>
	function validate()
	{
		//alert($('#user_name').val());
		var validator = new Validator('myform');
		//validator.isNullOption('cat_id','请选择角色');required
		validator.required('bumen_name',"请输入部门名称");
		//validator.required('content',"请输入内容");

		if(validator.passed()){
			return true;
		}else{
			return false;
		}
	 }
	</script>
    </div>
	<?php elseif($this->uri->segment(2)=='edit'):?>
	<div class="formbody">

    <div class="formtitle"><span>添加部门</span></div>
    <form name="myform" action="#"  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
    <ul class="forminfo">
	<li><label>类别名称</label><input type="text" name="cat_name" class="dfinput" style="width:300px" value="<?php echo $one['cat_name'];?>"></li>


    <li><label>&nbsp;</label><input type="submit" class="btn" value="确定" /></li>
    </ul>
    </form>
    	<script>
	function validate()
	{
		//alert($('#user_name').val());
		var validator = new Validator('myform');
		//validator.isNullOption('cat_id','请选择角色');required
		validator.required('bumen_name',"请输入部门名称");
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
