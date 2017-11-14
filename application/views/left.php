<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>

<script type="text/javascript">
$(function(){
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active")
		$(this).addClass("active");
	});

	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
})
</script>


</head>

<body style="background:#f0f9fd;">
	<div class="lefttop"><span></span>菜单</div>

<dl class="leftmenu">
<?php if($this->session->userdata('cat_id')=='-1'):?>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png"/></span>数据表管理
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/wagesmanage" target="rightFrame">工资表管理</a><i></i></li>
        <li><cite></cite><a href="/user_information" target="rightFrame">用户信息表管理</a><i></i></li>
    </ul>
    </dd>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png"/></span>工资表导入导出
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/wages_management" target="rightFrame">工资表导出字段</a><i></i></li>
        <li><cite></cite><a href="/wages_management/export?flag=gongzi" target="rightFrame">工资表模板导出</a><i></i></li>
        <li><cite></cite><a href="/wages_management/import?flag=gongzi" target="rightFrame">工资表数据导入</a><i></i></li>
    </ul>
    </dd>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png"/></span>用户表导入导出
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/user_management" target="rightFrame">用户表导出字段</a><i></i></li>
        <li><cite></cite><a href="/user_management/export?flag=yonghu" target="rightFrame">用户表模板导出</a><i></i></li>
        <li><cite></cite><a href="/user_management/import?flag=yonghu" target="rightFrame">用户表数据导入</a><i></i></li>
    </ul>
    </dd>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png"/></span>工资管理
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/wageslist" target="rightFrame">工资列表</a><i></i></li>
        <li><cite></cite><a href="/wageslist_count" target="rightFrame">工资列表个人数据汇总</a><i></i></li>
    </ul>
    </dd>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png"/></span>工资类型管理
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/wage_type" target="rightFrame">工资类型管理</a><i></i></li>
    </ul>
    </dd>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico02.png"/></span>用户管理
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/user" target="rightFrame">用户管理</a><i></i></li>
        <li><cite></cite><a href="/department" target="rightFrame">部门管理</a><i></i></li>
        <li><cite></cite><a href="/user_category" target="rightFrame">用户类别管理</a><i></i></li>
    </ul>
    </dd>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png"/></span>系统信息
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/system_notice" target="rightFrame">系统公告</a><i></i></li>
        <li><cite></cite><a href="/message" target="rightFrame">留言</a><i></i></li>
    </ul>
    </dd>
    <dd>
    <div class="title">
    <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png" /></span>数据
    </div>
        <ul class="menuson">
        <li><cite></cite><a href="/database" target="rightFrame">备份数据</a><i></i></li>
        <li><cite></cite><a href="/database/restore" target="rightFrame">还原数据</a><i></i></li>
        </ul>
    </dd>
    <?php elseif($this->session->userdata('cat_id')=='9'):?>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png"/></span>我的工资
    </div>
    <ul class="menuson">
        <?php foreach($leixing as $key=>$val):?>
        <li><cite></cite><a href="/wageslist/index?&gongzileixing=<?php echo $val['gongzileixing_name'];?>" target="rightFrame"><?php echo $val['gongzileixing_name'];?></a><i></i></li>
        <?php endforeach;?>
    </ul>
    </dd>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico02.png"/></span>用户管理
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/user/info" target="rightFrame">个人信息</a><i></i></li>
        <li><cite></cite><a href="/get_password" target="rightFrame">修改密码</a><i></i></li>
    </ul>
    </dd>
    <dd>
    <div class="title">
        <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png"/></span>系统信息
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/system_notice" target="rightFrame">系统公告</a><i></i></li>
        <li><cite></cite><a href="/message" target="rightFrame">我的留言</a><i></i></li>
    </ul>
    </dd>
    <?php elseif($this->session->userdata('cat_id')=='10'||$this->session->userdata('cat_id')=='11'):?>
    <dd>
    <div class="title">
    <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png" /></span>数据导出字段选择
    </div>
        <ul class="menuson">
        <li><cite></cite><a href="/wages_management" target="rightFrame">工资表导出字段选择</a><i></i></li>
        <li><cite></cite><a href="/user_management" target="rightFrame">用户信息表导出字段选择</a><i></i></li>
        </ul>
    </dd>
    <dd>
    <div class="title">
    <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png" /></span>我的工资
    </div>
        <ul class="menuson">
        <li><cite></cite><a href="/wageslist" target="rightFrame">工资列表</a><i></i></li>
        <li><cite></cite><a href="/wageslist_count" target="rightFrame">工资列表个人数据汇总</a><i></i></li>
        </ul>
    </dd>
    <dd>
    <div class="title">
    <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico02.png" /></span>用户管理
    </div>
    <ul class="menuson">
        <li><cite></cite><a href="/get_password" target="rightFrame">修改密码</a><i></i></li>
        </ul>
    </dd>
    <dd>
    <div class="title">
    <span><img src="<?php echo SITE_COMMON_STATIC; ?>/images/leftico01.png" /></span>系统信息
    </div>
        <ul class="menuson">
        <li><cite></cite><a href="/system_notice" target="rightFrame">系统公告</a><i></i></li>
        <li><cite></cite><a href="/message" target="rightFrame">留言</a><i></i></li>
        </ul>
    </dd>
    <?php endif;?>
</dl>

</body>
</html>
