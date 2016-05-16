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
                <li role="presentation" class="active">
               	 	<a onclick="switchToTab('line')" data-toggle="tab">月变化折线图</a>
                </li>
                <li role="presentation">
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
                	<div class="charts-main_line">
						<div id="line_main">

	<div id="line_top">
		<div id="line_title_main">
			<?php echo ($cityZH); ?>  近30天 七种情感变化趋势
		</div>
        <div style="position:absolute;width:240px;left:80px;top:30px;">
        	<p style="font-size:1em;color:red;">Tips:点击当天坐标点可查看当天详情</p>
        </div>
        <div id="line_title_sub">以下数据来自红网论坛</div>
        <div id="line_form">
        	<form>
	        		<select name="line_city" id="line_city" onchange="refresh_line()" autocomplete="off">
	                	<option value="1" selected="selected">长 沙 市</option>
	               	 	<option value="2" >株 洲 市</option>
	                	<option value="3" >湘 潭 市</option>
	               		<option value="4" >衡 阳 市</option>
	               		<option value="5" >岳 阳 市</option>
	               		<option value="6" >益 阳 市</option>
	               		<option value="7" >常 德 市</option>
	               		<option value="8" >邵 阳 市</option>
	               		<option value="9" >娄 底 市</option>
	               		<option value="10" >永 州 市</option>
	               		<option value="11" >郴 州 市</option>
	               		<option value="12" >怀 化 市</option>
	               		<option value="13" >湘 西 州</option>
	               		<option value="14" >张 家 界</option>
	                </select>
	                <select name="line_year" id="line_year" onchange="refresh_line()" autocomplete="off">
	        			<?php $__FOR_START_2127333537__=2012;$__FOR_END_2127333537__=2016;for($temp=$__FOR_START_2127333537__;$temp < $__FOR_END_2127333537__;$temp+=1){ ?><option <?php if(($temp) == $dateNow->year): ?>selected="selected"<?php endif; ?> value="<?php echo ($temp); ?>"><?php echo ($temp); ?>年</option><?php } ?>
	        		</select>
	        		<select name="line_month" id="line_month" onchange="refresh_line()" autocomplete="off">
	        			<?php $__FOR_START_2058639950__=1;$__FOR_END_2058639950__=13;for($temp=$__FOR_START_2058639950__;$temp < $__FOR_END_2058639950__;$temp+=1){ ?><option value="<?php echo ($temp); ?>" <?php if(($temp) == $dateNow->month): ?>selected="selected"<?php endif; ?> ><?php if(($temp) < "10"): ?>0<?php endif; echo ($temp); ?> 月</option><?php } ?>
	        		</select>
        	</form>
        </div>
	</div>
	<div style="position:absolute;top:70px;">
		<div style="background-color:white;width:100px;height:1000px;position:absolute;left:388px;z-index:100;"></div>
		<div style="background-color:white;width:100px;height:700px;position:absolute;top:20px;right:20px;z-index:100;"></div>
		
		<div class="line_s" id="line_le" style="width:480px;height:250px;">	</div>
	    <div class="line_s" id="line_hao" style="width:480px;height:250px;">	</div>
	     
	    <div class="line_s" id="line_nu" style="width:480px;height:250px;">	</div> 
	    <div class="line_s" id="line_ai" style="width:480px;height:250px;">	</div>
	     
	    <div class="line_s" id="line_ju" style="width:480px;height:250px;">	</div> 
	    <div class="line_s" id="line_wu" style="width:480px;height:250px;">	</div>
	     
	    <div class="line_s" id="line_jing" style="width:480px;height:250px;">	</div> 
	    <div class="line_s" id="line_text" style="width:480px;height:250px;">
	    	<h3 style="margin:100px auto;width:340px;">
	    		想看年变化？
	    		<a onclick="switchToTab('all')" style="text-decoration:none;color:red;">点击查看</a>	
	    	</h3>
	    </div> 
	 </div>
</div>
<script type="text/javascript">

	var ss={t:<?php echo ($line_x); ?>,data0:<?php echo ($line_le); ?>,data1:<?php echo ($line_hao); ?>,data2:<?php echo ($line_nu); ?>,data3:<?php echo ($line_ai); ?>,data4:<?php echo ($line_ju); ?>,data5:<?php echo ($line_wu); ?>,data6:<?php echo ($line_jing); ?>};

// 路径配置
        require.config({
            paths:{ 
                'echarts' : '/Public/Js/echarts',
                'echarts/chart/bar' : '/Public/Js/echarts'
            }
        });
        
        // 使用
        require(
            [
                'echarts',
                'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                myChart_line_le = ec.init(document.getElementById('line_le')); 
				myChart_line_hao = ec.init(document.getElementById('line_hao'));
				 
				myChart_line_nu = ec.init(document.getElementById('line_nu'));
				myChart_line_ai = ec.init(document.getElementById('line_ai'));
                
				myChart_line_ju = ec.init(document.getElementById('line_ju'));
				myChart_line_wu = ec.init(document.getElementById('line_wu'));
				myChart_line_jing = ec.init(document.getElementById('line_jing'));
				
				option_line = {
					title : {
						text: '',
						subtext: '          情感值'
					},
					tooltip : {
						trigger: 'axis'	
					},
					legend: {
						data:['乐'],
					},
					toolbox: {
						show : true,
						feature : {
						    mark : {show : false},
						    dataZoom : {show : false},
						    dataView : {show : false},
						    magicType: {show : false},
						    restore : {show : false},
						    saveAsImage : {show : false}
						}
					},
					calculable : false,
					xAxis : [
					{
						type : 'category',
						boundaryGap : false,
						data : []
					}
					],
					yAxis : [
					{
						type : 'value',
						axisLabel : {
							formatter: '{value}'
						},
						splitArea : {show : true}
					}
					],
					series : [
					{
						name:'乐',
						showAllSymbol:true,
						type:'line',
						itemStyle: {
							normal: {
								lineStyle: {
									color:'',
									shadowColor : 'rgba(0,0,0,0.3)',
									shadowBlur: 5,
									shadowOffsetX: 3,
									shadowOffsetY: 3
								}
							}
						},
						data:[],
					}
					]
				};//end option
			// 为echarts对象加载数据
			
				option_line.xAxis[0].data=ss.t;
				option_line.series[0].data=ss.data0; 
				myChart_line_le.setOption(option_line);
				
				option_line.legend.data="好";
				option_line.series[0].name="好";
				option_line.series[0].data=ss.data1;
				option_line.series[0].itemStyle.normal.lineStyle.color='#ffcccc';
				myChart_line_hao.setOption(option_line);
				
				option_line.legend.data="怒";
				option_line.series[0].name="怒";
				option_line.series[0].data=ss.data2; 
				option_line.series[0].itemStyle.normal.lineStyle.color='#ffd700';
				myChart_line_nu.setOption(option_line);
				
				option_line.legend.data="哀";
				option_line.series[0].name="哀";
				option_line.series[0].data=ss.data3; 
				option_line.series[0].itemStyle.normal.lineStyle.color='blue';
				myChart_line_ai.setOption(option_line);
				
				option_line.legend.data="惧";
				option_line.series[0].name="惧";
				option_line.series[0].data=ss.data4;
				option_line.series[0].itemStyle.normal.lineStyle.color='#b88898'; 
				myChart_line_ju.setOption(option_line);
				
				option_line.legend.data="恶";
				option_line.series[0].name="恶";
				option_line.series[0].data=ss.data5; 
				option_line.series[0].itemStyle.normal.lineStyle.color='green';
				myChart_line_wu.setOption(option_line);
				
				option_line.legend.data="惊";
				option_line.series[0].name="惊";
				option_line.series[0].data=ss.data6; 
				option_line.series[0].itemStyle.normal.lineStyle.color='#4D4DFF';
				myChart_line_jing.setOption(option_line);
				
				var ecConfig = require('echarts/config');//alert(ecConfig);
				var zrEvent = require('zrender/tool/event');
				myChart_line_le.on(ecConfig.EVENT.CLICK,line_click);
				myChart_line_hao.on(ecConfig.EVENT.CLICK,line_click);
				myChart_line_nu.on(ecConfig.EVENT.CLICK,line_click);
				myChart_line_ai.on(ecConfig.EVENT.CLICK,line_click);
				myChart_line_ju.on(ecConfig.EVENT.CLICK,line_click);
				myChart_line_wu.on(ecConfig.EVENT.CLICK,line_click);
				myChart_line_jing.on(ecConfig.EVENT.CLICK,line_click);

				function line_click(param){
					var xName=param.name;
					
					//alert(xName.match(/[]/));
					if(xName.match(/([a-zA-Z])|\-/)==null)
						goto_detail(xName);
				}
            }//end function
        );
    </script>
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