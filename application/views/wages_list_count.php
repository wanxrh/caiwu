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
    <li><a href="#">工资合计</a></li>
    </ul>
    </div>
    
    <div class="rightinfo" style="width:4000px">
	
	<div class="tools">
    
    	<form action="/wageslist_count/index" method="get">
		时间区间：
		<input class="dfinput2" style="width:80px"  name="time_from" value="<?php echo $start;?>"/>
		---
		<input class="dfinput2" style="width:80px"  name="time_to" value="<?php echo $end;?>"/>
		工资类型：
		<select  class="dfinput2" style="width:80px"  name="gongzileixing">
		<option value="0">请选择</option>
		<?php foreach ($gongzi_type as $k=>$v){ ?>
		<option <?php if($gongzileixing == $v['gongzileixing_name']) echo 'selected="true"'; ?> <?php if($gongzileixing=='' && $k==3) echo 'selected="true"'; ?>  value="<?php echo $v['gongzileixing_name']; ?>"><?php echo $v['gongzileixing_name']; ?></option>
		<?php }; ?>
		</select>
        部门：
        <select  class="dfinput2" style="width:80px"  name="bumen_name">
            <option value="0">请选择</option>
            <?php foreach ($department as $k=>$v){ ?>
                <option <?php if($bumen_name == $v['bumen_name']) echo 'selected="true"'; ?> value="<?php echo $v['bumen_name']; ?>"><?php echo $v['bumen_name']; ?></option>
            <?php }; ?>
        </select>
        <?php if($level == -1){?>
            姓名：
            <input class="dfinput2" style="width:80px"  name="name" value="<?php echo $name;?>"/>
        <?php }?>
		<?php foreach ($dyn as $k=>$v){ ?>
		<?php if($level <0 && $v['summary']){ ?>
		<?php echo $columns[$v['column_name']].':'; ?>	
			<?php if($v['options']){ ?>
			<select  class="dfinput2" style="width:80px"  name="select[<?php echo $v['column_name']; ?>]">
			<option value="">请选择</option>
			<?php foreach (explode(',', $v['options']) as $option){ ?>
			<option <?php if($select[$v['column_name']]  == $option) echo 'selected="true"'; ?> value="<?php echo $option; ?>"><?php echo $option; ?></option>
			<?php }; ?>
			</select>	
			<?php }else{ ?>			
			<input class="dfinput2" style="width:80px"  name="input[<?php echo $v['column_name']; ?>]" value="<?php echo $input[$v['column_name']]; ?>" >	
			<?php }; ?>
		<?php }elseif ($level >=0 && $v['summary']){ ?>
         <?php echo $columns[$v['column_name']].':'; ?>
             <?php if($v['options']){ ?>
			<select  class="dfinput2" style="width:80px" name="select[<?php echo $v['column_name']; ?>]">
			<option value="">请选择</option>
			<?php foreach (explode(',', $v['options']) as $option){ ?>
			<option <?php if($select[$v['column_name']]  == $option) echo 'selected="true"'; ?> value="<?php echo $option; ?>"><?php echo $option; ?></option>
			<?php }; ?>
			</select>	
			<?php }else{ ?>
			<input class="dfinput2" style="width:80px"  name="input[<?php echo $v['column_name']; ?>]" value="<?php echo $input[$v['column_name']]; ?>" >
			<?php }; ?>
		<?php }; ?>

		<?php }; ?>
		<input type="submit" value="查询" class="btn">

			
		<input type="button" class="btn" value="导出工资合计excel" onclick="window.location.href='<?php echo '/wageslist_count/wage_export?'.$_SERVER["QUERY_STRING"];?>'"/>

		
		</form>
    
    </div>
	<!--
	<div class="tools"> 
    	<ul class="">
        <li class="">
		
		<input type="button" class="btn" value="导出excel" onclick="window.location.href='excel1.php?where=&gongzileixing='"/>
		<input type="button" id="btn2" class="btn" value="批量删除">
		<input type="button" id="btn2" class="btn" onclick="window.location.href='gongzi_list.php?where=&st=del_jieguo'" value=" 删除所有搜索结果">
		
		<b style="color:red; font-size:18px">
		
		</b>
		</li>
        </ul>     	
    </div>
    -->
    <style>
	td { text-align:center}
	th { text-align:center}
	</style>
    <table class="tablelist" style="width:100%">

    	<thead id="nav">
    	<tr class="tableNav">
        <th style="text-align:center">
		<input type="checkbox" id="btn1"/>编号
		<i class="sort"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/px.gif" /></i>
		</th>
		<!-- <th style="text-align:center">工资年月</th> -->
		<th style="text-align:center">姓名</th>
		<?php foreach ($columns as $k => $v){ ?>
		<?php if( isset($dyn[$k]['view'])&& $dyn[$k]['view']&&$dyn[$k]['column_name']!='zhiyuanCode'&&$dyn[$k]['column_name']!='zhiyuanleibie'&&$dyn[$k]['column_name']!='bumenCode'&&$dyn[$k]['column_name']!='zhiyuanzhuangtaig'&&$dyn[$k]['column_name']!='shenfenCard'&&$dyn[$k]['column_name']!='personalCard'){ ?>
		<th style="text-align:center;" ><?php echo $v; ?></th>
		<?php }; ?>
		<?php }; ?>
        <!-- th style="text-align:center">操作</th> -->
        </tr>
        </thead>
        
        <tbody>
        
        <?php foreach ($list as $v){ ?>
        <tr>
        <td>
		<input type="checkbox" name="checkbox[]" value="" style="width:20px">
		<?php echo $v['id']; ?>
		</td>
		<!-- <td><?php //echo $v['nianyue']; ?></td> -->
		<td><?php echo $v['user_name']; ?></td>
        <?php //foreach($dyn as $kk=>$vv){ ?>
        <?php //if($vv['view']&&$vv['column_name']!='zhiyuanCode'&&$vv['column_name']!='zhiyuanleibie'&&$vv['column_name']!='bumenCode'&&$vv['column_name']!='zhiyuanzhuangtaig'&&$vv['column_name']!='shenfenCard'&&$vv['column_name']!='personalCard'){  ?>
        <!--<td>--><?php //echo $v[$vv['column_name']]; ?><!--</td>-->
        <?php //}; ?>
        <?php //}; ?>
            <?php foreach($v as $p=>$va){?>
                <?php if($p=='nianyue' || $p=='zhiyuanCode'|| $p=='zhiyuanleibie'|| $p=='bumenCode'|| $p=='zhiyuanzhuangtaig'|| $p=='shenfenCard'|| $p=='personalCard') continue;?>
                <?php if(in_array($p,$dyn2)){ ?>
                    <td><?php echo $v[$p]; ?></td>
                <?php }; ?>
            <?php }?>
       </tr> 
		<?php }; ?>
        

		</tbody>	

		 
    </table>
	<table border="0" style="margin-top:10px">
	<tr>
	<td>
	</td></tr></table>
	<div style="width:1200px">
   <?php //echo $page;?>
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