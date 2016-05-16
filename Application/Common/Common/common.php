<?php


function getInf(){
	 
	$inf=array();
	$inf['time']	=	time();
	$inf['ip']		=	$this->getIp();
	$inf['account']	=	I('session.account','');
	return $inf;
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