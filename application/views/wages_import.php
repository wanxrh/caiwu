<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>无标题文档</title>

<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/validator.js"></script><!--表单验证js-->
<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/utils.js"></script><!--表单验证js-->
</head>


<body>
<?php if(($this->uri->segment(2)=='import')):?>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="/">首页</a></li>
    <li><a href="#">数据导入</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>导入工资模板</span></div>

	<div style="font-size:16px; margin-bottom:20px">要求必须以<b style="color:red">xls</b>结尾的EXCEL文件!</div>
    <form name="myform" action="/wages_management/import"  method="post" ENCTYPE="multipart/form-data" onsubmit="return validate()">
	<input type="hidden" name="1" value="2">
	<input type="hidden" name="id" value="">
    <ul class="forminfo">
    <li><label style="width:150px">请选择要导入的EXCEL</label> <input name="MyFile" type="file"  > </li>
    <li><label>&nbsp;</label><input type="button" class="btn" value="确定导入" onclick="validate()"/></li>
    </ul>
    </form>
<?php endif;?>
 <script>
function validate()
{
	var validator = new Validator('myform');
	validator.required('MyFile', "请选择上传的excel");
 if(validator.passed()&&confirm("确定导入吗？")) myform.submit();
 }
</script>	
</body>



</html>

