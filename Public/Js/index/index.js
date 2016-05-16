var host=window.document.location.href.substring(0,window.document.location.href.indexOf(window.document.location.pathname)); 
var HomeLogin=host+"/index.php/Home/Login/";
function change_day(){
		
		var year=$("#pie_year").val(),
			month=$("#pie_month").val();
		var k=judge_day(month,year),daylist;
		var day28="<option value='0'>选择日期</option><option value='1'> 01 日</option><option value='2'> 02 日</option><option value='3'> 03 日</option><option value='4'> 04 日</option><option value='5'> 05 日</option><option value='6'> 06 日</option><option value='7'> 07 日</option><option value='8'> 08 日</option><option value='9'> 09 日</option><option value='10'> 10 日</option><option value='11'>  11 日</option><option value='12'> 12 日</option><option value='13'> 13 日</option><option value='14'> 14 日</option><option value='15'> 15 日</option><option value='16'> 16 日</option><option value='17'> 17 日</option><option value='18'> 18 日</option><option value='19'> 19 日</option><option value='20'> 20 日</option><option value='21'> 21 日</option><option value='22'> 22 日</option><option value='23'> 23 日</option><option value='24'> 24 日</option><option value='25'> 25 日</option><option value='26'> 26 日</option><option value='27'> 27 日</option><option value='28'> 28 日</option>";
		var day29=day28+"<option value='29'> 29 日</option>";
		var day30=day29+"<option value='30'> 30 日</option>";
		var day31=day30+"<option value='31'> 31 日</option>";
		
		if(k==31)daylist=day31;
		if(k==30)daylist=day30;
		if(k==29)daylist=day29;
		if(k==28)daylist=day28;
		$("#pie_day").html(daylist);/* */
}
function judge_day(Month,y){
	if(Month==2){
		var k=((y%4==0&&y%100!=0)||y%400==0)?1:0;
		return 28+k;	
	}else if(Month==4||Month==6||Month==9||Month==11){
		return 30;
	}return 31;
}
function goto_detail(xName){
	
	var date=xName.match(/[0-9]+/ig);
	window.location.href="/index.php/Home/Index/detail/city/"+$("#line_city").val()+"/year/"+date[0]+"/month/"+date[1]+"/day/"+date[2];
}
function goto_all_line(){
	$("#myTab li:eq(5) a").tab('show');
	window.scrollTo(0,120);
}
/***** Login控制器  ******/
function checkAccount(){

		var ac	=	$("#account").val();
		var str =	"ac="+ac;
		var flag=false;
		if(ac=="")
		{
			$("#idt").html("<font style=\"color:red;\">不能为空！");
			return false;
		}else{
			var preg=/\s+/;
			if(ac.match(preg)){
				console.log("ok");
			}else{
				$.ajax({
					type:'post',
					url:HomeLogin+'checkAccount',
					data:{ac:ac},
					async:false,
					success:function(data){
						xmldoc=data;
						if(xmldoc==false){
							$("#idt").html("<font style=\"color:red;\">账户已存在</font>");
						}
						else{
							if(xmldoc==true){
								$("#idt").html("可用");flag=true;
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
function checkPswd(){
	var $ps1=$("#pswd1").val();
	var $ps2=$("#pswd2").val();
	if($ps1==$ps2&&$ps1==""){
		$("#p1t").html("<font style='color:red;'>不能为空</font>");
		$("#p2t").html("<font style='color:red;'>不能为空</font>");
		return false;
	}
	if($ps1!=$ps2){
		$("#p1t").html("<font style='color:red;'>密码不一致</font>");
		$("#p2t").html("<font style='color:red;'>密码不一致</font>");
		return false;
	}
	if($ps1.length<6){
		$("#p1t").html("<font style='color:red;'>密码小于六位</font>");
		$("#p2t").html("<font style='color:red;'>密码小于六位</font>");
		return false;
	}
	$("#p1t").html("");
	$("#p2t").html("");
	return true;
}
function checkEmail(){
	
		var myreg 	=  /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/
		var email	=  $("#email").val();
		if(email=="")
		{
			$("#emt").html("<font style=\"color:red;\">不能为空！</font>");
			return false;
		}
		if(myreg.test(email))
		{
			$("#emt").html("");
			return true;
		}
		else{
			$("#emt").html("<font style=\"color:red;\">格式错误！</font>");
			return false;
		}
		return false;
}
function checkNetName(){
	var name=$("#name").val();
	if(name==""){
		$("#nat").html("<font style=\"color:red;\">不能为空</font>");
		return false;
	}
	if(name.length>8){
		$("#nat").html("<font style=\"color:red;\">超过八个字符</font>");
		return false;
	}
	$("#nat").html("");
	return true;
}
function check_register_form(){
	
	if(checkAccount()){
		if( checkPswd() ){
			if( checkEmail() ){
				if(checkNetName()){
					return true;
				}
			}
		}
	}
	return false;
}
/*****   下载数据    ********/
function download_data(){
	
	var flag=1;
	$.post(host + '/index.php/Home/DownloadData/index', {flag:1}, function(data){
		var preg=/.csv/;
		if (preg.test(data)) {
			window.location.href = data;
		}
		else {
			alert(data);
		}		
	});
}
function switchToTab(tab){
	window.location.href="/index.php/Home/Index/"+tab;
}
function lookCompare(){
	var ci=document.getElementsByName("ci")[0].value;
	var ye=document.getElementsByName("ye")[0].value;
	var mo=document.getElementsByName("mo")[0].value;
	var uUrl="/index.php/Home/Index/compare/city/"+ci+"/year/"+ye+"/month/"+mo;
	window.location.href=uUrl;
}
function lookCompareFore(){
	var ci=document.getElementsByName("ci")[0].value;//alert("");
	var uUrl="/index.php/Home/Index/compare/fore/"+ci;
	window.location.href=uUrl;
}
/////***********************//////


