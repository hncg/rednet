<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>红网情感数据监控网后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
    <META HTTP-EQUIV="pragma" CONTENT="no-cache">
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-store, must-revalidate">
	<META HTTP-EQUIV="expires" CONTENT="0">
	<link rel="stylesheet" type="text/css" href="/Public/Css/admin/forecast.css" />
    <script type="text/javascript" src="/Public/Js/echarts-plain-map.js"></script>
    <script type="text/javascript" src="/Public/Js/esl.js"></script>
</head>
<body>
	<div id="main">
		<div id="city">
			<ul>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=1');?>">长沙市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=2');?>">株洲市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=3');?>">湘潭市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=4');?>">衡阳市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=5');?>">岳阳市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=6');?>">益阳市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=7');?>">常德市</a></li>

				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=8');?>">邵阳市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=9');?>">娄底市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=10');?>">永州市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=11');?>">郴州市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=12');?>">怀化市</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=13');?>">湘西州</a></li>
				<li><a href="<?php echo U('Admin/Forecast/lookfore?ci=14');?>">张家界</a></li>
			</ul>
		</div>
    	<div id="line"></div>
	</div>
    <script type="text/javascript">
    var xList=<?php echo ($dayList); ?>;
	var yList=<?php echo ($dayData); ?>;
	var length=xList.length;
	{
		xList[length]	   ="-";	xList[length+1]		=	"上阈值";
		yList[length]  	   ="-";	yList[length+1]		=	15;

		xList[length+2]	   ="-";	xList[length+3]		=	"下阈值";
		yList[length+2]    ="-";	yList[length+3]		=	-15;
	}
    </script>
    <script type="text/javascript">

        // 路径配置

        require.config({
            paths:{
                'echarts' : '/Public/Js//echarts',
                'echarts/chart/bar' : '/Public/Js//echarts'
            }
        });
		option = {
			title : {
				text: '<?php echo ($city); ?>未来<?php echo ($n); ?>天综合情感预测',
				subtext: '  Y=lg(情感值)'
			},
			tooltip : {
				trigger: 'axis'
			},
			legend: {
				data:["cps"],
			},
			toolbox: {
				show : true,
				feature : {
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
					y: 460,
					height: 20,
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
				data:yList
			}
			]
		};//end option
		require([
				'echarts',
				'echarts/chart/line',
				'echarts/chart/bar'
				],
				function (ec) {
					myChart_line_main = ec.init(document.getElementById('line'));
					myChart_line_main.setOption(option);
				}
		);

    </script>
</body>
<html>