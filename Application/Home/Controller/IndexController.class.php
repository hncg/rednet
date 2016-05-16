<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
use Home\Model\FeelModel;
use Home\Model\ArticleWordModel;
use Home\Model\DateNow;
use Home\Model\UserModel;
use Home\Model\ForecastModel;

class IndexController extends Controller {
    public function index(){

    	$this->redirect("Home/Index/map");
    }
    /*
     *
     *
     */
    public function map(){
    	$this->recordInf();
    	$temp1=I("get.opinion");$temp2=I("session.opinion");
            if($this->getOpinion($temp1)){$opinion=$temp1;$_SESSION["opinion"]=$opinion;}
    	elseif($this->getOpinion($temp2)){$opinion=$temp2;$_SESSION["opinion"]=$opinion;}
    	else{$opinion="cps";$_SESSION["opinion"]=$opinion;}

    	$dateNow=new DateNow();
		$feel=new FeelModel();
		$feel->getWeekData($opinion);
        /*********	    	数据		**************/
    	$this->assign("weekData",json_encode($feel->weekData));
    	$this->assign("opinion",$opinion);
    	$this->assign("opinionZH",$this->getOpinion($opinion));

    	/*********		用户信息		**************/
    	$this->assign("user",M('user')->field('password',true)->where(array('account'=>I("SESSION.account")))->find());
    	$this->assign("dateNow",$dateNow);

		/*********	    	结束		**************/
        $this->display();
    }
    public function bar(){
    	$this->recordInf();

    	$temp1=I("get.opinion");$temp2=I("session.opinion");
    	if($this->getOpinion($temp1)){$opinion=$temp1;$_SESSION["opinion"]=$opinion;}
    	elseif($this->getOpinion($temp2)){$opinion=$temp2;$_SESSION["opinion"]=$opinion;}
    	else{$opinion="cps";$_SESSION["opinion"]=$opinion;}

    	$dateNow=new DateNow();
    	$feel=new FeelModel();
    	$feel->getWeekData($opinion);
    	/*********	    	数据		**************/
    	$this->assign("weekData",json_encode($feel->weekData));
    	$this->assign("opinion",$opinion);
    	$this->assign("opinionZH",$this->getOpinion($opinion));

    	/*********		用户信息		**************/
    	$this->assign("user",M('user')->field('password',true)->where(array('account'=>I("SESSION.account")))->find());
    	$this->assign("dateNow",$dateNow);

		/*********	    	结束		**************/
    	$this->display();
    }
    public function line(){
        $this->recordInf();
    	$dateNow=new DateNow();

    	$feel=new FeelModel();
    	$feel->getMonthData();
    	/*********	    	数据		**************/
    	$this->assign("line_x",json_encode($feel->monthList));
		$this->assign("line_le",json_encode($feel->monthData["happy"]));
		$this->assign("line_hao",json_encode($feel->monthData["good"]));
		$this->assign("line_nu",json_encode($feel->monthData["anger"]));
		$this->assign("line_ai",json_encode($feel->monthData["sorrow"]));
		$this->assign("line_ju",json_encode($feel->monthData["fear"]));
		$this->assign("line_wu",json_encode($feel->monthData["evil"]));
		$this->assign("line_jing",json_encode($feel->monthData["surprise"]));

    	/*********		用户信息		**************/
    	$this->assign("user",M('user')->field('password',true)->where(array('account'=>I("SESSION.account")))->find());
    	$this->assign("dateNow",$dateNow);
    	/**********			其他			**********/
    	$this->assign("cityZH",getCityDepAnumber(1));
    	/*********	    	结束		**************/
    	$this->display();
    }
    public function jh(){

    	$dateNow=new DateNow();
    	$articleWord	=	new ArticleWordModel();
    	$articleWord->getArticle();
    	/*********		精华帖子		**************/
    	$this->assign("jh",$articleWord->article15 );
    	/*********		用户信息		**************/
    	$this->assign("user",M('user')->field('password',true)->where(array('account'=>I("SESSION.account")))->find());
    	$this->assign("dateNow",$dateNow);

    	/*********	    	结束		**************/
    	$this->display();
    }
    public function detail(){
    	$this->recordInf();
    	{
    		$c=I("get.city");$y=I("get.year");$m=I("get.month");$d=I("get.day");
    		if($c&&$y&&$m&&$d){
    			$detailDate=new DateNow($y,$m,$d);
    			$_SESSION["detailc"]=$c;$_SESSION["detaily"]=$y;
    			$_SESSION["detailm"]=$m;$_SESSION["detaild"]=$d;
    		}elseif($_SESSION["detailc"]){
    			$detailDate=new DateNow($_SESSION["detaily"],$_SESSION["detailm"],$_SESSION["detaild"]);
    			$c=$_SESSION["detailc"];
    		}else{$detailDate=new DateNow();$c=1;}
    	}

    	$articleWord	=	new ArticleWordModel($c,$detailDate->year,$detailDate->month,$detailDate->day);
    	$articleWord->getArticle();
    	$articleWord->getWord();
    	$articleWord->getPieData();
    	$dateNow=new DateNow();


    	/*********		精华帖子		**************/
    	$this->assign("pieData",json_encode($articleWord->pieData));
    	$this->assign("wordRate",json_encode($articleWord->rate));
    	$this->assign("wordData",json_encode($articleWord->word));
    	$this->assign("articleData",$articleWord->article);

    	/*********		用户信息		**************/
    	$this->assign("user",M('user')->field('password',true)->where(array('account'=>I("SESSION.account")))->find());
    	$this->assign("dateNow",$dateNow);
    	$this->assign("detailDate",$detailDate);
    	$this->assign("city",$c);
    	$this->assign("cityZH",getCityDepAnumber($c));
    	/*********	    	结束		**************/
    	$this->display();
    }
    public function all(){

    	$this->recordInf();
    	{
    		$city=I("get.city");$opinion=I("get.opinion");
    		if($city&&$opinion){
    			$_SESSION["allcity"]=$city;
    			$_SESSION["allopinion"]=$opinion;
    		}elseif(I("session.allcity")){
    			$city=I("session.allcity");
    			$opinion=I("session.allopinion");
    		}else{
    			$city=1;$opinion="cps";
    			$_SESSION["allcity"]=$city;
    			$_SESSION["allopinion"]=$opinion;
    		}
    	}

    	$feel	=	new FeelModel($city);
    	$feel->getAllData($opinion);
    	$dateNow=new DateNow();

    	/*********		所有数据		**************/
    	$this->assign("allLineData",json_encode($feel->allData));
    	$this->assign("allList",json_encode($feel->allList));

    	/*********		用户信息		**************/
    	$this->assign("user",M('user')->field('password',true)->where(array('account'=>I("SESSION.account")))->find());
    	$this->assign("dateNow",$dateNow);
    	/**************		其他		*************/
    	$this->assign("city",$city);
    	$this->assign("cityZH",getCityDepAnumber($city));
    	$this->assign("opinion",$opinion);
    	$this->assign("opinionZH",$this->getOpinion($opinion));
    	$this->display();
    }
    public function compare(){
    	if(I("get.fore","")>0&&I("get.fore","")<15){
    		session("comcity",null);session("comyear",null);session("commonth",null);
    	}
    	$this->recordInf();$flag=1;
    	if(I("get.city")&&I("get.year")&&I("get.month")){
    		$_SESSION["comcity"]	=	I("get.city");	$city	=I("get.city");
    		$_SESSION["comyear"]	=	I("get.year");	$year	=I("get.year");
    		$_SESSION["commonth"]	=	I("get.month");	$month	=I("get.month");
    	}elseif($_SESSION["comcity"]){
    		$city=$_SESSION["comcity"];$year=$_SESSION["comyear"];$month=$_SESSION["commonth"];
    	}else{$flag=0;}
    	if($flag){
    		$forecast=new ForecastModel($city,$year,$month);
    	}else{
    		$forecast=new ForecastModel(I("get.fore"));$date=explode("-", date("Y-m-d",time()));
    		$city=I("get.fore");			$year=$date[0];
    		$month=$date[1];	$day=$date[2];
    	}

    	/*********		所有数据		**************/
    	$this->assign("cym",array(
    			"city"=>getCityDepAnumber($city),
    			"ci"=>$city,
    			"year"=>$year,"month"=>$month,
    			"nowyear"=>date("Y",time()))
    	);
    	$this->assign("monthList",json_encode($forecast->monthList));
    	$this->assign("monthData",json_encode($forecast->monthData));
    	$this->assign("fectData", json_encode($forecast->fectData));

    	$this->display();
    }
    /*
     *
     * 		AJAX
     *
     */
    public function refreshLine(){
    	$c=I("POST.c");
    	$y=I("POST.y");
    	$m=I("POST.m");
    	if(empty($c)||empty($y)||empty($m)){$this->error("页面错误！",U("Home/Index/index"),2);}

    	$feel=new FeelModel($c,$y,$m,'',false);$feel->getMonthData();
    	switch($c)
		{
			case '1' : $cname="长沙市";break;case '2' : $cname="株洲市";break;case '3' : $cname="湘潭市";break;
			case '4' : $cname="衡阳市";break;case '5' : $cname="岳阳市";break;case '6' : $cname="益阳市";break;
			case '7' : $cname="常德市";break;case '8' : $cname="邵阳市";break;case '9' : $cname="娄底市";break;
			case '10': $cname="永州市";break;case '11': $cname="郴州市";break;case '12': $cname="怀化市";break;
			case '13': $cname="湘西州";break;case '14': $cname="张家界";break;
		}
		$temp[0]=$feel->monthList;
		$temp[1]=$cname." ".$y." 年 ".$m." 月 七种情感变化趋势";
		$temp[2]=$feel->monthData["happy"];
		$temp[3]=$feel->monthData["good"];
		$temp[4]=$feel->monthData["anger"];
		$temp[5]=$feel->monthData["sorrow"];
		$temp[6]=$feel->monthData["fear"];
		$temp[7]=$feel->monthData["evil"];
		$temp[8]=$feel->monthData["surprise"];
		echo json_encode($temp);
    }
    public function refreshDetail(){
    	$c=I("POST.c");
    	$y=I("POST.y");
    	$m=I("POST.m");
    	$d=I("POST.d");
    	if(empty($c)||empty($y)||empty($m)||empty($d)){$this->error("页面错误！",U("Home/Index/index"),2);}

    	$artWord	= 	new ArticleWordModel($c,$y,$m,$d);
    	$artWord->getPieData();
    	$artWord->getWord();
    	$artWord->getArticle();

    	$article=array();
    	for($i=0,$max=count($artWord->article);$i<$max;$i++){
    		$t_y=$artWord->article[$i]['year'];$t_m=$artWord->article[$i]['month'];$t_d=$artWord->article[$i]['day'];
    		if($t_m<10)$t_m='0'.$t_m;	if($t_d<10)$t_d='0'.$t_d;
    		$str=$artWord->article[$i]['time_at'];
    		$article[$i]=array($artWord->article[$i]["title"],$artWord->article[$i]["url"],$artWord->article[$i]["reply_number"],$str);
    	}
    	$word=array();
    	for($i=0;$i<10;$i++){
    		$word[$i][0]=$artWord->word[$i];
    		$word[$i][1]=$artWord->rate[$i];
    	}
    	$temp=array($artWord->pieData,$word,$article);
    	{
	    	$_SESSION["detailc"]=$c;$_SESSION["detaily"]=$y;
	    	$_SESSION["detailm"]=$m;$_SESSION["detaild"]=$d;
    	}
    	echo json_encode($temp);
    }
    public function refreshAll(){

    	$c	=	I("POST.c");
		$o	=	I("POST.o");
		if(empty($c)||empty($o)){$this->error("页面错误！",U("Home/Index/index"),2);}

		$feel=new FeelModel($c);
		$feel->getAllData($o);
		$temp=array($feel->allData,$feel->allList);
		{
			$_SESSION["allcity"]=$c;
			$_SESSION["allopinion"]=$o;
		}
		echo json_encode($temp);
    }
    /**		找回密码判断邮箱	*****/
    public function cmpAccountAndEmail(){

    	if(!I("post.account","")){
    		$this->error("错误页面!",U("Home/Index/index"));die();
    	}else{}
    	$data["account"]=I("post.account","");
    	$data["email"]=I("post.email","");

    	$user=new UserModel();
    	$data=$user->where($data)->find();
    	//dump ($data);
    	if(!data||!isset($data)){echo false;}else{echo true;}
    }
    public function sendEmailCheckCode(){

    	$checkCode = rand(100000, 999999);
    	$account   = I('post.account','');
    	$email	   = I('post.email','');
    	$md=checkCodeMd20($checkCode);
    	setcookie($account,$md,time()+60*30);
    	//send_checkCode_mail("275176761@qq.com", "", $checkCode);
    	echo send_checkCode_mail($email, "", $checkCode);
    	//mail($to, $subject, $message);
    }
    public function setNewPsw(){
    	$account   = I('post.account','');
    	$email	   = I('post.email','');
    	$checkCode = I('post.checkCode');
    	$password  = I('post.password');
    	$md=checkCodeMd20($checkCode);
    	if($md==$_COOKIE[$account]){
    		$_SESSION['account']=$account;
    		setcookie($account,"",time()-3600);
    		M('user')->where('account="'.$account.'"')->save(array('password'=>pswMd($password)));
    		echo true;
    	}else{
    		setcookie($account,"",time()-3600);
    		echo false;
    	}
    }
    /*****		访客信息 		******/
    private function recordInf(){
    	$sb=I("session.sb",'0');
    	if($sb==2){return 1;}
    	if($sb==0){
    		$data=$this->getInf();
    		M("visitrecord")->data($data)->add();
    		$_SESSION['sb']=I("session.account")?2:1;
    	}else{
    		if(I("session.account")){
	    		$data=$this->getInf();
	    		M("visitrecord")->data($data)->add();
	    		$_SESSION['sb']=2;
    		}
    	}
    	return 1;
    }
    private function getInf(){

    	$inf=array();
    	$inf['time']	=	time();
    	$inf['ip']		=	get_client_ip(0);
    	$inf['account']	=	I('session.account','');
		return $inf;
    }
    private function getOpinion($opinion){
    	switch ($opinion){
    		case "cps":	return "综合";
    		case "happy":		return "喜";
    		case "good":		return "好";
    		case "anger":		return "怒";
    		case "sorrow":		return "哀";
    		case "fear":		return "惧";
    		case "evil":		return "恶";
    		case "surprise":	return "惊";
    		default:return "";
    	}
    }
}







