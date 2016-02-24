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
        <form action="/user" method="post">
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
        <?php if($this->cur_page==''){$i=1;}?>
        <?php $i=($this->cur_page-1)*$this->per_page+1;?>
        <?php foreach($user as $key=>$val):?>
        <tr>
        <td align="center"><?php echo $i;?></td>
        <td align="center"><?php echo $val['user_name'];?></td>
        <td align="center"><?php echo $val['password'];?></td>
        <td align="center"><?php echo $val['name'];?></td>
        <td align="center"><?php echo $val['bumen_name'];?></td>
        <td align="center"><?php echo $val['cat_name'];?></td>
        <td align="center"><a href="" class="tablelink">添加工资记录</a>　<a href="" class="tablelink">查看工资记录</a></td>
        <td align="center"><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink"> 删除</a></td>
        </tr>
        <?php $i++;?>
        <?php endforeach;?>
        </tbody>
    </table>



    <?php echo $page;?>
    <?php elseif(($this->uri->uri_string()=='user/add_user')):?>
    <div class="formbody">

    <div class="formtitle"><span>添加用户</span></div>
    <form name="myform" action="add_user"  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
    <input type="hidden" name="bumen_id" id="bumen_id">
    <ul class="forminfo">
    <li>
        <span><label>用户类别：</label>
        <select name="cat_id" class="dfinput2">
        <option value="">--请选择--</option>
        <?php foreach($type as $k=>$val):?>
        <option value="<?php echo $val['cat_id'];?>"><?php echo $val['cat_name'];?></option>
        <?php endforeach;?>
        </select>
        </span>

        <?php $i=2;?>
        <?php foreach($rescolumns as $key=>$value):?>
        <?php if($value['Field']=='bumendaima'):?>
        <?php continue;?>
        <?php endif;?>
        <?php if($value['Field']=='bumen_name'):?>
        <span>
            <label><?php echo $value['Comment'];?>：</label>
            <select name="<?php echo $value['Field']?>" id="bumen_name" class="dfinput2" onchange="$('#bumen_id').val($('#bumen_name').val())">
            <option value="">--请选择--</option>
            <?php foreach($department as $kk=>$vv):?>
            <option value="<?php echo $vv['bumen_id']?>"><?php echo $vv['bumen_name']?></option>
            <?php endforeach;?>
            </select>
        </span>
        <?php else:?>
        <span><label><?php echo $value['Comment']?>：</label><input type="text" name="<?php echo $value['Field']?>" class="dfinput" style="width:200px"></span>

        <?php endif;?>
        <?php if($i%3==0):?>
        <?php echo "</li><li>";?>
        <?php endif;?>
        <?php $i++;?>
        <?php endforeach;?>
    </li>


    <li><label>&nbsp;</label><input type="submit" class="btn" value="确定" /></li>
    </ul>
    </form>
        <script>
        function validate()
        {
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

    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>
