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
                <li role="presentation">
                	<a onclick="switchToTab('jh')" data-toggle="tab">红网精帖</a>
                </li>
                <li role="presentation" id="forLineClick">
                	<a onclick="switchToTab('detail')" data-toggle="tab">每日详情</a>
                </li>
                <li role="presentation" class="active">
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
                	<div class="charts-main_all">
						<div id="all_line_main">
  <div style="height:100px;width:1000px;margin:0 auto;position:relative;">
        <h2 style="width:520px;margin:35px auto 35px;">
            <span id="city"><?php echo ($cityZH); ?></span>&nbsp;&nbsp;近年红网情感 ( <span id="opinion"><?php echo ($opinionZH); ?></span> ) 变化
        </h2>
        <div style="width:800px;position:absolute;left:150px;top:60px;">
        	<p style="font-size:90%;width:800px;">图表下方横向 拉条 可调整大小，缩小拉条长度可并拉动到某一位置可将该图该区域放大。图表右上角还有其他<span style="color:red;font-size:1.1em;">工具</span>，<span style="color:red;font-size:1.1em;">详情点击</span>		——>
            </p>
        </div>
        <div style="position:absolute;top:100px;left:150px; width:300px;z-index:1000;">
        	<form>
        		<select name="all_city" id="all_city" onChange="showLineAllT()" autocomplete="off">
                    <option value="3" <?php if(($city) == "3"): ?>selected="selected"<?php endif; ?>>长 沙 市</option>
                    <option value="2" <?php if(($city) == "2"): ?>selected="selected"<?php endif; ?>>株 洲 市</option>
                    <option value="7" <?php if(($city) == "7"): ?>selected="selected"<?php endif; ?>>湘 潭 市</option>
                    <option value="5" <?php if(($city) == "5"): ?>selected="selected"<?php endif; ?>>衡 阳 市</option>
                    <option value="10" <?php if(($city) == "10"): ?>selected="selected"<?php endif; ?>>岳 阳 市</option>
                    <option value="4" <?php if(($city) == "4"): ?>selected="selected"<?php endif; ?>>益 阳 市</option>
                    <option value="9" <?php if(($city) == "9"): ?>selected="selected"<?php endif; ?>>常 德 市</option>
                    <option value="12" <?php if(($city) == "12"): ?>selected="selected"<?php endif; ?>>邵 阳 市</option>
                    <option value="13" <?php if(($city) == "13"): ?>selected="selected"<?php endif; ?>>娄 底 市</option>
                    <option value="8" <?php if(($city) == "8"): ?>selected="selected"<?php endif; ?>>永 州 市</option>
                    <option value="11" <?php if(($city) == "11"): ?>selected="selected"<?php endif; ?>>郴 州 市</option>
                    <option value="6" <?php if(($city) == "6"): ?>selected="selected"<?php endif; ?>>怀 化 市</option>
                    <option value="14" <?php if(($city) == "14"): ?>selected="selected"<?php endif; ?>>湘 西 州</option>
                    <option value="1" <?php if(($city) == "1"): ?>selected="selected"<?php endif; ?>>张 家 界</option>
            	</select>
                <select name="all_opinion" id="all_opinion" onChange="showLineAllT()" autocomplete="off">
                	<option value="cps" <?php if(($opinion) == "cps"): ?>selected="selected"<?php endif; ?>>	总 synthesize	</option>
                    <option value="happy" <?php if(($opinion) == "happy"): ?>selected="selected"<?php endif; ?>>		喜 Happy			</option>
                    <option value="good" <?php if(($opinion) == "good"): ?>selected="selected"<?php endif; ?>>		好 Good			</option>
                    <option value="anger" <?php if(($opinion) == "anger"): ?>selected="selected"<?php endif; ?>>		怒 Anger			</option>
                    <option value="sorrow" <?php if(($opinion) == "sorrow"): ?>selected="selected"<?php endif; ?>>		哀 Sorrow		</option>
                    <option value="fear" <?php if(($opinion) == "fear"): ?>selected="selected"<?php endif; ?>>		惧 Fear			</option>
                    <option value="evil" <?php if(($opinion) == "evil"): ?>selected="selected"<?php endif; ?>>		恶 Evil			</option>
                    <option value="surprise" <?php if(($opinion) == "surprise"): ?>selected="selected"<?php endif; ?>>	惊 Surprise		</option>
                </select>
        	</form>
        </div>
    </div>
    <div id="all-line" style="height:500px; width:1000px;margin:0 auto;"></div>
</div>
	<script type="text/javascript">
    var xList=<?php echo ($allList); ?> ;
	var yList=<?php echo ($allLineData); ?>;
    </script>
    <script type="text/javascript">

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
				myChart_line_main = ec.init(document.getElementById('all-line'));
				option_line = {
					title : {
						text: '',
						subtext: ''
					},
					tooltip : {
						trigger: 'axis'
					},
					legend: {
						data:["cps"],
					},
					toolbox: {
						show : true,
						x:705,
						feature : {
							mark : {show: true},
							dataZoom : {show: true},
							dataView : {show: false,readOnly:true},
							magicType : {show: true, type: ['line', 'bar']},
							restore : {show: true},
							saveAsImage : {show: true}
						}
					},
					calculable : false,
					xAxis : [
					{
						type : 'category',
						boundaryGap : false,
						data : xList
					}
					],
					yAxis : [
					{
						type : 'value',
						axisLabel : {
							formatter: '{value} '
						},
						splitArea : {show : true}
					}
					],
					dataZoom : {
							show : true,
							realtime : true,
							//x: 0,
							y: 460,
							//width: 400,
							height: 20,
							//backgroundColor: 'rgba(221,160,221,0.5)',
							//dataBackgroundColor: 'rgba(138,43,226,0.5)',
							//fillerColor: 'rgba(38,143,26,0.6)',
							//handleColor: 'rgba(128,43,16,0.8)',
							//xAxisIndex:[],
							//yAxisIndex:[],
							start : 0,
							end : 100
						},
					series : [
					{
						name:"cps",
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
						data:yList,
					}
					]
				};//end option
			myChart_line_main.setOption(option_line);
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