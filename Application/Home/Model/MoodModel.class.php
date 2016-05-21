<?php
namespace Home\Model;

use Think\Model;

class MoodModel extends Model{

	public $city;                        //城市
	public $year;                        //年份
	public $month;                       //月份
	public $day;                         //日期

	public $allNum=700;                  //折线图横坐标坐标点个数
	public $allData;                     //某种情绪所有数据
	public $allList;                     //横坐标坐标值

	public $monthData;                   //某年某月数据《array( opinion=>array(1-31) )》
	public $monthList;                   //该月折线图坐标轴横坐标

	public $weekData;					 //某一种情感  十四市数据

	public $dayData;                   	 //某一天数据一维数组

	private $lineMaxData=1000;
	private $base=2;                    //对数 底数
	private $allBase=1.0001;

	private $start=true;				//是否是初始状态


	public function __construct($city=1,$year=NULL,$month=NULL,$day=NULL,$start=true){

		parent::__construct();$this->start=$start;

		$this->city=$city;		$this->year=$year;
		$this->month=$month;	$this->day=$day;
	}
	/*		下载数据用到		*/
	public function startIndex(){

		$date=new DateNow();
		$this->year=$date->year;
		$this->month=$date->month;
		$this->day=$date->day;

		$this->getWeekData();
 	$this->getMonthData();
		$this->getDayData();
		$this->getAllData();
	}

	/*************    获取某种情绪所有数据       ******************/
	public function getAllData($opinion="cps"){

		$sql="select * from mood where city_id=".$this->city." order by year asc,month asc,day asc";
		$this->manageAllData($this->query($sql), $opinion);
	}

	/*************    获取某月所有情绪数据        ******************/
	public function getMonthData(){
		$y=$this->year;$m=$this->month;$d=$this->day;
		//echo $y.$y.$d;//and year!=".$y."and month!=".$m."and day!=".$d."
		if(!$this->start){
			$sql="select *from (select *from mood where city_id=".$this->city." and year=".$this->year." and month=".$this->month." ORDER BY year DESC,month DESC,day DESC limit 0,31) AS X ORDER BY X.year ASC,X.month ASC,X.day ASC";
		}else{
			$sql="select *from (select * from mood where city_id=".$this->city."  ORDER BY year DESC,month DESC,day DESC limit 0,31) AS X ORDER BY X.year ASC,X.month ASC,X.day ASC";
		}
		$this->manageMonthData($this->query($sql));
	}

	/*************    获取最近一周数据      ******************/
	public function getWeekData($opinion="cps"){

		for($i=0;$i<14;$i++){
			$sql="select * from mood where city_id=".($i+1)." limit 0,7";
			$arr[$i]=$this->query($sql);
		}
		$this->manageWeekData($arr, $opinion);
	}

	/*************    获取某一天数据        ******************/
	public function getDayData(){

		$sql="select *from mood where city_id=".$this->city." and year=".$this->year." and month=".$this->month." and day=".$this->day;
		$this->manageDayData($this->query($sql));
	}

	/***
	 ***
	 ***					私有函数
	 ***
	 ***
	 ***
	**/

	/*************    处理所有数据中某天无数据的情况        ******************/
	private function manageAllData($arr,$opinion){
		$num=count($arr);$max=$this->allNum;
		for($i=0;$i<$max;$i++){
			if($i<$num){
				$this->allData[$i]=$this->LgData($arr[$i][$opinion],false,$this->allBase);
				$this->allList[$i]=$arr[$i]["year"].".".$arr[$i]["month"].".".$arr[$i]["day"];
			}else{
				$this->allData[$i]="-";
				$this->allList[$i]="-";
			}
		}
	}

	/*************    处理月数据中某天数据不存在        ******************/
	private function manageMonthData($arr){
		$num=count($arr);
		$flag=true;						//是否取对数
		for($i=0;$i<32;$i++){
			if($i<$num){
				$this->monthData["happy"][$i]	=	$this->LgData($arr[$i]["happy"],$flag);
				$this->monthData["good"][$i]	=	$this->LgData($arr[$i]["good"],$flag);
				$this->monthData["anger"][$i]	=	$this->LgData($arr[$i]["anger"],$flag);
				$this->monthData["sorrow"][$i]	=	$this->LgData($arr[$i]["sorrow"],$flag);
				$this->monthData["fear"][$i]	=	$this->LgData($arr[$i]["fear"],$flag);
				$this->monthData["evil"][$i]	=	$this->LgData($arr[$i]["evil"],$flag);
				$this->monthData["surprise"][$i]=	$this->LgData($arr[$i]["surprise"],$flag);
				$this->monthList[$i]=$arr[$i]["year"].".".$arr[$i]["month"].".".$arr[$i]["day"];
			}
			else{
				$this->monthData["happy"][$i]	=	"-";
				$this->monthData["good"][$i]	=	"-";
				$this->monthData["anger"][$i]	=	"-";
				$this->monthData["sorrow"][$i]	=	"-";
				$this->monthData["fear"][$i]	=	"-";
				$this->monthData["evil"][$i]	=	"-";
				$this->monthData["surprise"][$i]=	"-";
				$this->monthList[$i]="-";
			}
		}
		$max=-10000;
		$min= 10000;
		foreach ($arr as $temp){
			$maxt=max($temp);$mint=min($temp);
			if($maxt>$max){$max=$maxt;}
			if($mint<$min){$min=$mint;}
		}
		$max=$this->LgData($max,$flag);$min=$this->LgData($min,$flag);

		$this->monthData["happy"][32]	=	$min;
		$this->monthData["good"][32]	=	$min;
		$this->monthData["anger"][32]	=	$min;
		$this->monthData["sorrow"][32]	=	$min;
		$this->monthData["fear"][32]	=	$min;
		$this->monthData["evil"][32]	=	$min;
		$this->monthData["surprise"][32]=	$min;
		$this->monthList[32]="-";

		$this->monthData["happy"][33]	=	"-";
		$this->monthData["good"][33]	=	"-";
		$this->monthData["anger"][33]	=	"-";
		$this->monthData["sorrow"][33]	=	"-";
		$this->monthData["fear"][33]	=	"-";
		$this->monthData["evil"][33]	=	"-";
		$this->monthData["surprise"][33]=	"-";
		$this->monthList[33]="-";$i=34;

		$this->monthData["happy"][$i]	=	$max;
		$this->monthData["good"][$i]	=	$max;
		$this->monthData["anger"][$i]	=	$max;
		$this->monthData["sorrow"][$i]	=	$max;
		$this->monthData["fear"][$i]	=	$max;
		$this->monthData["evil"][$i]	=	$max;
		$this->monthData["surprise"][$i]=	$max;
		$this->monthList[$i]="-";

	}
	/*************    求最近一周某情感平均值        ******************/
	private function manageWeekData($arr,$opinion){

		for($i=0;$i<14;$i++){
			$temp=0;
			for($j=0;$j<7;$j++){
				$temp+=isset($arr[$i][$j][$opinion])?$arr[$i][$j][$opinion]:0;
			}
			$this->weekData[$i]=$temp/7;
		}
	}
	/*******   是否 对数 处理折线图数据     ******/
	private function LgData($temp,$flag=true,$base=0){
		$base=($base==0)?$this->base:$base;
		if(!$flag){return $temp;}
		if($temp>0)return log($temp,$base);
		if($temp==0)return 0;
		return -log(-$temp,$base);
	}
	/*************    处理某天数据        ******************/
	private function manageDayData($arr){

		if(isset($arr)){$this->dayData=$arr[0];}
		else{
			$this->dayData=array("happy"=>"0","good"=>"0","anger"=>"0","sorrow"=>"0","fear"=>"0","evil"=>"0","surprise"=>"0","total_strong"=>"0","max_strong"=>"0","year"=>"-","month"=>"-","day"=>"-","city_id"=>"-","cps"=>"0");
		}
	}

}