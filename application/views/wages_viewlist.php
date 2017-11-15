<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo SITE_COMMON_STATIC; ?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITE_COMMON_STATIC; ?>/js/My97DatePicker/WdatePicker.js"></script>

</head>
<body>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="main.php">首页</a></li>
    <li><a href="#">工资管理</a></li>
    </ul>
    </div>
    
    <div class="rightinfo" style="width:4000px">
	
    <style>
	td { text-align:center}
	th { text-align:center}
	</style>
    <table class="tablelist" style="width:100%">

    	<thead id="nav">
    	<tr class="tableNav">
        <th style="text-align:center">编号
		<i class="sort"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/px.gif" /></i>
		</th>
		<th style="text-align:center">工资年月</th>
		<th style="text-align:center">姓名</th>
		<?php foreach ($columns as $k => $v){ ?>
		<?php if( isset($dyn[$k]['view'])&& $dyn[$k]['view']){ ?>
		<th style="text-align:center;" ><?php echo $v; ?></th>
		<?php }; ?>
		<?php }; ?>
        <th style="text-align:center">操作</th>
        </tr>
        </thead>
        
        <tbody>
        
        <?php foreach ($list as $v){ ?>
        <tr>
        <td>
		<input type="checkbox" name="checkbox[]" value="" style="width:20px">
		<?php echo $v['id']; ?>
		</td>
		<td><?php echo date('Y-m',strtotime(!empty($v['nianyue'])?$v['nianyue']:'')); ?></td>
		<td><?php echo $v['user_name']; ?></td>
            <?php foreach($v as $p=>$va){?>
                <?php if($p=='nianyue') continue;?>
                <?php if(in_array($p,$dyn2)){ ?>
                    <td><?php echo $v[$p]; ?></td>
                <?php }; ?>
            <?php }?>
       <td>
			<a href="/wageslist/view?id=<?php echo $v['id']; ?>" class="tablelink"  target="_blank">查看</a>
       　	<a href="/wageslist/edit?id=<?php echo $v['id']; ?>" class="tablelink">编辑</a>
       　	<a href="/wageslist/del?id=<?php echo $v['id']; ?>" class="tablelink"> 删除</a>
       </td>
       </tr> 
		<?php }; ?>
        

		</tbody>	
		
		 
		 
    </table>
	<table border="0" style="margin-top:10px">
	<tr>
	<td>
	</td></tr></table>
	<div style="width:1200px">
   <?php echo $page;?>
   </div> 
 
    </div>


</body>

</html>
<script type="text/javascript"> 
	
      $(function () {
	    	 /*  $(window).scroll(function() {
	  		    $offset = $('#nav').offset(); //不能用自身的div，不然滚动起来会很卡
	  		    if ($(window).scrollTop() > $offset.top) {
	  		        $('.tableNav').css({
	  		            'position': 'fixed',
	  		            'top': '0px',
	  		            'left': $offset.left + 'px',
	  		            'z-index': '999'
	  		        });
	  		    } else {
	  		        $('.tableNav').removeAttr('style');
	  		    }
	  		}); */
			$("input[name='time_from']").focus(function () {
				WdatePicker({
					skin: 'whyGreen',
					dateFmt: 'yyyy-MM'
					
				});
			});
			$("input[name='time_to']").focus(function () {
				WdatePicker({
					skin: 'whyGreen',
					dateFmt: 'yyyy-MM',
				});
			});
			
		});
    </script>