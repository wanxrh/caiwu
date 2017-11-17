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
        <li><span></span><a href="/user" <?php if($this->uri->segment(2)==''||$this->uri->segment(3)!='') echo 'style="color:red"';?>>用户列表</a></li>
        <li><span></span><a href="/user/add_user" <?php if($this->uri->segment(2)!=''&&$this->uri->segment(3)=='') echo 'style="color:red"';?>>添加用户</a></li>
        </ul>

    </div>
    <?php endif;?>
    <?php if($this->uri->segment(2)=='' || $this->uri->segment(2)=='index'):?>
    <div class="tools">
        <form action="/user" method="get">
            部门：
        <select name="bumen" id="bumen" class="dfinput2" style="width:80px">
            <option value="">请选择</option>
            <?php foreach($department as $value):?>
            <option value="<?php echo $value['bumen_name']?>" <?php echo $this->input->get('bumen')==$value['bumen_name']?'selected':'';?> ><?php echo $value['bumen_name']?></option>
            <?php endforeach;?>
        </select>
        职员类型：
        <select name="zhiyuanleixingmingcheng" id="zhiyuanleixingmingcheng" class="dfinput2" style="width:80px">
            <option value="">请选择</option>
            <option value="短聘" <?php echo $this->input->get('zhiyuanleixingmingcheng')=='短聘'?'selected':'';?>>短聘</option>
            <option value="在编" <?php echo $this->input->get('zhiyuanleixingmingcheng')=='在编'?'selected':'';?>>在编</option>
            <option value="外聘" <?php echo $this->input->get('zhiyuanleixingmingcheng')=='外聘'?'selected':'';?>>外聘</option>
            <option value="返聘" <?php echo $this->input->get('zhiyuanleixingmingcheng')=='返聘'?'selected':'';?>>返聘</option>
            <option value="退休" <?php echo $this->input->get('zhiyuanleixingmingcheng')=='退休'?'selected':'';?>>退休</option>
        </select>
        职员类别：
            <select name="leibiemingcheng" id="leibiemingcheng" class="dfinput2" style="width:80px">
                <option value="">请选择</option>
                <option value="短返教师" <?php echo $this->input->get('leibiemingcheng')=='短返教师'?'selected':'';?>>短返教师</option>
                <option value="行政人员" <?php echo $this->input->get('leibiemingcheng')=='行政人员'?'selected':'';?>>行政人员</option>
                <option value="教学行政" <?php echo $this->input->get('leibiemingcheng')=='教学行政'?'selected':'';?>>教学行政</option>
                <option value="临时聘用" <?php echo $this->input->get('leibiemingcheng')=='临时聘用'?'selected':'';?>>临时聘用</option>
                <option value="专职教师" <?php echo $this->input->get('leibiemingcheng')=='专职教师'?'selected':'';?>>专职教师</option>
                <option value="退休" <?php echo $this->input->get('leibiemingcheng')=='退休'?'selected':'';?>>退休</option>
            </select>
        职员状态：<input type="text" name="zhiyuanzhuangtai" id="zhiyuanzhuangtai" class="dfinput" style="width:80px" value="<?php echo $this->input->get('zhiyuanzhuangtai')?$this->input->get('zhiyuanzhuangtai'):'';?>">
        姓名：<input type="text" name="name" id="name" class="dfinput" style="width:80px" value="<?php echo $this->input->get('name')?$this->input->get('name'):'';?>">
        <input type="submit" value="搜索" class="btn">
        &nbsp;
        <input type="button" class="btn" value="导出excel" onclick="window.location.href='<?php echo '/user/wage_export?'.$_SERVER["QUERY_STRING"];?>'"/>
        <input type="button" id="dell_all"  class="btn" value="批量删除">
        </form>

    </div>
    <table class="tablelist">
    	<thead>
    	<tr>
        <th style="text-align:center"><input type="checkbox" id="selectAll" onclick="checkAll()"/> 编号<i class="sort"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/px.gif" /></i></th>
        <th style="text-align:center">帐号</th>
        <th style="text-align:center">密码</th>
        <th style="text-align:center">姓名</th>
        <th style="text-align:center">部门</th>
        <th style="text-align:center">用户类别</th>
        <th style="text-align:center">职员状态</th>
        <th style="text-align:center">职员类别</th>
        <th style="text-align:center">职员类型</th>
        <th style="text-align:center">工资记录</th>
        <th style="text-align:center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($this->cur_page==''){$i=1;}?>
        <?php $i=($this->cur_page-1)*$this->per_page+1;?>
        <?php foreach($user as $key=>$val):?>
        <tr>
        <td align="center"><input type="checkbox"  class="selectAll" name="ids[]" value="<?php echo $val['user_id']?>" style="width:20px"><?php echo $i;?></td>
        <td align="center"><?php echo $val['user_name'];?></td>
        <td align="center"><?php echo $val['password'];?></td>
        <td align="center"><?php echo $val['name'];?></td>
        <td align="center"><?php echo $val['bumen_name'];?></td>
        <td align="center"><?php echo $val['cat_name'];?></td>
        <td align="center"><?php echo $val['zhiyuanzhuangtai'];?></td>
        <td align="center"><?php echo $val['leibiemingcheng'];?></td>
        <td align="center"><?php echo $val['zhiyuanleixingmingcheng'];?></td>
        <td align="center"><a href="/wageslist/add?id=<?php echo $val['user_id'];?>" class="tablelink">添加工资记录</a>　<a href="/wageslist/viewlist?id=<?php echo $val['user_id'];?>" class="tablelink">查看工资记录</a></td>
        <td align="center"><?php if($user_info['cat_id']==-1):?><a href="/user/edit_user/<?php echo $val['user_id'];?>" class="tablelink">查看/编辑</a><?php else:?><a href="#" class="tablelink">查看</a><?php endif;?>     <a href="/user/remove_user/<?php echo $val['user_id'];?>" class="tablelink"onclick="return confirm('确定要删除吗？')"> 删除</a></td>
        </tr>
        <?php $i++;?>
        <?php endforeach;?>
        </tbody>
    </table>



    <?php echo $page;?>
    <script type="text/javascript">
        $(function () {
            $("#dell_all").click(function(){
                //var id = '';
                var ids = '';
                $(".selectAll").each(function(){
                    //$("input[name='ids']:checkbox").each(function(){
                    if (true == $(this).attr("checked")) {
                        ids += $(this).attr('value')+',';
                    }

                });
                var ids =  ids.substr(0,ids.length-1);
                if(ids == ''){
                    alert('不能为空');return false;
                }
                var flg = confirm('确定要删除吗？');
                if(flg){
                    $.ajax({
                        type: 'POST',
                        url: '/user/delall',
                        data: {'ids':ids},
                        dataType: 'json',
                        success: function (json) {
                            if (json.info == 'ok') {
                                alert('删除成功');
                                location.reload();
                            } else {
                                alert('删除失败');
                            }
                        },
                        error: function () {
                            alert('出错了');
                        }
                    });
                }

            })
        })
        function checkAll()
        {
            var checkedOfAll=$("#selectAll").attr("checked");
            $("input[name='ids[]']").attr("checked", checkedOfAll);
        }
    </script>
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
    <?php elseif(($this->uri->segment(2)=='edit_user')):?>
        <div class="formbody">

        <div class="formtitle"><span>编辑用户</span></div>
        <form name="myform" action="/user/edit_user/<?php echo $this->uri->segment(3);?>"  method="post"  enctype="multipart/form-data" onsubmit="return validate();">
        <ul class="forminfo">
        <li>
            <span><label>用户类别：</label>
            <select name="cat_id" class="dfinput2">
            <option value="">--请选择--</option>
            <?php foreach($type as $k=>$val):?>
            <option value="<?php echo $val['cat_id'];?>"  <?php if($user['cat_id']==$val['cat_id']) echo "selected=selected";?>><?php echo $val['cat_name'];?></option>
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
                <select name="bumen_name" id="bumen_name" class="dfinput2" onchange="$('#bumen_id').val($('#bumen_name').val())">
                <option value="">--请选择--</option>
                <?php foreach($department as $kk=>$vv):?>
                <option value="<?php echo $vv['bumen_name']?>" <?php if($user['bumen_name']==$vv['bumen_name']) echo "selected=selected";?>><?php echo $vv['bumen_name']?></option>
                <?php endforeach;?>
                </select>
            </span>
            <?php else:?>
            <span><label><?php echo $value['Comment']?>：</label><input type="text" name="<?php echo $value['Field']?>" value="<?php echo $user["{$value['Field']}"]?>" class="dfinput" style="width:200px" <?php if($value['Field']=='user_name') echo "disabled='disabled'";?>></span>

            <?php endif;?>
            <?php if($i%3==0):?>
            <?php echo "</li><li>";?>
            <?php endif;?>
            <?php $i++;?>
            <?php endforeach;?>
        </li>

        <?php if($user_info['cat_id']==-1):?>
        <li><label>&nbsp;</label><input type="submit" class="btn" value="确定" /></li>
        <?php endif;?>
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
