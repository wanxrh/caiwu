
		$(function(){
			$("#btn1").click(function(){ 
				if(this.checked){ 
				$("input[name='checkbox[]']").each(function(){this.checked=true;}); 
				}else{ 
				$("input[name='checkbox[]']").each(function(){this.checked=false;}); 
				} 
			})
			
			$("#btn2").click(function(){ 
				var str="";
    			$("input[type='checkbox'][name='checkbox[]']:checked").each(function(){
     			 str = str+$(this).val()+',';
      			
    			})
				 if(str.replace(',','')==''){ alert("请选择序号");}
				 else shanchu(str);
			})
			
			
		});
		
		
		function shanchu(str)
		{
			$.post("js/ajax.php?act=shanchu",{str : str},
			function(data,status){
				if(data=='0'){ alert('操作失败'); return false;}else if((data=='1')){ alert("删除成功"); history.go(0);}
			  //alert("数据：" + data + "\n状态：" + status);
			});
		}
		
		function zhengshikehu()
		{
			var str="";
			$("input[type='checkbox'][name='checkbox[]']:checked").each(function(){
			 str = str+$(this).val()+',';
			
			})
			if(str.replace(',','')==''){ alert("请选择序号");}
			else{
				//alert(str);
				var id=$('#user_id').val();
				$.post("js/ajax.php?act=zhengshikehu",{str:str,id:id},
				function(data,status){
					//alert(data);
					if(!data){ alert('操作失败'); return false;}
					else if((data)){ window.parent.frames.leftFrame.location.reload(); alert("操作成功"); history.go(0);}
				  //alert("数据：" + data + "\n状态：" + status);
				   window.location.reload();
				});
			}
		}
		function zhengshikehu_xiaoshouzhongxin()
		{
			var str="";
			$("input[type='checkbox'][name='checkbox[]']:checked").each(function(){
			 str = str+$(this).val()+',';
			
			})
			if(str.replace(',','')==''){ alert("请选择序号");}
			else{
				//alert(str);
				var id=$('#user_id').val();
				$.post("js/ajax.php?act=zhengshikehu_xiaoshouzhongxin",{str:str,id:id},
				function(data,status){
					//alert(data);
					if(!data){ alert('操作失败'); return false;}
					else if((data=='购物券不足！')){ alert("购物券不足！"); return false;}
					else if((data=='1')){  alert("操作成功"); window.parent.frames.leftFrame.location.reload(); history.go(0)}
					
				  //alert("数据：" + data + "\n状态：" + status);
				   window.location.reload();
				});
			}
		}
		function xiaoshouzhongxin()
		{
			var str="";
			$("input[type='checkbox'][name='checkbox[]']:checked").each(function(){
			 str = str+$(this).val()+',';
			
			})
			if(str.replace(',','')==''){ alert("请选择序号");}
			else{
				//alert(str);
				var id=$('#user_id').val();
				$.post("js/ajax.php?act=xiaoshouzhongxin",{str:str,id:id},
				function(data,status){
					//alert(data);
					if(!data){ alert('操作失败'); return false;}else if((data)){ alert("操作成功"); history.go(0);}
				  //alert("数据：" + data + "\n状态：" + status);
				   window.location.reload();
				});
			}
		}
		function querentixian()
		{
			var str="";
			$("input[type='checkbox'][name='checkbox[]']:checked").each(function(){
			 str = str+$(this).val()+',';
			
			})
			if(str.replace(',','')==''){ alert("请选择序号");}
			else{
				//alert(str);
				//var id=$('#user_id').val();
				$.post("js/ajax.php?act=querentixian",{str:str},
				function(data,status){
					//alert(data);
					if(!data){ alert('操作失败'); return false;}else if((data)){ alert("操作成功"); history.go(0);}
				  //alert("数据：" + data + "\n状态：" + status);
				   window.location.reload();
				});
			}
		}