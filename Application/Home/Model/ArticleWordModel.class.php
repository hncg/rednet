<?php 
namespace Home\Model;

use Think\Model;
 
class ArticleWordModel extends Model{
	
	public $city;
	public $year;
	public $month;
	public $day;
	
	public $article;
	public $word;
	public $pieData;
	public $rate=array(100,100,100,10,10,10,10,10,10,10);
	
	public $article15;
	public $articleNum=10;
	public $detailArticleNum=13;
	
	public function __construct($city=1,$year=NULL,$month=NULL,$day=NULL){
		
		parent::__construct();
		
		$this->city=$city;		$this->year=$year;
		$this->month=$month;	$this->day=$day;
	}
	public function startIndex(){
		
		$date=new DateNow();
		$this->city=1;
		$this->year=$date->year;
		$this->month=$date->month;
		$this->day=$date->day;
		
		$this->getPieData();
		$this->getWord();
		$this->getArticle();
	}
	
	public function getArticle(){
		
		//$sql="select * from(select *from max_article where A_number=15 group by title,year,month,day,replies order by year desc,month desc,day desc limit 0,".($this->articleNum*2).")as x  order by x.replies desc limit 0,".$this->articleNum;
		$sql="select * from(select distinct * from (select *from max_article where A_number=15 order by year desc,month desc,day desc limit 0,20)as temp)as x order by x.replies desc limit 0,10";
		
		$this->article15=$this->query($sql);
		$sql="select * from max_article where A_number=".$this->city." and year=".$this->year." and month=".$this->month." and day=".$this->day."  group by title,year,month,day,replies order by replies desc limit 0,".$this->detailArticleNum;
		$this->article=$this->query($sql);	
	}
	public function getWord(){
		
		$blank=array("-"," -","- "," - ","  - ","  -"," -  ","-  ","  -  "," -   ");
		//$blank=array("1","2","3","4","5","6","7","8","9","10");
		$sql="select*from max_words where A_number=".$this->city." and year=".$this->year." and month=".$this->month." and day=".$this->day." order by rate desc limit 0,10";
		$arr=$this->query($sql);
		for($i=0,$temp=count($arr);$i<10;$i++){
			if($i<$temp){
				$this->word[$i]=$arr[$i]["word"];
			}else{
				$this->word[$i]=$blank[$i];
			}
		}
	}
	public function getPieData(){
		
		$sql="select *from feel where A_number=".$this->city." and year=".$this->year." and month=".$this->month." and day=".$this->day;
		$temp=$this->query($sql);
		if(isset($temp[0]))
			$this->pieData=array($temp[0]["happy"],$temp[0]["good"],$temp[0]["anger"],$temp[0]["sorrow"],$temp[0]["fear"],$temp[0]["evil"],$temp[0]["surprise"]);
		else{
			$this->pieData=array("-","-","-","-","-","-","-");
			$this->pieData=array(1,0,0,0,0,0,0);
		}
	}
}

?>