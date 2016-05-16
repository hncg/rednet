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
                <li role="presentation" id="forLineClick" class="active">
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
                	<div class="charts-main_detail">
						<div id="pie">
	<div id="pie_main">	</div>
    <div id="inf" style="position:absolute;width:200px;height:20px;top:35px;left:300px;color:red;font-size:1.1em;">
    </div>
    <div id="pie_right">		</div>

    <div id="pie_title"><?php echo ($cityZH); ?> <?php echo ($detailDate->year); ?>年<?php echo ($detailDate->month); ?>月<?php echo ($detailDate->day); ?>日 情感调查数据详情</div>
    <div id="subtext">数据来自红网论坛</div>

    <div id="hot_word"></div>

    <div id="hot_article">
    	<div id="title_bar"><p>聚焦热帖</p></div>
    	<div id="ul_article">
            <ul>

            	<?php if(is_array($articleData)): foreach($articleData as $key=>$temp): ?><li>
						<div id="article_title">
							<a target="_blank" href="<?php echo ($temp['url']); ?>" >
								<?php echo ($temp['title']); ?>
							</a>
						</div>
						<div id="article_inf">
							<div class="left">
								回复数:<?php echo ($temp['reply_number']); ?>
							</div>
							<div class="right">
								    <?php echo ($temp['time_at']); ?>
							</div>
						</div>
					</li><?php endforeach; endif; ?>

            </ul>
        </div>
    </div>

    <div id="detail_t">
    	<form>
        	<select name="pie_city" id="pie_city" onchange="refresh_detail()" autocomplete="off">
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
        	<select name="pie_year" id="pie_year" onchange="change_day()" autocomplete="off">
               <?php $__FOR_START_571397512__=2012;$__FOR_END_571397512__=2018;for($temp=$__FOR_START_571397512__;$temp < $__FOR_END_571397512__;$temp+=1){ ?><option value="<?php echo ($temp); ?>" <?php if(($temp) == $detailDate->year): ?>selected="selected"<?php endif; ?> ><?php echo ($temp); ?> 年</option><?php } ?>
            </select>
            <select name="pie_month" id="pie_month" onchange="change_day()" autocomplete="off">
            	<?php $__FOR_START_458504632__=1;$__FOR_END_458504632__=13;for($temp=$__FOR_START_458504632__;$temp < $__FOR_END_458504632__;$temp+=1){ ?><option value="<?php echo ($temp); ?>" <?php if(($temp) == $detailDate->month): ?>selected="selected"<?php endif; ?> ><?php if(($temp) < "10"): ?>0<?php endif; echo ($temp); ?> 月</option><?php } ?>
            </select>
            <select name="pie_day" id="pie_day" onchange="refresh_detail()" autocomplete="off">
            	<option value='0'>选择日期</option>
            	<?php $__FOR_START_1337510057__=1;$__FOR_END_1337510057__=$detailDate->dayNum+1;for($temp=$__FOR_START_1337510057__;$temp < $__FOR_END_1337510057__;$temp+=1){ ?><option value="<?php echo ($temp); ?>" <?php if(($temp) == $detailDate->day): ?>selected="selected"<?php endif; ?> ><?php if(($temp) < "10"): ?>0<?php endif; echo ($temp); ?> 日</option><?php } ?>
            </select>
        </form>
    </div>


</div>
    <script type="text/javascript">
		var hot_word	=	<?php echo ($wordData); ?>;
		var hot_word_r	=	<?php echo ($wordRate); ?>;
		var pie_data	=	<?php echo ($pieData); ?>;
		var myPie;
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
        function(ec) {
        // 基于准备好的dom，初始化echarts图表
        		myPie = echarts.init(document.getElementById('pie_main'));
				var option = {
					title : {
					text: '',
					subtext: '',
					x:'center'
				},
				tooltip : {
					trigger: 'item',
					formatter: "{a} <br/>{b} : {c} ({d}%)"
				},
				legend: {
					orient : 'vertical',
					x : 'left',
					data:['乐','好','怒','哀','惧','恶','惊']
				},
				toolbox: {
					show : false,
					feature : {
						mark : {show: false},
						dataView : {show: false, readOnly: false},
						restore : {show: true},
						saveAsImage : {show: true},
					}

				},
				calculable : true,
				series : [
					{
						name:'情绪百分比',
						type:'pie',
						radius : '55%',
						center: ['30%', 225],
						data:[
							{value:pie_data[0], name:'乐'},
							{value:pie_data[1], name:'好'},
							{value:pie_data[2], name:'怒'},
							{value:pie_data[3], name:'哀'},
							{value:pie_data[4], name:'惧'},
							{value:pie_data[5], name:'恶'},
							{value:pie_data[6], name:'惊'}
						]
					}
				]
				};
			// 为echarts对象加载数据
			myPie.setOption(option);
		})
		</script>
    <script type="text/javascript">

		var myPie_Bar;
		// 路径配置
        require.config({
            paths:{
                'echarts' : 'js/echarts',
                'echarts/chart/bar' : 'js/echarts'
            }
        });

        // 使用
        require(
            [
                'echarts',
                'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
            ],
        function(ec) {
        // 基于准备好的dom，初始化echarts图表
        		myPie_Bar = echarts.init(document.getElementById('pie_right'));
				var option = {
					title : {
						text: '',
						subtext: ''
					},
					tooltip : {
						trigger: 'axis',
					},
					legend: {
						data:['情感强度']
					},
					toolbox: {
						show : false,
						feature : {
							mark : {show: true},
							magicType : {show: true, type: ['line', 'bar','stack','tiled']},
							restore : {show: true},
							saveAsImage : {show: true}
						}
					},
					calculable : true,
					dataZoom:{show:false},
					xAxis : [
						{
							type : 'category',
							//boundaryGap : false,
							<!------->
							position: 'bottom',
							boundaryGap: true,
							axisLine : {    // 轴线
								show: true,
								lineStyle: {
									color: 'green',
									type: 'solid',
									width: 2
								}
							},
							axisTick : {    // 轴标记
								show:true,
								length: 10,
								lineStyle: {
									color: 'red',
									type: 'solid',
									width: 2
								}
							},
							axisLabel : {
								show:true,
								interval: 'auto',    // {number}
								rotate: 0,
								margin: 8,
								textStyle: {
									color: 'blue',
									fontFamily: 'sans-serif',
									fontSize: 13,
									fontStyle: 'italic',
									fontWeight: 'bold'
								}
							},
							splitLine : {
								show:true,
								lineStyle: {
									color: '#483d8b',
									type: 'dashed',
									width: 1
								}
							},
							splitArea : {
								show: true,
								areaStyle:{
									color:['rgba(144,238,144,0.3)','rgba(135,200,250,0.3)']
								}
							},

							data : ['乐','好','怒','哀','惧','恶','惊']
						}

					],
					yAxis : [
						{
							type : 'value',
							axisLabel : {
								formatter: '{value} 分'
							},
							splitArea : {show : true}
						}
					],
					series : [
						{
							name:'情感强度',
							type:'bar',
							itemStyle: {
								normal: {
									lineStyle: {
										shadowColor : 'rgba(0,0,0,0.4)',
										shadowBlur: 5,
										shadowOffsetX: 3,
										shadowOffsetY: 3
									}
								}
							},
							data:[pie_data[0],pie_data[1],pie_data[2],pie_data[3],pie_data[4],pie_data[5],pie_data[6]]
						},

					]
				};
			// 为echarts对象加载数据
			myPie_Bar.setOption(option);
		})
		</script>
    <script type="text/javascript">

		var hotWord;
		// 路径配置
        require.config({
            paths:{
                'echarts' : 'js/echarts',
                'echarts/chart/bar' : 'js/echarts'
            }
        });

        // 使用
        require(
            [
                'echarts',
                'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
            ],
        function(ec) {
        // 基于准备好的dom，初始化echarts图表
        		myChart_hotWord = echarts.init(document.getElementById('hot_word'));
				var option = {
					title : {
						text: '当天热词',
						subtext: '数据来自红网',
						x:'left',
						y:'top'
					},
					tooltip : {
						trigger: 'item',
						formatter: '{a} : {b}'
					},
					toolbox: {
						show : true,
						feature : {
							restore : {show: true},
							saveAsImage : {show: true}
						}
					},
					legend: {
						x: 'left',
						data:['','']
					},
					series : [
						{
							type:'force',
							name : "人物关系",
							categories : [
								{
									name: '热词'
								},
								{
									name: '一级热度'
								},
								{
									name: '二级热度'
								}
							],
							itemStyle: {
								normal: {
									label: {
										show: true,
										textStyle: {
											color: '#333'
										}
									},
									nodeStyle : {
										brushType : 'both',
										strokeColor : 'rgba(255,215,0,0.4)',
										lineWidth : 1
									}
								},
								emphasis: {
									label: {
										show: false
										// textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
									},
									nodeStyle : {
										//r: 30
									},
									linkStyle : {}
								}
							},
							useWorker: false,
							minRadius : 15,
							maxRadius : 25,
							gravity: 1.1,
							scaling: 1.1,
							linkSymbol: 'arrow',
							nodes:[
								{category:0, name: '热词', value : 10},
								{category:1, name: hot_word[0],value : hot_word_r[0]},
								{category:1, name: hot_word[1],value : hot_word_r[1]},
								{category:1, name: hot_word[2],value : hot_word_r[2]},
								{category:2, name: hot_word[3],value : hot_word_r[3]},
								{category:2, name: hot_word[4],value : hot_word_r[4]},
								{category:2, name: hot_word[5],value : hot_word_r[5]},
								{category:2, name: hot_word[6],value : hot_word_r[6]},
								{category:2, name: hot_word[7],value : hot_word_r[7]},
								{category:2, name: hot_word[8],value : hot_word_r[8]},
								{category:2, name: hot_word[9],value : hot_word_r[9]}
							],
							links : [
								{source : hot_word[0], target : '热词', weight : 10},
								{source : hot_word[1], target : '热词', weight : 10},
								{source : hot_word[2], target : '热词', weight : 10},
								{source : hot_word[3], target : '热词', weight : 1},
								{source : hot_word[4], target : '热词', weight : 1},
								{source : hot_word[5], target : '热词', weight : 1},
								{source : hot_word[6], target : '热词', weight : 1},
								{source : hot_word[7], target : '热词', weight : 1},
								{source : hot_word[8], target : '热词', weight : 1},
								{source : hot_word[9], target : '热词', weight : 1},

								{source : hot_word[3], target : hot_word[0], weight : 1},
								{source : hot_word[4], target : hot_word[0], weight : 1},
								{source : hot_word[5], target : hot_word[0], weight : 1},
								{source : hot_word[6], target : hot_word[1], weight : 1},
								{source : hot_word[7], target : hot_word[1], weight : 1},
								{source : hot_word[8], target : hot_word[2], weight : 6},
								{source : hot_word[9], target : hot_word[2], weight : 1}
							]
						}
					]
				};
				var ecConfig = require('echarts/config');
				function focusx(param) {
					var data = param.data;
					var links = option.series[0].links;
					var nodes = option.series[0].nodes;
					if (
						data.source !== undefined
						&& data.target !== undefined
					) { //点击的是边
						var sourceNode = nodes[data.source];
						var targetNode = nodes[data.target];
						console.log("选中了边 " + sourceNode.name + ' -> ' + targetNode.name + ' (' + data.weight + ')');
					} else { // 点击的是点
						console.log("选中了" + data.name + '(' + data.value + ')');
					}
					console.log(param);
				}
				myChart_hotWord.on(ecConfig.EVENT.CLICK, focusx)     ;
			// 为echarts对象加载数据
			myChart_hotWord.setOption(option);
		})
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