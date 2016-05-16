<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>红网网络情感监控网</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
    <META HTTP-EQUIV="pragma" CONTENT="no-cache"> 
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-store, must-revalidate"> 
	<META HTTP-EQUIV="expires" CONTENT="0">
    
	<link rel="shortcut icon" href="/Public/Img//favicon.ico" />
	
	<script type="text/javascript" 			src="/Public/Js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" 			src="/Public/Js/bootstrap.min.js"></script>
	<script type="text/javascript" 			src="/Public/Js/esl.js"></script>
	<script type="text/javascript" 			src="/Public/Js/echarts-plain-map.js"></script>
	<script type="text/javascript" 			src="/Public/Js/index/index.js"></script>
	<script type="text/javascript" 			src="/Public/Js/ajax.js"></script>
		
    <link 	rel="stylesheet"				href="/Public/Css/bootstrap.min.css" 	>
	<link 	rel="stylesheet"				href="/Public/Css/main_new2.css" 		>
	
	<script type="text/javascript">
		//var loginFlag = false;
		//var loginHelper = null;
		$(document).ready(function(){
			$(function () { $("[data-toggle='popover']").popover(); });
		}); 
		
	</script>
</head>
<body>
<div id="header">
	<div id="header-mid">
		<?php if(empty($_SESSION['account'])): ?><div id="tip1"><p>Tips：登陆即可下载当前页面数据</p></div>
			<p style="font-size:1.6em;color:green;position:absolute;top:0px;left:310px;height:40px;line-height:40px;">
				红网网络情感监控网
			</p>
		<?php else: ?>
			<p style="font-size:1.6em;color:green;position:absolute;top:0px;left:50px;height:40px;line-height:40px;">
				红网网络情感监控网
			</p><?php endif; ?>
		<div id="userModel" >
			<?php if(!empty($_SESSION['account'])): ?><div id="logined"><span style="font-size:1.2em;"><?php echo ($user["name"]); ?></span>，您好！
					<button onclick="window.location='/index.php/Home/Login/logout'" type="button" class="btn btn-default" title="Tips"  
				      data-container="body" data-toggle="popover" data-placement="bottom" 
				      data-content="退出" data-trigger="hover">
				      	退出登录
				    </button>
					<button onclick="download_data()" type="button" class="btn btn-default" title="Tips"  
				      data-container="body" data-toggle="popover" data-placement="bottom" 
				      data-content="注 :下载的数据包括 地图、柱状图、月变化折线图、每日详情 几个模块的数据(初始化页面时的数据)，年变化折线图暂不提供下载，有需要可联系我们！" data-trigger="hover">
				      	下载首页数据
				    </button>
				</div>
			<?php else: ?>
				<div id="unlogin">
					<button type="button" class="btn btn-default btn-sm" onclick="window.location='/index.php/Home/Login/login'"> 
						<span class="glyphicon glyphicon-user" style="size:17px"></span> 登 陆 
					</button>
					<button type="button" class="btn btn-default btn-sm" onclick="window.location='/index.php/Home/Login/register'"> 
						<span class="glyphicon glyphicon-hand-right"></span> 注 册 
					</button>
					<button type="button" class="btn btn-default" 
				        data-placement="bottom" data-trigger="hover"
				      data-toggle="modal" data-target="#myModal"
				      >
				      	忘记密码
				    </button>
				    
				    
				    
				    	<!-- 模态框 -->
					    <div  class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
						   <div class="modal-dialog">
						      <div class="modal-content">
						         <div class="modal-header">
						            <button type="button" class="close" 
						               data-dismiss="modal" aria-hidden="true">
						                  &times;
						            </button>
						            <h4 class="modal-title" id="myModalLabel">
						              	验证邮箱更改新密码！
						            </h4>
						         </div>
						         <div class="modal-body">
									 <div style="width:550px;margin:15px auto;">           
									 	<div style="float:left;width:60px;">账号：</div>
									 	<input onblur="FCheckAccount()" type="text" style="width:325px;float:left;" class="form-control" id="account" name="account" placeholder="请输入账号">
									 	<div id="tipa" style="float:left;"></div>
									 	<div style="clear:both;"></div>
									 </div>
									 <div style="width:550px;margin:15px auto;">        
									 	<div style="float:left;width:60px;">邮箱：</div>
										<input onblur="FCheckEmail()" type="text" style="width:325px;float:left;" class="form-control" id="email" name="email" placeholder="请输入邮箱">
									 	<div id="tipe" style="float:left;"></div>
									 	<div style="clear:both;"></div>
									 </div> 
									 <div style="width:550px;margin:15px auto;">        
									 	<div style="float:left;width:60px;">验证码：</div>
										<input type="text" style="width:175px;float:left;" class="form-control" id="checkCode" name="checkCode" placeholder="请输入验证码">
									 	<button style="float:left;" onclick="getEmailCheckCode()" type="button" id="SendCheckCode" class="btn btn-primary">获取邮箱验证码</button>
									 	<div id="tipc" style="float:left;"></div>
									 	<div style="clear:both;"></div>
									 </div>
									 <div style="width:550px;margin:15px auto;">        
									 	<div style="float:left;width:60px;">新密码：</div>
										<input type="text" style="width:325px;float:left;" class="form-control" id="password" name="password" placeholder="请输入新密码">
									 	<div id="tipe" style="float:left;"></div>
									 	<div style="clear:both;"></div>
									 </div>    
						         </div>
						         <div class="modal-footer">
						            <button type="button" class="btn btn-default" 
						               data-dismiss="modal">关闭
						            </button>
						            <button type="button" class="btn btn-primary" onclick="setNewPsw()">
						              	 提交更改
						            </button>
						         </div>
						      </div><!-- /.modal-content -->
						</div>
					</div>
					<!-- 模态框 -->
				    
				</div><?php endif; ?>
		</div>
	</div>
</div>
<div id="bg"></div>
<div id="carousel_container" class="carousel slide full_height">
	<div id="nav-top">
    	<div id="nav">
            <ul id="myTab" class="nav nav-tabs" role="tablist">
            	<li role="presentation">
                	<a onclick="switchToTab('map')" data-toggle="tab">地图</a>
                </li>
                <li role="presentation">
                	<a onclick="switchToTab('bar')" data-toggle="tab">柱状图</a>
                </li>
                <li role="presentation">
               	 	<a onclick="switchToTab('line')" data-toggle="tab">月变化折线图</a>
                </li>
                <li role="presentation" class="active">
                	<a onclick="switchToTab('jh')" data-toggle="tab">红网精帖</a>
                </li>
                <li role="presentation" id="forLineClick">
                	<a onclick="switchToTab('detail')" data-toggle="tab">每日详情</a>
                </li>
                <li role="presentation">
                	<a onclick="switchToTab('all')" data-toggle="tab">年变化折线图</a>
                </li>
                <li role="presentation">
                	<a onclick="switchToTab('compare')" data-toggle="tab">实况预测对比</a>
                </li>
            </ul>
       
          
        </div>
    </div>
	<div class="tab-content">
		<div class="tab-pane fade in active">
			<div class="main-slide">
				<div class="splash">
                	<div class="charts-main_jh">
						<div id="jh">
    <table class="th" border="0" cellspacing="0" bordercolor="#cdcdcd">
    	<tr style="background-color:#f2f2f2;height:35px;">
        	<td width="50px"></td>
        	<td width="500px">标题</td>
            <td width="150px">作者</td>
            <td width="140px">回复数</td>
            <td width="170px">发帖时间</td>
        </tr>
    </table>
 <div style="border:1px solid #cdcdcd;">   
    <table class="body" style="margin-left:10px;" cellspacing="0" border="0">
	
	<!---FOREACH----->
	<?php if(is_array($jh)): foreach($jh as $key=>$temp): ?><tr class="jh-article-row">
			<td class="ic" align="right"><a href="<?php echo ($temp["url"]); ?>" title="置顶主题点击新窗口打开" target="__blank"><img src="/Public/Img/pin_3.gif" /></td>
			<td class="ti"><a target="_blank" href="<?php echo ($temp["url"]); ?>"><?php echo ($temp["title"]); ?></a></td>
			<td class="au"><?php echo ($temp["author"]); ?></td>
			<td class="re"><?php echo ($temp["replies"]); ?></td>
			<td class="tm"><?php echo ($temp["year"]); ?>-<?php if(($temp["month"]) < "10"): ?>0<?php endif; echo ($temp["month"]); ?>-<?php if(($temp["day"]) < "10"): ?>0<?php endif; echo ($temp["day"]); ?></td>
		</tr><?php endforeach; endif; ?>
	<!---END FOREACH----->
	
    </table>
  </div>
</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<pre style="background:#e0e0e0;height:100px;"><div style="margin:0 auto;width:1000px;">
						  红网网络情感监控网							      	Designed By ：	陈刚		郭佳伟	秦杰	
							
							指导老师：姜磊									联系我们：616142437@qq.com
				
	</div></pre>
</div>
<script>var m = new DialogBox("missPsw");</script>			
</body>
</html>