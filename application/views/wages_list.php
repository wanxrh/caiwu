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
    <li><a href="#">我的工资</a></li>
    </ul>
    </div>
    
    <div class="rightinfo" style="width:4000px">
	
	<div class="tools">
    
    	<form action="/wageslist/index" method="get">
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
        <?php if($level == -1){?>
        部门：
        <select  class="dfinput2" style="width:80px"  name="bumen_name">
            <option value="0">请选择</option>
            <?php foreach ($department as $k=>$v){ ?>
                <option <?php if($bumen_name == $v['bumen_name']) echo 'selected="true"'; ?> value="<?php echo $v['bumen_name']; ?>"><?php echo $v['bumen_name']; ?></option>
            <?php }; ?>
        </select>
		姓名：
		<input class="dfinput2" style="width:80px"  name="name" value="<?php echo $name;?>"/>
        <?php }?>
		<?php foreach ($dyn as $k=>$v){ ?>
		<?php if($level <0 && $v['admin_query']){ ?>
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
		<?php }elseif ($level >=0 && $v['normal_query']){ ?>
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

			
		<input type="button" class="btn" value="导出excel" onclick="window.location.href='<?php echo '/wageslist/wage_export?'.$_SERVER["QUERY_STRING"];?>'"/>
            <?php if($level == -1){?>
            <input type="button" id="dell_all"  class="btn" value="批量删除">
            <?php }?>
		
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
        <?php if($level == -1){?>
        <th>入库时间</th>
        <?php }?>
        <th style="text-align:center">
		<input type="checkbox" id="selectAll" onclick="checkAll()"/>编号
		<i class="sort"><img src="<?php echo SITE_COMMON_STATIC; ?>/images/px.gif" /></i>
		</th>
		<th style="text-align:center">工资年月</th>
		<th style="text-align:center">姓名</th>
		<th style="text-align:center">部门</th>
		<?php foreach ($columns as $k => $v){ ?>
		<?php if( isset($dyn[$k]['view'])&& $dyn[$k]['view']){ ?>
		<th style="text-align:center;" ><?php echo $v; ?></th>
		<?php }; ?>
		<?php }; ?>
        <th style="text-align:center">操作</th>
        </tr>
        </thead>
        
        <tbody>
        
        <?php foreach ($list as $k2=>$v){ ?>
        <tr>
        <?php if($level == -1){?>
        <td><?php echo date("Y-m-d",$v['add_time']); ?></td>
        <?php }?>
        <td>
		<input type="checkbox"  class="selectAll" name="ids[]" value="<?php echo $v['id']?>" style="width:20px">
		<?php echo $v['id']; ?>
		</td>
		<td><?php echo $v['nianyue']; ?></td>
		<td><?php echo $v['user_name']; ?></td>
		<td><?php echo $v['bumen_name']; ?></td>
        <?php foreach($v as $p=>$va){?>
            <?php if($p=='nianyue') continue;?>
            <?php if(in_array($p,$dyn2)){ ?>
                <td><?php echo $v[$p]; ?></td>
            <?php }; ?>
        <?php }?>

       <td>
			<a href="/wageslist/view?id=<?php echo $v['id']; ?>" class="tablelink"  target="_blank">查看</a>
           <?php if($level == -1){?>
       　	<a href="/wageslist/edit?id=<?php echo $v['id']; ?>" class="tablelink">编辑</a>
       　	<a href="/wageslist/del?id=<?php echo $v['id']; ?>" class="tablelink"onclick="return confirm('确定要删除吗？')"> 删除</a>
           <?php }?>
       </td>
       </tr> 
		<?php }; ?>
        

		</tbody>	
		<thead>
         <tr>
		 
		 <th>此页合计</th>
         <?php if($level == -1){?>
		 <th align="center">&nbsp;</th>
         <?php }?>
		 <th align="center">&nbsp;</th>
		 <th align="center">&nbsp;</th>
		 <th align="center">&nbsp;</th>
		 <?php foreach ($dyn_page as $v){ ?>
		 	<?php if($v){ ?>
		 	<th align="center" style="text-align: center;"><?php echo $v; ?></th>
		 	<?php }else{ ?>
		 	<th align="center">&nbsp;</th>
		 	<?php } ?>
		 <?php }; ?>
         <th align="center">&nbsp;</th>
		 </tr> 
		 </thead>
		 
		 
		 
		 <thead>
         <tr>
		 
		 <th>总合计</th>
         <?php if($level == -1){?>
           <th align="center">&nbsp;</th>
        <?php }?>
		<th align="center">&nbsp;</th>
		<th align="center">&nbsp;</th>
		<th align="center">&nbsp;</th>
		 <?php foreach ($dyn_all as $v){ ?>
		 	<?php if($v){ ?>
		 	<th align="center" style="text-align: center;"><?php echo $v; ?></th>
		 	<?php }else{ ?>
		 	<th align="center">&nbsp;</th>
		 	<?php } ?>
		 <?php }; ?>
         <th align="center">&nbsp;</th>
		 </tr> 
		 </thead>  
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
                      url: '/wageslist/delall',
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


		});
      function checkAll()
      {
          var checkedOfAll=$("#selectAll").attr("checked");
          $("input[name='ids[]']").attr("checked", checkedOfAll);
      }

    </script>