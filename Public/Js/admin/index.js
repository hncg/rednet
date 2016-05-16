var host=window.document.location.href.substring(0,window.document.location.href.indexOf(window.document.location.pathname)); 
var AdminModel=host+"/index.php/Admin/";
function refreshCheckCode(){
	
	var verify=$("#checkcodeimg");
	var imgsrc=verify.attr("src");
	
	verify.attr("src",imgsrc.replace(/\?.*/,'')+'?'+Math.random());
}
function goLogin(){
	
	var $account=$("#account").val();
	var $password=$("#password").val();
	var $checkcode=$("#checkcode").val();
	var $action=$(".login-form form").attr("action");
	$.post($action,{account:$account,password:$password,checkcode:$checkcode},function(data){
		
		if(data=="1"){
			window.location.href=AdminModel+"Index/index";
		}else{
			alert(data);
			refreshCheckCode();
		}
	});
}
function updataAdmin(obj){
	
	var tr=$(obj).parent().parent().children('td');
	var id=tr.children(".id").val();
	var account=tr.children('.account').val();
	var email=tr.children(".email").val();
	var tel=tr.children(".tel").val();
	var name=tr.children(".name").val();
	
	$.post(AdminModel+'main/updataAdmin',{
		ID:id,account:account,email:email,tel:tel,name:name
	},function(data){
		window.location.href=window.location.href;
	});
}
function deleteAdmin(obj){
	
	var tr=$(obj).parent().parent().children('td');
	var id=tr.children(".id").val();
	
	$.post(AdminModel+'main/deleteAdmin',{ID:id},function(data){

		window.location.href=window.location.href;
	});
}
function goAddAdmin(){
	$('#adminlistTable').hide();
	$('#add-admin-model').show();
}
function goBackList(){
	$('#add-admin-model').hide();
	$('#adminlistTable').show();
}
function checkact(){
	
	var account=$("#account").val();
	var flag=0;
	if (account.length == 0) {
		$("#account").parent().parent().children('.tip').html('不能为空');
		flag=0;
	}
	$.ajax({
		type:'post',
		url:AdminModel + "Main/checkAdminAct",
		async:false,
		cache:false,
		data:{account:account},
		success:function(data){
			if(data==1)
				$("#account").parent().parent().children('.tip').html('账号已存在!');
			else if(data==0&&account.length != 0){
				$("#account").parent().parent().children('.tip').html('账号可用!');
				flag=1;
			}
			else if(account.length != 0)alert(data);
		},
		error:function(data){
			alert('error');
		}
	});
	return flag;
}
function checkpsw(){
	var psw1=$('#password').val();
	var psw2=$('#password2').val();
	if(psw1.length<6)$("#pswtxt").html("密码长度小于6位");
	else if(psw1==psw2){
		$("#pswtxt").html("密码可用！");
		return true;
	}else{
		$("#pswtxt").html("两次密码不一致！");
	}
	return false;
}

function checkform(){
	if(!(checkact()&&checkpsw())){
		alert('请先确认表单无误！');
		return false;
	}
	$.post(AdminModel+"Main/addAdmin",{
		account:$('#account').val(),
		password:$('#password').val(),
		tel:$('#tel').val(),
		email:$('#email').val(),
		name:$('#name').val()
	},function(data){
		if(data==1){
			alert("添加成功!");
			window.location.href=AdminModel+"Main/adminManage";
		}
		else{
			alert(data);
		}
	})
}
function changeSelfInf(){
	var id=$('#id').val();
	var tel=$('#tel').val();
	var email=$('#email').val();
	var name=$('#name').val();
	
	$.post(AdminModel+'Main/changeSelfInf',{ID:id,tel:tel,email:email,name:name},function(data){
		if(data==1){
			alert("修改成功！");
			window.location.href=AdminModel+'Main/changeInf';
		}else{
			alert(data);
		}
	});
}
function changepsw(){
	var id=$("id").val();
	var psw0=$('#password0').val();
	var psw=$('#password').val();
	var psw1=$('#password1').val();
	var checkcode=$('#checkcode').val();
	$.post(AdminModel+'Main/changepsw',{ID:id,p0:psw0,password:psw,p1:psw1,checkcode:checkcode},function(data){
		if(data==1){
			alert("修改成功！");
			window.location.href=AdminModel+"Main/changeInf";
		}else{
			alert(data);
			refreshCheckCode();
		}
	});
}
function downMoreData(){
	var start=$("#start").val();
	var end=$("#end").val();
	var date=new Date();
	var y=date.getFullYear();
	var m=date.getMonth()+1;if(m<10)m='0'+m;
	var d=date.getDate();if(d<10)d='0'+d;
	var today=y+'-'+m+'-'+d;
	var city=$("#city").val();
	if (end > today) {
		alert('结束日期大于今天！');
		return false;
	}if(start<'2000-01-01'){
		alert('开始日期有误！');
		return false;
	}if(start>end){
		alert('开始日期大于结束日期！');
		return false;
	}
	$.ajax({
		type:'post',
		url:AdminModel+'Main/downloadMoreData',
		async:false,
		cache:false,
		data:{start:start,end:end,city:city},
		success:function(data){
			var preg=/.csv/;
			if(preg.test(data)&&data.length<=50){
				recordDownload();
				window.location.href=data;
			}else{
				alert(data);
			}
		},
		error:function(data){
			alert('error');
		}
	});
}
function recordDownload(){
	var start=$("#start").val();
	var end=$("#end").val();
	var city=$("#city").val();
	$.ajax({
		type:'post',
		url:AdminModel+"Main/recordDownload",
		async:false,
		cache:false,
		data:{start:start,end:end,city:city},
		success:function(data){
			
			if(data==1){}
			else if(data==0){
				alert("下载记录失败，请联系高级管理员!");
				}
				else{
					alert(data);
				}
		},
		error:function(data){
			alert('error');
		}
	});
}









