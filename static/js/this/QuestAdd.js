function SubQuestion(){
    if(document.form1.Question_content.value.length==0){
	alert("请输入完整的问题内容");
	document.form1.Question_content.focus();
	return false;
	}else{	
	var Answer=document.form1.Answer[0].value.replace(/&/g,""); 
	var Answer_2=document.form1.Answer; 
	var result=0; 
	//var Answer=document.form1.Answer; 
	//alert(Answer.length);
	for(var i=1;i<Answer_2.length;i++){
	var Answer_g=document.form1.Answer[i].value.replace(/&/g,"");
	if(Answer=='' || Answer_g==''){
		alert("请输入完整所有的问题选项");
        return false;
		}
	Answer=Answer+"&"+Answer_g;
	result=result+","+0;
	}
	document.form1.Question_answer.value=Answer;
	document.form1.Question_result.value=result;
	return true;
	}
}
function MoreAnswer(){
//var f = document.form1;
//var input = document.createElement("input");
//input.setAttribute("id","legal");
//f.appendChild(input);
var ul=document.getElementById("ulAnswer");
var input=document.createElement("input");
var li=document.createElement("li");
input.setAttribute("id","Answer");
li.appendChild(input);
ul.appendChild(li);
//alert(document.form1.Answer.value);
}

function LessAnswer(){
var ul=document.getElementById("ulAnswer");
var li=ul.lastChild;
if (ul.firstChild==li){
	alert("最后一个选项不能删除");
	}
else {
	ul.removeChild(li);	
	}

//var input=document.createElement("input");
}

function MoreAnswer_2(){
var ul=document.getElementById("ulAnswer");
var li=document.getElementById("ulAnswer").lastChild;
ul.removeChild(li);
var input=document.createElement("input");
var input2=document.createElement("input");
var input3=document.createElement("input");
var li=document.createElement("li");
var li2=document.createElement("li");
input.setAttribute("id","Answer");
input2.setAttribute("id","Answer");
input3.setAttribute("id","Answer_2");
input3.setAttribute("readOnly",true);
input3.setAttribute("value","用户在此框输入自定义文本");
li.appendChild(input);
li2.appendChild(input2);
li2.appendChild(input3);
ul.appendChild(li);
ul.appendChild(li2);
}

function LessAnswer_2(){
var ul=document.getElementById("ulAnswer");
var li=document.getElementById("ulAnswer").lastChild;
ul.removeChild(li);
adjust();
}
function adjust(){
var ul=document.getElementById("ulAnswer");
var li=document.getElementById("ulAnswer").lastChild;
ul.removeChild(li);
var input=document.createElement("input");
var input2=document.createElement("input");
var li=document.createElement("li");
input.setAttribute("id","Answer");
input2.setAttribute("id","Answer_2");
input2.setAttribute("readOnly",true);
input2.setAttribute("value","用户在此框输入自定义文本");
li.appendChild(input);
li.appendChild(input2);
ul.appendChild(li);
}
//编辑题目--添加图片用
function SwitchHidden(obj){
if (document.getElementById(obj).style.display=="none")
document.getElementById(obj).style.display="block";
else
document.getElementById(obj).style.display="none";
}




//ajax开始
function doChecked(obj,id) {
   send_request("GET","QuestionType.asp?Qtype="+obj.value+"&Survey_id="+id,null,"text",showFeedback);
}

function showFeedback() {
	if (http_request.readyState == 4) { // 判断对象状态
		if (http_request.status == 200) { // 信息已经成功返回，开始处理信息
			//alert(http_request.responseText);
			document.getElementById("Question_add_content").innerHTML =http_request.responseText ;
			}
			else { //页面不正常
			alert("您所请求的页面有异常。");
		}
	 }
}

