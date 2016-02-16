function del_resume(userid,id,url){
	del(userid,id,url,'简历');
}
function del_article(userid,id,url){
	del(userid,id,url,'文章');
}


function del_salary(userid,id,url){
	del(userid,id,url,'薪酬调查');
}
function del_comment(userid,id,url){
	del(userid,id,url,'评论');
}
function del_interview(userid,id,url){
	del(userid,id,url,'面试');
}
function del_photo(userid,id,url){
	del(userid,id,url,'相片');
}


function del_feedback(userid,id,url){
	del(userid,id,url,'留言');
}





function del(userid,id,url,text){
	if(!window.confirm("确认删除该"+text+"么?")){
		   return;
	}
	$.ajax( {
		url : url,
		type : 'POST',
		dataType : 'text',
		data : {
		    "userid":userid,
			"delid" : id
		},
		timeout : 5000,
		error : function() {
			alert('装载数据失败！');
	},
	onerror : "错误",
	success : function(data) {
		if (data) {
			alert("删除" + text + "成功");
			$("#area_tr_" + id).remove();
		} else {
			alert("删除" + text + "失败");
		}
	}

	});
}


