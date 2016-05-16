<?php
namespace Admin\Controller;

use Think\Controller;
use Home\Model\FeelModel;
use Home\Model\DateNow;
use Admin\Model\ForecastModel;
class ForecastController extends Controller{

	private $t=0.6;
	public $foredata;
	public $n=31;				//默认显示预测接下来n天的
	public $foredays=30;		//向前取foredays天的数据
	private $fm=465;				//权重分母
	public function fore(){

		if(!check_admin())die();
		switch(I('get.m')){
			case 1:$tmpl='lookfore';$this->lookfore();break;
			case 2:$tmpl='lookfect';$this->lookfect();break;
			case 3:$tmpl='compare' ;$this->compare() ;break;
			default:$this->error("出现错误！",U('Admin/Index/main'));die();
		}
		//$this->redirect("Admin/Forecast/".$tmpl);
		//$this->display("main:fore/".$tmpl);
	}

	/***
	*
	* fore   页面入口
	*
	* ***/
	public function lookfore(){
		if(!$this->check_login())die();
		if(UpdateOrNotFore()){
			$this->startForecastN();;
		}
		$city=I("get.ci",1);
		$date=$this->getLatestDate();
		$temp=new ForecastModel($city,$date["year"],$date["month"],$date["day"],$this->n);

		$this->assign("city",getCityDepAnumber($city));
		$this->assign("n",$this->n);
		$this->assign("dayList",json_encode($temp->dayList));
		$this->assign("dayData",json_encode($temp->dayData));

		$this->display("main:fore/".__FUNCTION__);
	}
	public function lookfect(){
		if(!$this->check_login())die();
		$this->display("main:fore/".__FUNCTION__);
	}
	public function compare(){
		if(!$this->check_login())die();
		$date=$this->getLatestDate();
		if($date[month]==1){
			$year	=	$date["year"]-1;
			$month	=	12;
		}else{
			$year	=	$date["year"];
			$month	=	$date["month"]-1;
		}
		$city=I("get.ci",1);$year=I("get.ye",$year);$month=I("get.mo",$month);
		$compareData=new ForecastModel($city,$year,$month);

		$this->assign("cym",array(
				"city"=>getCityDepAnumber($city),
				"ci"=>$city,
				"year"=>$year,"month"=>$month,
				"nowyear"=>date("Y",time()))
		);
		$this->assign("monthList",json_encode($compareData->monthList));
		$this->assign("monthData",json_encode($compareData->monthData));
		$this->assign("fectData",json_encode($compareData->fectData));
		$this->display("main:fore/".__FUNCTION__);
	}
	/*
	 * 获取数据库最新数据日期  预测将来n天
	*/
	public function getLatestDate(){
		return M("feel")->field("year,month,day")->order("year DESC,month DESC,day DESC")->find();
		//dump(M("feel")->field("year,month,day")->order("year DESC,month DESC,day DESC")->find());
	}
	/*
	 * 预测将来n天的情感
	 */
	public function testForecast(){

		$date=array(2015,4,21);
		$txp=$date;
		set_time_limit(0);			//防止超时
		$format=3600*24+strtotime($date[0]."-".$date[1]."-".$date[2]);
		for($c=1;$c<15;$c++){
			$fm=$format;
			for($j=0;$j<$this->n;$j++,$fm+=3600*24){
				$date=explode("-",date("Y-m-d",$fm));
				$y=(int)$date[0];$m=(int)$date[1];$d=(int)$date[2];
				$synthezise=$this->GetForecast($fm, $c);
				$temp=M('forecast')->where(array(
						'year'=>$y,'month'=>$m,'day'=>$d
				))->find();
			}
		}
		dump($txp);
	}
	public function startForecastN(){
	   	$date = $this->getLatestDate();
	   	$format=3600*24+strtotime($date["year"]."-".$date["month"]."-".$date["day"]);
		for($c=1;$c<15;$c++){
			$fm=$format;
			for($j=0;$j<$this->n;$j++,$fm+=3600*24){
				$date=explode("-",date("Y-m-d",$fm));
				$y=(int)$date[0];$m=(int)$date[1];$d=(int)$date[2];
				$synthezise=$this->GetForecast($fm, $c);
				$temp=M('forecast')->where(array(
					'year'=>$y,'month'=>$m,'day'=>$d
				))->find();
			}
		}
		UpdateOrNotForeX();
	}
	/*
	 * 预测某城市某一天核心代码			直接调用GetForecast()  $format->当天时间戳  $c->城市代码1-14
	 *
	 * M=数据库中同一天的综合情感平均值
	 * K=预测当天前30天综合情感加权平均值
	 *
	 * 预测=t*M+(1-t)*K
	 */
	private function GetForecast($format,$c){
		$date=explode("-",date("Y-m-d",$format));
		$y=(int)$date[0];$m=(int)$date[1];$d=(int)$date[2];

		$flag=0;
		if(M('forecast')->where(array('year'=>$y,'month'=>$m,'day'=>$d,'A_number'=>$c))->find()){
			$flag=1;
		}
		$w=$this->getM($format,$c);$k=$this->getK($format,$c);
		$t=$this->t;
		$synthesize=$t*$w+(1-$t)*$k;

		$data=array('year'=>$y,'month'=>$m,'day'=>$d,'A_number'=>$c,"cps"=>$synthesize);
		if(!$flag)M("forecast")->data($data)->add();
		else M("forecast")->where(array('year'=>$y,'month'=>$m,'day'=>$d,'A_number'=>$c))->save(array("cps"=>$synthesize));
		return $synthesize;
	}
	private function getM($formate,$c){//  月   日  城市

		$date=explode("-", date("Y-m-d",$formate));
		$y=(int)$date[0];$m=(int)$date[1];$d=(int)$date[2];
		$w=0;$num=0;
		for($i=2005;$i<$y;$i++){
			$feel=new FeelModel();
			$condition=array(
				'year'=>$i,
				'month'=>$m,
				'day'=>$d,
				'A_number'=>$c
			);
			$data=$feel->where($condition)->find();
			if($data){$num++;$w+=$data["cps"];}
			//dump($data);dump($feel->getLastSql());

		}
		if($num){$w/=$num;}
		return $w;
	}
	private function getK($format,$c){//时间戳       城市
		$fm=$this->fm;
		$feel=new FeelModel();
		for($i=0;$i<$this->foredays;$i++){
			$k=0;
			$date=explode("-",date("Y-m-d",$format-$i*24*3600));
			$y=(int)$date[0];$m=(int)$date[1];$d=(int)$date[2];
			$condition=array(
					'year'=>$y,
					'month'=>$m,
					'day'=>$d,
					'A_number'=>$c
			);
			$data=$feel->where($condition)->find();
			if(!$data){
				$data=M('forecast')->where($condition)->find();
			}if($data){
				$k+=$data["cps"]*($this->foredays-$i)/$fm;
			}
		}
		return $k;
	}
	/*
	 * 预测部分结束
	 */
	/***	登录权限检测		**/
	public function check_power($message="你没有权限！"){

		if(!$this->check_login()){
			$this->error("请先登录！",U("Admin/Login/index"));return false;
		}else if(check_admin()==2){
			return true;
		}else{
			$this->error($message,U("Admin/Index/main"));
		}
		$this->error($message,U("Admin/Index/main"));
	}
	public function check_login($message="请先登录！"){

		if(!check_admin()){$this->error($message,U("Admin/Login/index"));return false;}
		else {return true;}

	}


}
/*
 *  var_dump(strtotime("2015-01-22"));
	var_dump(time());
	die();
 */
?>