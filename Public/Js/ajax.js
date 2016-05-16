//获取主机地址，如：//localhost:8080
var host=window.document.location.href.substring(0,window.document.location.href.indexOf(window.document.location.pathname));
var indexAjaxHome=host+"/index.php/Home/Index/";

function refresh_line(){

	var xmlhttp;
	var city  = $("#line_city").val();
	var	year  = $("#line_year").val();
	var	month = $("#line_month").val();
	var str="city="+city+"&y="+year+"&m="+month;

	$.post(indexAjaxHome+"refreshLine",{c:city,y:year,m:month},function(data){

		var a=eval(data);
		var t=a[0],title=a[1],d1=a[2],d2=a[3],d3=a[4],d4=a[5],d5=a[6],d6=a[7],d7=a[8];
		var ser={time:t,title:title,d1:d1,d2:d2,d3:d3,d4:d4,d5:d5,d6:d6,d7:d7};
		$("#line_title_main").html(ser.title);
		option_line.toolbox.feature={
			    mark : {show : false},
			    dataZoom : {show : false},
			    dataView : {show : false},
			    magicType: {show : false},
			    restore : {show : false},
			    saveAsImage : {show : false}
		};
		option_line.xAxis[0].data=ser.time;

		option_line.legend.data="乐";
		option_line.series[0].name="乐";
		option_line.series[0].data=ser.d1;
		option_line.series[0].itemStyle.normal.lineStyle.color='';
		myChart_line_le.setOption(option_line);

		option_line.legend.data="好";
		option_line.series[0].name="好";
		option_line.series[0].data=ser.d2;
		option_line.series[0].itemStyle.normal.lineStyle.color='#ffcccc';
		myChart_line_hao.setOption(option_line);

		option_line.legend.data="怒";
		option_line.series[0].name="怒";
		option_line.series[0].data=ser.d3;
		option_line.series[0].itemStyle.normal.lineStyle.color='#ffd700';
		myChart_line_nu.setOption(option_line);

		option_line.legend.data="哀";
		option_line.series[0].name="哀";
		option_line.series[0].data=ser.d4;
		option_line.series[0].itemStyle.normal.lineStyle.color='blue';
		myChart_line_ai.setOption(option_line);

		option_line.legend.data="惧";
		option_line.series[0].name="惧";
		option_line.series[0].data=ser.d5;
		option_line.series[0].itemStyle.normal.lineStyle.color='#b88898';
		myChart_line_ju.setOption(option_line);

		option_line.legend.data="恶";
		option_line.series[0].name="恶";
		option_line.series[0].data=ser.d6;
		option_line.series[0].itemStyle.normal.lineStyle.color='green';
		myChart_line_wu.setOption(option_line);

		option_line.legend.data="惊";
		option_line.series[0].name="惊";
		option_line.series[0].data=ser.d7;
		option_line.series[0].itemStyle.normal.lineStyle.color='#4D4DFF';
		myChart_line_jing.setOption(option_line);
	});
}
function refresh_detail(){

	if($("#pie_day").val()==0){
		return 1;
	}
	var city=$("#pie_city").val();
	var	year=$("#pie_year").val();
	var	month=$("#pie_month").val();
	var	day=$("#pie_day").val();
	switch(city){
		case '3' : cname="长沙市";break;
		case '2' : cname="株洲市";break;
		case '7' : cname="湘潭市";break;
		case '5' : cname="衡阳市";break;
		case '10' : cname="岳阳市";break;
		case '4' : cname="益阳市";break;
		case '9' : cname="常德市";break;
		case '12' : cname="邵阳市";break;
		case '13' : cname="娄底市";break;
		case '8': cname="永州市";break;
		case '11': cname="郴州市";break;
		case '6': cname="怀化市";break;
		case '14': cname="湘西州";break;
		case '1': cname="张家界";break;
		default  : cname="xxx";  break;
	}
	$.post(indexAjaxHome+"refreshDetail",{c:city,y:year,m:month,d:day},function(data){

		a=eval(data);
		var pie=a[0],w=a[1],article=a[2];
		if(pie[0]!=null)
		{
			$("#pie_title").html(cname+" "+year+"年"+month+"月"+day+"日 情感调查数据详情");
			//pie图
			var option=myPie.getOption();
			for(var i=0;i<=6;i++){
				option.series[0].data[i].value=pie[i];
			}
			myPie.setOption(option);
			option=myPie_Bar.getOption();

			if(pie[0]==1&&pie[1]==0&&pie[2]==0&&pie[3]==0&&pie[4]==0&&pie[5]==0&&pie[6]==0){
				option.series[0].data=[0,0,0,0,0,0,0];
				$("#inf").html("暂无该地当天数据");
			}else{option.series[0].data=pie;$("#inf").html("");}
			myPie_Bar.setOption(option);
			//热词
			option=myChart_hotWord.getOption();
			for(var i=0;i<10;i++){
				option.series[0].nodes[i+1].name=w[i][0];
				option.series[0].nodes[i+1].value=w[i][1];

				option.series[0].links[i].source=w[i][0];
			}
			for(;i<17;i++){
				option.series[0].links[i].source=w[i-7][0];
			}
			for(var i=10;i<13;i++){
				option.series[0].links[i].target=w[0][0];
			}
			for(var i=13;i<15;i++){
				option.series[0].links[i].target=w[1][0];
				option.series[0].links[i+2].target=w[2][0];
			}
			myChart_hotWord.setOption(option);

			//文章
			var article_div="";
			for(var i=0;article[i]!=null&&i<13;i++)
			{
				var str="<li><div id='article_title'><a target='_blank' href='"+article[i][1]+"'>"+article[i]+"</a></div><div id='article_inf'><div class=\"left\">回复数:"+article[i][2]+"</div><div class=\"right\">Time:"+article[i][3]+"<div></div></li>";
				article_div+=str;
			}
			$("#ul_article ul").html(article_div);
		}else{
			alert("无 "+cname+" "+year+"年"+month+"月"+day+"日数据");
		}
	});
}
function showLineAllT(){

	var o=$("#all_opinion").val();
	var c=$("#all_city").val();
	var cname;
	switch(c){
		case '1' : cname="长沙市";break;
		case '2' : cname="株洲市";break;
		case '3' : cname="湘潭市";break;
		case '4' : cname="衡阳市";break;
		case '5' : cname="岳阳市";break;
		case '6' : cname="益阳市";break;
		case '7' : cname="常德市";break;
		case '8' : cname="邵阳市";break;
		case '9' : cname="娄底市";break;
		case '10': cname="永州市";break;
		case '11': cname="郴州市";break;
		case '12': cname="怀化市";break;
		case '13': cname="湘西州";break;
		case '14': cname="张家界";break;
		default  : cname="xxx";  break;
	};
	switch(o){
		case "cps":	opName="总";break;
		case 'happy':		opName="喜";break;
		case 'good':		opName="好";break;
		case 'anger':		opName="怒";break;
		case 'sorrow':		opName="哀";break;
		case 'fear':		opName="惧";break;
		case 'evil':		opName="恶";break;
		case 'surprise':	opName="惊";break;
	};
	$.post(indexAjaxHome+"refreshAll",{o:o,c:c},function(data){

		xmldoc=eval(data);
		option_line.legend.data[0]=o;
		option_line.series[0].name=o;

		option_line.series[0].data=xmldoc[0];
		option_line.xAxis[0].data=xmldoc[1];

		myChart_line_main.setOption(option_line);
		$("#city").html(cname);
		$("#opinion").html(opName);
	});
}
/*忘记密码*/
function FCheckAccount(){

	var ac=$("#account").val();
	var em=$("#email").val();
	var str =	"ac="+ac;
	var flag=false;

	if(em==""){
		$("#tipe").html("");
	}else{
		FCheckEmail();
	}

	if(ac=="")
	{
		$("#tipa").html("<font style=\"color:red;\">不能为空！");
		return false;
	}else{
		var preg=/\s+/;
		if(ac.match(preg)){
			console.log("ok");
		}else{
			$.ajax({
				type:'post',
				url:host+'/index.php/Home/Login/checkAccount',
				data:{ac:ac},
				async:false,
				success:function(data){
					xmldoc=data;
					if(xmldoc==false){
						$("#tipa").html("账户可找回密码");
						flag=true;
					}
					else{
						if(xmldoc==true){
							$("#tipa").html("<font style=\"color:red;\">账户不存在</font>");flag=false;
						}else{
							alert(xmldoc);
						}
					}
				}
			});
		}
	}
	return flag;
}
function FCheckEmail(){

	var ac=$("#account").val();
	var em=$("#email").val();
	var myreg 	=  /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

	if(ac==""){alert("请先填写账号！");return false;}
	var flag=false;
	if(!myreg.test(em)){
		$("#tipe").html("<font style=\"color:red;\">格式错误！");
		return false;
	}else{
		$.ajax({
			type:'post',
			url:indexAjaxHome+'cmpAccountAndEmail',
			data:{account:ac,email:em},
			async:false,
			success:function(data){
				xmldoc=data;
				if(xmldoc==true){
					$("#tipe").html("账号邮箱匹配！");
					flag=true;
				}
				else{
					if(xmldoc==false){
						$("#tipe").html("<font style=\"color:red;\">账户邮箱不一致!</font>");
						flag=false;
					}else{
						alert(xmldoc);
					}
				}
			}
		});
	}
	return flag;
}
function setNewPsw(){

	var email=$("#email").val();
	var account=$("#account").val();
	var checkCode=$("#checkCode").val();
	var password=$("#password").val();
	if(!(FCheckAccount()&&FCheckEmail())){
		alert("请先确认账号邮箱匹配！");return false;
	}
	$.ajax({
		type:'post',
		url:indexAjaxHome+'setNewPsw',
		data:{email:email,account:account,checkCode:checkCode,password:password},
		async:false,
		success:function(data){
			xmldoc=data;
			if(xmldoc==true){
				alert("更改成功！");
				window.location.href=indexAjaxHome;
			}
			else{alert(data);}
		}
	});
}
function getEmailCheckCode(){

	var email=$("#email").val();
	var account=$("#account").val();
	if(!(FCheckAccount()&&FCheckEmail())){
		alert("请先确认账号邮箱匹配！");return false;
	}
	$.ajax({
		type:'post',
		url:indexAjaxHome+'sendEmailCheckCode',
		data:{email:email,account:account},
		async:false,
		success:function(data){
			xmldoc=data;
			if(xmldoc==true){

				alert("发送成功！请注意查看邮箱！");
				unSendBtn(60);
			}
			else{
				if(xmldoc==false){
					alert(xmldoc);
				}else{
					alert(xmldoc);
				}
			}
		}
	});
}
function unSendBtn(time){

	LockBtn("SendCheckCode");
	$("#tipc").html(time+" s后可重新发送！");
	if(time==0){
		UnlockBtn("SendCheckCode");
		$("#tipc").html("");
		return true;
	}
	time--;
	window.setTimeout("unSendBtn("+time+")",1000);
}
function LockBtn(id){
	var obj=$("#"+id);
	obj.attr("disabled","disabled");
}
function UnlockBtn(id){
	var obj=$("#"+id);
	obj.removeAttr("disabled");
}



