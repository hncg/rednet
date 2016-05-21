<?php
namespace Home\Model;

use Think\Model;

class ForecastModel extends Model{

	public $city;                        //城市
	public $year;                        //年份
	public $month;                       //月份
	public $day;                         //日期

	public $dayList;
	public $dayData;
	public $dayNum;						//显示数据的天数

	public $monthList;
	public $monthData;	public $fectData;

	private $base=20;					//取对数的底

	public function __construct($c=1,$y=0,$m=0,$d=0,$i=30){
		if(!($c>=1&&$c<=14)){$c=1;}
		$this->city=$c;		$this->year=$y;
		$this->month=$m;	$this->day=$d;		$this->dayNum=$i;
		if($y!=0)$this->getmonthData();
		else $this->getMonthData2();
	}
	private function getMonthData(){
		$y=$this->year;$m=$this->month;$c=$this->city;
		for($i=0;$i<getMonthDays($y, $m);$i++){
			$temp=M("forecast")->field("cps")->where(array(
					"city_id"=>$c,"year"=>$y,"month"=>$m,"day"=>$i+1
			))->find();
			$feel=M("mood");
			$fect=$feel->field("cps")->where(array(
					"city_id"=>$c,"year"=>$y,"month"=>$m,"day"=>$i+1
			))->find();
			$this->monthList[$i]=$y.".".$m.".".($i+1);
			$this->monthData[$i]=$temp?$this->LgData($temp["cps"]):"-";
			$this->fectData[$i]	=$fect?$this->LgData($fect["cps"]):"-";
		}
	}
	private function getMonthData2(){
		var_dump(1);
		$format=time()-36*2400*30;
		$c=$this->city;
		for($i=0;$i<60;$i++,$format+=24*3600){
			$date=explode("-", date("Y-m-d",$format));
			$y=(int)$date[0];$m=(int)$date[1];$d=(int)$date[2];
			$temp=M("forecast")->field("cps")->where(array(
					"city_id"=>$c,"year"=>$y,"month"=>$m,"day"=>$d
			))->find();
			$feel=M("mood");
			$fect=$feel->field("cps")->where(array(
					"city_id"=>$c,"year"=>$y,"month"=>$m,"day"=>$d
			))->find();//echo $c.".".$y.".".$m.".".$d."<br>";
			$this->monthList[$i]=$y.".".$m.".".$d;
			$this->monthData[$i]=$temp?$this->LgData($temp["cps"]):"-";
			$this->fectData[$i]	=$fect?$this->LgData($fect["cps"]):"-";
		}
	}

	/*******   是否 对数 处理折线图数据     ******/
	private function LgData($temp,$flag=true){
		if(!$flag){return $temp;}
		if($temp>0)return log($temp,$this->base);
		if($temp==0)return 0;
		return -log(-$temp,$this->base);
	}
}