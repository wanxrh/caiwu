<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<LINK href="<?php echo SITE_COMMON_STATIC; ?>/login/common.css" rel="stylesheet" type="text/css">
<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />
<SCRIPT src="<?php echo SITE_COMMON_STATIC; ?>/login/jquery-1.7.2.min.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo SITE_COMMON_STATIC; ?>/login/Validform_v5.3.2_min.js" type="text/javascript"></SCRIPT>
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
    <li><a href="#">编辑个人信息</a></li>
    </ul>
    </div>
    <div class="rightinfo">
    <div class="formbody">

    <div class="formtitle"><span>修改密码</span></div>
    <form name="myform" action="/get_password/edit_password"  method="post" class="myform">
    <div class="formInfo" style="padding: 0px 0 0px 0px;">

    <dl class="clearfix"><label>原密码</label>
    <dd class="password"><I class="icon"></I>
      <INPUT name="password1" class="text " type="password" value="" style="color:#999999;width:200px">
      </dd>
    </dl>
    <dl class="clearfix"><br><label>新密码</label>
      <dd class="password"><I class="icon"></I>
      <INPUT name="password2" class="text inputxt" type="password" style="color:#999999;width:200px">
                </dd>
    </dl>
    <dl class="clearfix"><br><label>确认新密码</label>
      <dd class="password"><I class="icon"></I>
      <INPUT name="password3" class="text inputxt" type="password" style="color:#999999;width:200px">
                </dd>
    </dl>
    <dl class="clearfix"><br>
      <dd class="password"><I class="icon"></I>
    <input name="" type="submit" class="btn" value="确认保存"  style="cursor:pointer"/>
    </dl>
    </div>
    </form>

    </div>





    </div>

    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>
<script type="text/javascript">

$(function(){
  var code='';
  //$(".demoform").Validform();  //就这一行代码！;

  var demo=$(".myform").Validform({
    tiptype:3,
    label:".label",
    showAllError:true,
    datatype:{
      "zh1-6":/^[\u4E00-\u9FA5\uf900-\ufa2d]{1,6}$/
    },
    ajaxPost:false
  });

  demo.addRule([{
        ele:".inputxt:eq(0)",
        datatype:"*6-16",
        nullmsg:"请输入新密码！",
        errormsg:"密码范围在6~16位之间！"
    },{
        ele:".inputxt:eq(1)",
        datatype:"*6-16",
        nullmsg:"请再次输入密码！",
        recheck:"password2"
    }]);

})
</script>
</body>

</html>
