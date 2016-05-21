<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>红网网络情感监控网后台登陆入口</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
    <META HTTP-EQUIV="pragma" CONTENT="no-cache"> 
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-store, must-revalidate"> 
	<META HTTP-EQUIV="expires" CONTENT="0">
    
	<link rel="shortcut icon" href="img/favicon.ico" />
	
	<script type="text/javascript" 			src="/Public/Js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" 			src="/Public/Js/bootstrap.min.js"></script>
	<script type="text/javascript" 			src="/Public/Js/admin/index.js"></script>
	
    <link 	rel="stylesheet"				href="/Public/Css/bootstrap.min.css" 	>
	<link 	rel="stylesheet"				href="/Public/Css/admin/index.css" 	>
	<style rel="stylesheet">
		body{background:url(/Public//img/login-body-bg.jpg);}
		.container{background:url(/Public//img/login-bg.jpg);border:3px #33ff66 solid;border-radius:25px;}
		.font-white{color:white;}
		.login-left-pic{border-right:0px #666 solid;}
		.login-header{height:100px;min-width:1170px;border-top:1px #46a6fc solid;}
		.login-header h1{width:400px;margin:30px auto;}
		.login-bd .container{min-width:1170px;padding:0px;}
		.login-left-pic,.login-form{float:left;}
		.login-left-pic{width:520px;height:450px;}
		.login-form{width:500px;padding:0px 15px 0 15px;
			
		}
		.form-row{margin-top:40px;}
		#checkcode{width:145px;float:left;}
		.checkcodeimg{border:1px #666 solid;float:left;margin-left:5px;}
		.login-btn{border:1 px red solid;padding-left:75px;width:300px;}
		.login-btn .btn-default{margin-left:75px;}
		.cca{margin-left:5px;line-height:40px;}
	</style>
</head>
<body class="login-bd">
	<div class="login-header">
		<h1>网络情绪监控后台登陆</h1>
	</div>
	<div class="container">
		<div class="login-left-pic">
		</div>
		<div class="login-form" style="margin-top:140px;">
			<form class="form-horizontal" role="form" method="post" action="<?php echo U('Admin/Login/checkAccount');?>">
				<div class="form-group form-row">
				    <label for="account" class="col-sm-2 control-label">Account:</label>
				    <div class="col-sm-10">
						<input type="text" class="form-control" name="account" id="account" placeholder="账号" />			   
					</div>
				</div>
				<div class="form-group form-row">
				    <label for="password" class="col-sm-2 control-label">Password:</label>
				    <div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="password" placeholder="密码" />			   
					</div>
				</div>
				<div class="form-group form-row">
				    <label for="checkcode" class="col-sm-2 control-label">Checkcode:</label>
				    <div class="col-sm-10">
						<input type="text" class="form-control" name="checkcode" id="checkcode" placeholder="验证码" />	
						<img id="checkcodeimg" class="checkcodeimg" src="<?php echo U('Admin/Login/verify');?>?" onclick="refreshCheckCode()" title="点击刷新" />
						<a class="cca" href="javascript:void(0)" onclick="refreshCheckCode()">看不清?点击刷新</a> 
					</div>
				</div>
				<div class="form-group form-row">
					<div class="login-btn">
					    <button type="button" class="btn btn-primary" onclick="goLogin()">登陆</button>
						<button type="reset" class="btn btn-default">重置</button>
					</div>
				</div>
				
				
				
			</form>
			
		</div>
		<div class="clear"></div>
	</div>
</body>
</html>