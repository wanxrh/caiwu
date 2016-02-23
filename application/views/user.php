<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>

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
    <li><a href="#">用户管理</a></li>
    </ul>
    </div>

    <div class="rightinfo">
    <?php if($this->uri->segment(1)=='user'):?>
    <div class="tools">

        <ul class="toolbar">
        <li><span></span><a href="/user" <?php if($this->uri->segment(2)=='') echo 'style="color:red"';?>>用户列表</a></li>
        <li><span></span><a href="/user/add_user" <?php if($this->uri->segment(2)!='') echo 'style="color:red"';?>>添加用户</a></li>
        </ul>

    </div>
    <?php endif;?>
    <?php if($this->uri->segment(2)==''):?>
    <div class="tools">
        <form action="?act=list" method="post">
            部门：
        <select name="bumen" id="bumen" class="dfinput2" style="width:80px">
            <option value="">请选择</option>
            <?php foreach($department as $value):?>
            <option value="" ><?php echo $value['bumen_name']?></option>
            <?php endforeach;?>
            </select>
        姓名：<input type="text" name="name" id="name" class="dfinput" style="width:80px" value="">
        <input type="submit" value="搜索" class="btn">
        &nbsp;
        <input type="button" class="btn" value="导出所有excel"/>
        </form>

    </div>
    <table class="tablelist">
    	<thead>
    	<tr>
        <th style="text-align:center"><!--<input type="checkbox" id="btn1"/> -->编号<i class="sort"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/px.gif" /></i></th>
        <th style="text-align:center">帐号</th>
        <th style="text-align:center">密码</th>
        <th style="text-align:center">姓名</th>
        <th style="text-align:center">部门</th>
        <th style="text-align:center">用户类别</th>
        <th style="text-align:center">工资记录</th>
        <th style="text-align:center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($user as $key=>$val):?>
        <tr>
        <td align="center"><?php echo $val['user_id'];?></td>
        <td align="center"><?php echo $val['user_name'];?></td>
        <td align="center"><?php echo $val['password'];?></td>
        <td align="center"><?php echo $val['name'];?></td>
        <td align="center"><?php echo $val['bumen_name'];?></td>
        <td align="center"><?php echo $val['cat_name'];?></td>
        <td align="center"><a href="" class="tablelink">添加工资记录</a>　<a href="" class="tablelink">查看工资记录</a></td>
        <td align="center"><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink"> 删除</a></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>



    <?php echo $page;?>
    <?php elseif(($this->uri->uri_string()=='user/add_user')):?>
    <div class="formbody">

    <div class="formtitle"><span>添加用户</span></div>
    <form name="myform" action="?act=add_1"  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
    <input type="hidden" name="bumen_id" id="bumen_id">
    <ul class="forminfo">
    <li>
        <span><label>用户类别：</label>
        <select name="cat_id" class="dfinput2">
        <option value="">--请选择--</option>
        <option value=""></option>
        </select>
        </span>
    </li>


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


    <div class="tip">
    	<div class="tiptop"><span>提示信息</span><a></a></div>

      <div class="tipinfo">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>

        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>

    </div>




    </div>

    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>
