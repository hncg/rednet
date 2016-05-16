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
            	<li role="presentation" class="active">
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
		<div class="tab-pane fade in active" id="page_home">
			<div class="main-slide">
				<div class="splash">
                	<div class="charts-main_map">
						<div>
							<p style="font-size:0.9em;color:red;padding-top:0px;margin-left:130px;">
						   		 为保证浏览质量，浏览器请选用 IE10 以上版本或 用360、火狐、谷歌等较高版本的浏览器访问。若无法显示图表，请更换浏览器继续访问。
						    </p>
						</div>
						<div style="position:absolute;top:440px;z-index:2;">

							<button type="button" class="btn btn-default" title="Tips"
						      data-container="body" data-toggle="popover" data-placement="right"
						      data-content="点击拖动<图例>中的三角形可缩小取值范围，表现至地图上-->只显示数据在该范围的地区 ( 缩小后的图例条可上下拖动  ) " data-trigger="hover">
						      	发现新工具
						    </button>
						</div>
						<div id="map_main">

						</div>
						<div id="opinion_list">
						     <ul class="list-group" style="width:140px;">
						        <li	<?php if(($opinion) == "cps"): ?>class="list-group-item selected-op"<?php else: ?>class="list-group-item"<?php endif; ?> >
						        	<a href="<?php echo U('/Home/Index/map?opinion=synthesize');?>">		(总)Multiple		</a>
						        </li>
						        <li	<?php if(($opinion) == "happy"): ?>class="list-group-item selected-op"<?php else: ?>class="list-group-item"<?php endif; ?> >
						        	<a href="<?php echo U('/Home/Index/map?opinion=happy');?>">		(喜)Happy		</a>
						        </li>
						        <li	<?php if(($opinion) == "good"): ?>class="list-group-item selected-op"<?php else: ?>class="list-group-item"<?php endif; ?> >
						        	<a href="<?php echo U('/Home/Index/map?opinion=good');?>">		(好)Good			</a>
						        </li>
						        <li	<?php if(($opinion) == "anger"): ?>class="list-group-item selected-op"<?php else: ?>class="list-group-item"<?php endif; ?> >
						        	<a href="<?php echo U('/Home/Index/map?opinion=anger');?>">		(怒)Anger		</a>
						        </li>
						        <li	<?php if(($opinion) == "sorrow"): ?>class="list-group-item selected-op"<?php else: ?>class="list-group-item"<?php endif; ?> >
						        	<a href="<?php echo U('/Home/Index/map?opinion=sorrow');?>">		(哀)Sorrow		</a>
						        </li>
						        <li	<?php if(($opinion) == "fear"): ?>class="list-group-item selected-op"<?php else: ?>class="list-group-item"<?php endif; ?> >
						        	<a href="<?php echo U('/Home/Index/map?opinion=fear');?>">		(惧)Fear			</a>
						        </li>
						        <li	<?php if(($opinion) == "evil"): ?>class="list-group-item selected-op"<?php else: ?>class="list-group-item"<?php endif; ?> >
						        	<a href="<?php echo U('/Home/Index/map?opinion=evil');?>">		(恶)	Evil		</a>
						        </li>
						        <li	<?php if(($opinion) == "surprise"): ?>class="list-group-item selected-op"<?php else: ?>class="list-group-item"<?php endif; ?> >
						        	<a href="<?php echo U('/Home/Index/map?opinion=surprise');?>">		(惊)	Surprise	</a>
						        </li>
						      </ul>
						      <div id="color_intro">
						          <p id="map_intro">
									某个市的颜色是偏<font color="#green" style="background-color:#666;"><b>绿色</b></font>的？哇！这里满满的正面情绪，高兴，快乐，以及惊喜？某块区域偏<font color="yellow" style="background-color:#666;"><b>黄色</b></font>的？哎，这里充满负面情绪。
								  </p>
						          <p style="font-size:1em;">(注:地图详细数据见<a href="<?php echo U('/Home/Index/bar');?>?opinion=<?php echo ($opinion); ?>"><font color="red">柱状图</font></a>)</p>
						          <p style="font-size:1em;">
						           	到底发生了什么呢？去其他模块看看吧！
						          </p>
						      </div>
						</div>
						<script type="text/javascript">
							var feel_data=(<?php echo ($weekData); ?>);

							var myChart_map = echarts.init(document.getElementById('map_main'));
									var map_option={
										title: {
											text : '湖南省十四市州:<?php echo ($opinionZH); ?>',
											subtext : '红网近一周情感调查结果分布'
										},
										tooltip : {
											trigger: 'item',
											formatter: '{b}'//鼠标指上后显示
										},

										dataRange: {//值域选择
											min: -1000,
											max: 1000,
											color:['#3f0','aqua', 'orange', 'yellow'],//['yellow','orange','tan','lightyellow'],
											text:['高','低'],           // 文本，默认为数值文本
											calculable : true
										},
										series : [
											{

												type: 'map',
												mapType: '湖南',
												selectedMode : false,//是否允许选中
												itemStyle:{
													normal:{label:{show:true}},
													emphasis:{label:{show:true}}
												},
												data:[
													{name: '长沙市',value:feel_data[0]},
													{name: '株洲市',value:feel_data[1]},
													{name: '湘潭市',value:feel_data[2]},
													{name: '衡阳市',value:feel_data[3]},
													{name: '岳阳市',value:feel_data[4]},
													{name: '益阳市',value:feel_data[5]},
													{name: '常德市',value:feel_data[6]},
													{name: '邵阳市',value:feel_data[7]},
													{name: '娄底市',value:feel_data[8]},
													{name: '永州市',value:feel_data[9]},
													{name: '郴州市',value:feel_data[10]},
													{name: '怀化市',value:feel_data[11]},
													{name: '湘西土家族苗族自治州',value:feel_data[12]},
													{name: '张家界市',value:feel_data[13]},
												],
												geoCoord: {
												'长沙': [113.0823,28.2568],
												'株洲': [113.5327,27.0319],
												'湘潭': [112.5800,27.6875],
												'衡阳': [112.4029,26.7775],
												'邵阳': [110.9739,26.7875],
												'岳阳': [113.2710,29.1175],
												'张家界': [110.5439,29.3075],
												'益阳': [111.7410,28.3700],
												'常德': [111.5439,29.1875],
												'娄底': [111.6239,27.7075],
												'郴州': [113.2439,25.8775],
												'永州': [111.7300,25.7575],
												'怀化': [109.9539,27.4475],
												'湘西': [109.8439,28.6675]
												}

											},
											{
											name: '',
											type: 'map',
											mapType: '湖南',
											data:[],
											markLine : {
												smooth:true,
												effect : {
													show: true,
													scaleSize: 1,
													period: 30,
													color: '#fff',
													shadowBlur: 10
												},
												itemStyle : {
													normal: {
														borderWidth:1,
														lineStyle: {
															type: 'solid',
															shadowBlur: 10
														}
													}
												},
												data : [
												]
											},
											markPoint : {
												symbol:'emptyCircle',
												symbolSize : function (v){
													return 10 + v/10
												},
												effect : {
													show: true,
													shadowBlur : 0
												},
												itemStyle:{
													normal:{
														label:{show:false}
													}
												},

												data : [
													{name:'长沙',value:'100'},
													{name:'株洲',value:'0'},
													{name:'湘潭',value:'0'},
													{name:'衡阳',value:'10'},
													{name:'邵阳',value:'10'},
													{name:'岳阳',value:'10'},
													{name:'张家界',value:'10'},
													{name:'益阳',value:'10'},
													{name:'常德',value:'10'},
													{name:'娄底',value:'10'},
													{name:'郴州',value:'10'},
													{name:'永州',value:'10'},
													{name:'怀化',value:'10'},
													{name:'湘西',value:'10'},
												]
											}
										},
										]
									};
									myChart_map.setOption(map_option);
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