<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD>
  <meta name="renderer" content="ie-comp">
  <META content="IE=11.0000" http-equiv="X-UA-Compatible">
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
 <LINK href="<?php echo SITE_COMMON_STATIC; ?>/login/base.css" rel="stylesheet" type="text/css">
 <LINK href="<?php echo SITE_COMMON_STATIC; ?>/login/common.css" rel="stylesheet" type="text/css">
<SCRIPT src="<?php echo SITE_COMMON_STATIC; ?>/login/jquery-1.7.2.min.js" type="text/javascript"></SCRIPT>
<SCRIPT src="<?php echo SITE_COMMON_STATIC; ?>/login/Validform_v5.3.2_min.js" type="text/javascript"></SCRIPT>

<TITLE>个人工资查询中心</TITLE>
<META name="GENERATOR" content="MSHTML 11.00.9600.17690"></HEAD>
<BODY class="bgf2">
<DIV class="loginHead" style="height:100px;margin:auto">
<DIV class="main clearfix">
<DIV class="logo fl"><A href="<?php echo base_url();?>"><IMG src="<?php echo SITE_COMMON_STATIC; ?>/login/030.jpg" width="930px" border="0"></A></DIV>
<div style="font-size:20px"><?php echo date("Y年m月d日 H时i分s秒");?>&nbsp;&nbsp;&nbsp;&nbsp;总访问量:<?php echo $number;?>
</div>
<DIV class="loginBtnBar fr">
</DIV>
</DIV>
</DIV>
<!--loginHead End -->
<!--mainMin Star -->
<DIV class="mainMin" style="margin:auto">
<DIV class="userLogin">
<DIV class="userInfoLogin">
<H3 class="fz16">系统登陆</H3>
<FORM id="myform" action="/home/login" method="post" class="demoform" >

<DIV class="formInfo">

<DL class="clearfix">
  <DD class="user"><I class="icon"></I>
  <INPUT name="user_name" class="text inputxt" type="text" value="" placeholder="姓名/帐号">
            </DD></DL>
<DL class="clearfix">
  <DD class="password"><I class="icon"></I>
<INPUT name="password" class="text  inputxt" id="password" type="password"  value="" placeholder="密码" style="color:#999999">
            </DD></DL>
<DL class="clearfix">
  <DD class="password"><I class="icon"></I>
<INPUT name="code" class="text inputxt" style="width:70px;color:#999999" id="jcaptcha" type="text"  value="" placeholder="验证码">
<img  title="点击刷新" src="<?php base_url();?>/home/code"  align="absbottom" onClick="this.src='<?php base_url()?>/home/code?'+Math.random();" style="padding-top:5px; padding-left:10px"></img>

            </DD></DL>
<DL>
  <DIV class="saveUser clearfix">                        </DIV></DL>
<DL class="clearfix">
  <DD><INPUT class="text btn submit" id="submit_button" type="submit" value="立即登录">
                          </DD></DL>
</DIV>
</FORM>
<DIV class="login-three-home clearfix">
<H3><EM>快捷方式</EM></H3>
<img src="<?php echo SITE_COMMON_STATIC; ?>/login/001.jpg" width="115px" height="50px" border="0">
<img src="<?php echo SITE_COMMON_STATIC; ?>/login/002.jpg" width="115px" height="50px" border="0">
<img src="<?php echo SITE_COMMON_STATIC; ?>/login/003.jpg" width="115px" height="50px" border="0">
<!--
<A class="sina" href=""><I></I><SPAN>预算系统</SPAN></A>
<A class="qq m" href=""><I></I><SPAN>填报系统</SPAN></A>
<A class="weixin" onClick="return false;" href=""><I></I><SPAN>管理后台</SPAN></A>
-->
</DIV></DIV></FORM></DIV></DIV></DIV>

<DIV style="margin-bottom: 50px;"></DIV><!--footer Star -->
<DIV id="footer">
<DIV class="main">
<P>广西电力职业技术学院--财务综合管理系统--个人工资查询平台--绩效工资填报系统--预算查询系统</P>
<P>CopyRight 2015-2020 gxdlxy All Rights Reserved. 财务处 版权所有</P>
</DIV>
</DIV><!--footer End -->
<script type="text/javascript">

$(function(){
  var code='';
  //$(".demoform").Validform();  //就这一行代码！;

  var demo=$(".demoform").Validform({
    tiptype:3,
    label:".label",
    showAllError:true,
    datatype:{
      "zh1-6":/^[\u4E00-\u9FA5\uf900-\ufa2d]{1,6}$/
    },
    ajaxPost:false
  });
    //通过$.Tipmsg扩展默认提示信息;
  //$.Tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
  demo.tipmsg.w["zh1-6"]="请输入1到6个中文字符！";

  demo.addRule([{
    ele:".inputxt:eq(0)",
    datatype:"s2-6"
  },
  {
    ele:".inputxt:eq(1)",
    datatype:"*3-15",
    errormsg:"密码在3~15位之间!"
  },
  {
    ele:".inputxt:eq(2)",
    datatype:"s",
    nullmsg:"请填写验证码,不区分大小写",
    ajaxurl:"<?php base_url();?>/home/Validcode",
  },
  {
    ele:"select",
    datatype:"*"
  }]);

})
</script>
</BODY></HTML>

