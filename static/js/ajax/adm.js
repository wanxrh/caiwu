function del_resume(id,url){
	/*if(!window.confirm("确认删除该简历么?")){
		   return;
	}*/
	del(id,url,'简历');
}
function audit_resume(id,userid,username,url){
	//if(!window.confirm("确认该简历审核通过么,此操作会同时给用户增加相应积分?")){
	//	   return;
	//}
	audit(id,userid,username,url,'简历');
}
function del_recruit(id,url){
	del(id,url,'招聘信息');
}
function audit_recruit(id,userid,username,url){
	audit(id,userid,username,url,'招聘信息');
}
function del_comment(id,url){
	del(id,url,'公司评价');
}
function audit_comment(id,userid,username,url){
	audit(id,userid,username,url,'公司评价');
}
function del_salary(id,url){
	del(id,url,'薪酬评价');
}
function audit_salary(id,userid,username,url){
	audit(id,userid,username,url,'薪酬评价');
}
function del_interview(id,url){
	del(id,url,'面试调查');
}
function audit_interview(id,userid,username,url){
	audit(id,userid,username,url,'面试调查');
}
function del_photo(id,url){
	del(id,url,'上传照片');
}
function audit_photo(id,userid,username,url){
	audit(id,userid,username,url,'上传照片');
}



function enable_member(id,username,url){
	if(!window.confirm("确认启用会员"+username+"账号么?")){
		   return;
	}
	audit_member(id,url,'启用会员',2);
}
function disable_member(id,username,url){
	if(!window.confirm("确认禁用会员"+username+"账号么?")){
		   return;
	}
	audit_member(id,url,'禁用会员',-1);
}



function del_member(id,username,url){
	if(!window.confirm("确认删除会员"+username+"么?")){
		   return;
	}
	$.ajax( {
		url : url,
		type : 'POST',
		dataType : 'text',
		data : {
			"id" : id,
		},
		timeout : 5000,
		error : function() {
			//alert('装载数据失败！');
	},
	onerror : "错误",
	success : function(data) {
		if (data) {
			alert("删除用户" + username + "成功");
			$("#area_tr_" + id).remove();
		} else {
			alert("删除用户" + username + "失败");
		}
	}
	});
}

function del(id,url,text){
	if(!window.confirm("确认删除该"+text+"信息么?")){
		   return;
	}
	$.ajax( {
		url : url,
		type : 'POST',
		dataType : 'text',
		data : {
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

function audit(id,userid,username,url,text){
	if(!window.confirm("确认该"+text+"审核通过么,此操作会同时给用户增加相应积分?")){
		   return;
	}
	$.ajax( {
		url : url,
		type : 'POST',
		dataType : 'text',
		data : {
			"audid" : id,
			"userid" : userid,
			"username" : username
		},
		timeout : 5000,
		error : function() {
			alert('装载数据失败！');
	},
	onerror : "错误",
	success : function(data) {
		if (data) {
			alert("审核" + text + "成功");
			$("#area_status_" + id).html('<div align="center">已审核</div>');
		} else {
			alert("审核" + text + "失败");
		}
	}
	});
}


function audit_member(id,url,text,status){
	$.ajax( {
		url : url,
		type : 'POST',
		dataType : 'text',
		data : {
			"id" : id,
			"status" : status
		},
		timeout : 5000,
		error : function() {
			alert('装载数据失败！');
	},
	onerror : "错误",
	success : function(data) {
		if (data) {
			alert(text + "成功");
			if(status==-1)
				$("#area_status_" + id).html('<div align="center" style="color:red">禁用</div>');
			else
				$("#area_status_" + id).html('<div align="center">正常</div>');
		} else {
			alert(text + "失败");
		}
	}
	});
}