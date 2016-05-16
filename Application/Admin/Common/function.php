<?php
use Think\Cache\Driver\File;
function check_verify($code, $id = ""){

	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}
function check_admin(){
	
	if(!I('session.admin',''))return 0;
	$data=M('admin')->where(array('account'=>I('session.admin')))->find();
	$qx=$data['power'];
	if($qx>1000)return 2;
	return 1;
}
function getIp(){

	if(getenv('http_client_ip')&&strcasecmp(getenv('http_client_ip'), "unknown"))
		$ip=getenv('http_client_ip');
	else if(getenv('http_x_forwarded_for')&&strcasecmp(getenv('http_x_forwarded_for'), "unknown"))
		$ip=getenv('http_x_forwarded_for');
	else if(getenv("remote_addr")&&strcasecmp(getenv("remote_addr"), "unknown"))
		$ip=getenv("remote_addr");
	else if(isset($_SERVER["remote_addr"])&&$_SERVER["remote_addr"]&&strcasecmp($_SERVER["remote_addr"], "unknown"))
		$ip=$_SERVER["remote_addr"];
	else
		$ip="unknown";
	return $ip;
}
function secToTime($sec){
	
	$day=floor($sec/3600/24);
	$hou=floor(($sec-$day*3600*24)/3600);
	$min=floor(($sec-$day*3600*24-$hou*3600)/60);
	$sec=$sec-$day*3600*24-$hou*3600-$min*60;
	return array('day'=>$day,'hou'=>$hou,'min'=>$min,'sec'=>$sec);
}
function UpdateOrNotFore(){
	$format=time();
	$file="./Public/update.txt";
	touch($file);
	$fm=file_get_contents("./Public/update.txt");
	return ($format>$fm+24*3600)?true:false;
}
function UpdateOrNotForeX(){
	$file="./Public/update.txt";
	touch($file);
	if(!$fp=fopen($file, "w"))return false;
	flock($fp, LOCK_EX);
	fwrite($fp, strtotime(date("Y-m-d",time())));
	flock($fp, LOCK_UN);
	fclose($fp);
	return true;
}/*
function getMonthDays($y,$m){
	$days=31;
	if( $m == 4 || $m == 6 || $m == 9 ||  $m == 11 ){
		$days=30;
	}elseif($m==2){
		if(($y%4==0&&$y%100!=0)||$y%400==0){
			$days=29;
		}else{$days=28;}
	}
	return $days;
}
function getCityDepAnumber($city){
	switch($city){
		case 1:$c="长沙市";break;case 2:$c="株洲市";break;case 3:$c="湘潭市";break;
		case 4:$c="衡阳市";break;case 5:$c="岳阳市";break;case 6:$c="益阳市";break;
		case 7:$c="常德市";break;case 8:$c="邵阳市";break;case 9:$c="娄底市";break;
		case 10:$c="永州市";break;case 11:$c="郴州市";break;case 12:$c="怀化市";break;
		case 13:$c="湘西州";break;case 14:$c="张家界市";break;
	}
	return $c;
}
*/




