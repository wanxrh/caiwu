function enable_account(id,username,url){
	if(!window.confirm("确认审核交易账号"+username+"么?")){
		   return;
	}
	audit_account(id,url,'确认帐号',2);
}
function disable_account(id,username,url){
	if(!window.confirm("确认否决核交易账号"+username+"账号么?")){
		   return;
	}
	audit_account(id,url,'否决帐号',-1);
}

function enable_member(id,username,url){
	if(!window.confirm("确认启用会员"+username+"账号么?")){
		   return;
	}
	audit_member(id,url,'启用会员',1);
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
	if(!window.confirm("确认该"+text+"审核通过么?")){
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



function audit_account(id,url,text,status){
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
				$("#area_status_" + id).html('<div align="center" style="color:red">否决</div>');
			else
				$("#area_status_" + id).html('<div align="center">已确认</div>');
		} else {
			alert(text + "失败");
		}
	}
	});
}