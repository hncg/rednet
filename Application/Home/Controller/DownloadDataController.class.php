<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\FeelModel;
use Home\Model\ArticleWordModel;
use Home\Model\DateNow;

class DownloadDataController extends Controller{

	public function index(){

		if(!I('post.flag')){$this->error("错误页面！",U('/Home/Index/index'));}
		if(I('post.flag')==1){
			$downloadflag=0;
			$date	=	new DateNow();
			$y		=	$date->year;
			$m		=	$date->month;	if($m<10)$m='0'.$m;
			$d		=	$date->day;		if($d<10)$d='0'.$d;
			$fileName=__CSV__.'download/'.$y.$m.$d.".csv";			//后台读取文件路径
			$download=__CSVD__.'download/'.$y.$m.$d.".csv";			//传入前台的下载路径
			$tempName=__CSV__.'temp/temp.csv';
			$fx = fopen($fileName, 'r+');			//判断是否已存在，存在直接下载
			if($fx){$downloadflag=1;}

			if(!$downloadflag){
				copy(__SCV__.'x.csv',$tempName);
				$fp = fopen($tempName, 'w');
			}
			if(flock($fp, LOCK_EX)&&!$downloadflag){

				$this->writeData($fileName,$tempName,$fp);
				$downloadflag=1;
			}else{
				if($downloadflag==1);
				else
					echo "正在生成数据，稍后重试！";
			}
			if($downloadflag){
				echo $download;
				$this->recordInf($y,$m,$d);//下载记录存入数据库
			}
		}
	}
	private function getcity($num){
		switch ($num){
			case 1 :return '长沙市';case 2 :return '株洲市';case 3 :return '湘潭市';
			case 4 :return '衡阳市';case 5 :return '岳阳市';case 6 :return '益阳市';
			case 7 :return '常德市';case 8 :return '邵阳市';case 9 :return '娄底市';
			case 10:return '永州市';case 11:return '郴州市';case 12:return '怀化市';
			case 13:return '湘西州';case 14:return '张家界';
		}
	}
	public function recordInf($y,$m,$d){

		$data=array(
			'time'=>time(),
			'account'=>I('session.account',''),
			'ip'=>get_client_ip(0),
			'download'=>$y.$m.$d
		);
		M('downloadrecord')->data($data)->add();
	}
	private function writeData($fileName,$tempName,$fp){

		$date	=	new DateNow();
		$feel	=	new FeelModel();
		$feel->startIndex();
		$articleWord	=	new ArticleWordModel();
		$articleWord->startIndex();

		fwrite($fp,"\xEF\xBB\xBF");//解决汉字乱码
		$blank=array("","");
		$articleFirstLine=array('日期','地区','标题','作者','链接','回复数');
		$wordFirstLine=array('日期','地区','热词','词频');
		/*******		写入地图柱状图数据		**********/
		/*  "日期","地区","happy","good","anger","sorrow","fear","evil","surprise","cps" */
		$temp=array("日期","地区","happy","good","anger","sorrow","fear","evil","surprise","cps");
		fputcsv($fp, array('地图柱状图数据'));
		fputcsv($fp, $temp);
		for($i=1;$i<15;$i++){		/* 14个城市 */
			$sql="select *from(select *from feel where A_number=".$i." order by year desc,month desc,day desc limit 0,7)as x order by x.year asc,x.month asc,x.day asc";
			$data=M('feel')->query($sql);
			for($j=0;$j<7;$j++){					/* 最近一周共7天 */
				if(empty($data[$j]))break;
				$y=$data[$j]['year'];
				$m=$data[$j]['month'];	if($m<10)$m='0'.$m;
				$d=$data[$j]['day'];	if($d<10)$d='0'.$d;
				$arr=array(
						$y.$m.$d,
						$this->getcity($data[$j]['A_number']),
						$data[$j]['happy'],
						$data[$j]['good'],
						$data[$j]['anger'],
						$data[$j]['sorrow'],
						$data[$j]['fear'],
						$data[$j]['evil'],
						$data[$j]['surprise'],
						$data[$j]["cps"]
				);
				fputcsv($fp, $arr);
			}
		}
		/*****		END 地图柱状图数据	*******/
		fputcsv($fp, $blank);
		fputcsv($fp, $blank);	/**		两空行	***/

		/*****		折线图数据			*******/
		fputcsv($fp, array('折线图数据'));
		fputcsv($fp, $temp);
		$sql="select *from (select * from feel where A_number=1 ORDER BY year DESC,month DESC,day DESC limit 0,31) AS X ORDER BY X.year ASC,X.month ASC,X.day ASC";
		$data=M('feel')->query($sql);
		for($j=0;$j<31;$j++){				/**		最近31天数据		**/
			if(empty($data[$j]))break;
			$y=$data[$j]['year'];
			$m=$data[$j]['month'];	if($m<10)$m='0'.$m;
			$d=$data[$j]['day'];	if($d<10)$d='0'.$d;
			$arr=array(
					$y.$m.$d,
					$this->getcity($data[$j]['A_number']),
					$data[$j]['happy'],
					$data[$j]['good'],
					$data[$j]['anger'],
					$data[$j]['sorrow'],
					$data[$j]['fear'],
					$data[$j]['evil'],
					$data[$j]['surprise'],
					$data[$j]["cps"]
			);
			fputcsv($fp, $arr);
		}
		/*****		END 折线图数据	*******/
		fputcsv($fp, $blank);
		fputcsv($fp, $blank);	/**		两空行	***/

		/******		红网精帖数据	*****/
		fputcsv($fp, array('红网精帖','X 15'));
		fputcsv($fp, $articleFirstLine);
		$sql="select * from(select *from max_article where A_number=15 group by title,year,month,day,replies order by year desc,month desc,day desc limit 0,30)as x  order by x.replies desc limit 0,15";
		$data=M('max_article')->query($sql);
		for($i=0;$i<15;$i++){					/****		15个精帖		***/

			if(empty($data[$i]))break;
			$y=$data[$i]['year'];
			$m=$data[$i]['month'];	if($m<10)$m='0'.$m;
			$d=$data[$i]['day'];	if($d<10)$d='0'.$d;
			$arr=array(
					$y.$m.$d,
					$this->getcity($data[$i]['A_number']),
					$data[$i]['title'],
					$data[$i]['author'],
					$data[$i]['url'],
					$data[$i]['replies']
			);
			fputcsv($fp, $arr);
		}
		/******		END   红网精帖数据	*****/
		fputcsv($fp, $blank);
		fputcsv($fp, $blank);	/**		两空行	***/
		fputcsv($fp, array('当天详情'));

		/******		当日详情		********/
		$sql="select *from feel where A_number=1 and year=".$date->year." and month=".$date->month." and day=".$date->day;
		$data=M('feel')->query($sql);

		fputcsv($fp, $temp);
		$y=$data[0]['year'];
		$m=$data[0]['month'];	if($m<10)$m='0'.$m;
		$d=$data[0]['day'];	if($d<10)$d='0'.$d;
		$arr=array(
				$y.$m.$d,
				$this->getcity($data[0]['A_number']),
				$data[0]['happy'],
				$data[0]['good'],
				$data[0]['anger'],
				$data[0]['sorrow'],
				$data[0]['fear'],
				$data[0]['evil'],
				$data[0]['surprise'],
				$data[0]["cps"]
		);
		fputcsv($fp, $arr);

		fputcsv($fp, $blank);
		fputcsv($fp, $blank);	/**		两空行	***/

		/*** 	热词		*****/
		fputcsv($fp, $wordFirstLine);
		$sql="select *from max_words where A_number=1 and year=".$date->year." and month=".$date->month." and day=".$date->day." order by rate desc limit 0,15";
		$data=M('max_words')->query($sql);
		for($i=0;$i<15;$i++){		/*****		15个热词	*****/
			if(empty($data[$i]))break;
			$arr=array(
					$y.$m.$d,
					$this->getcity($data[$i]['A_number']),
					$data[$i]['word'],
					$data[$i]['rate']
			);
			fputcsv($fp, $arr);
		}
		fputcsv($fp, $blank);
		fputcsv($fp, $blank);	/**		两空行	***/

		/******		当日帖子	*****/
		fputcsv($fp, $articleFirstLine);
		$sql="select * from max_article where A_number=1 and year=".$date->year." and month=".$date->month." and day=".$date->day."  group by title,year,month,day,replies order by replies desc limit 0,15";
		$data=M('max_article')->query($sql);
		for($i=0;$i<15;$i++){					/****		15个帖子		***/

			if(empty($data[$i]))break;
			$y=$data[$i]['year'];
			$m=$data[$i]['month'];	if($m<10)$m='0'.$m;
			$d=$data[$i]['day'];	if($d<10)$d='0'.$d;
			$arr=array(
					$y.$m.$d,
					$this->getcity($data[$i]['A_number']),
					$data[$i]['title'],
					$data[$i]['author'],
					$data[$i]['url'],
					$data[$i]['replies']
			);
			fputcsv($fp, $arr);
		}
		flock($fp, LOCK_UN);
		copy($tempName, $fileName);
	}
}
