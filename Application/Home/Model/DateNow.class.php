<?php
namespace Home\Model;

class DateNow{
	public $year;
	public $month;
	public $day;
	public $dayNum;

	public function __construct($y=0,$m=0,$d=0){
		if($y!=0){
			$this->year=$y;
			$this->month=$m;
			$this->day=$d;
			$this->getDayNum();
		}else{
			$date=array();
			preg_match_all("/[0-9]+/",date('Y-m-d',time()+8*3600-24*3600),$date);
			$this->year		=	(int)$date[0][0];
			$this->month	=	(int)$date[0][1];
			$this->day		=	(int)$date[0][2];

			$this->year=2016;$this->month=5;$this->day=11;
			$this->getDayNum();
		}
	}
	private function getDayNum(){
		$m=$this->month;
		switch ($m){
			case 4:$this->dayNum=30;break;case 6 :$this->dayNum=30;break;
			case 9:$this->dayNum=30;break;case 11:$this->dayNum=30;break;
			case 2:$this->dayNum=28;break;
			default:$this->dayNum=31;break;
		}
		if($m==2){
			$y=$this->year;
			if(($y%4==0&&$y%100!=0)||$y%400==0){$this->dayNum++;}
		}
	}
}






?>