<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_PARSE_STRING'=>array(

		'__STATIC__'	=>	__ROOT__.'/Public/Static/',
		'__JS__'		=>	__ROOT__.'/Public/Js/',
		'__CSS__'		=>	__ROOT__.'/Public/Css/',
		'__IMG__'		=>	__ROOT__.'/Public/Img/',
		'__PUBLIC__'	=>	__ROOT__.'/Public/',
		'__LOGIN__'		=>	__ROOT__.'/index.php/Home/Login/',
		'__HOME__'		=>	__ROOT__.'/index.php/Home/',

	),
	'DB_TYPE' => 'mysql', // 数据库类型
	'DB_HOST' => '127.0.0.1', // 服务器地址
	'DB_NAME' => 'rednet', // 数据库名
	'DB_USER' => 'cg', // 用户名
	'DB_PWD' => '123456', // 密码
	'DB_PORT' => 3306, // 端口
	'DB_PREFIX' => '', // 数据库表前缀
	'DB_CHARSET'=> 'utf8', // 字符集

	'TMPL_L_DELIM'	=>	'<!--{',
	'TMPL_R_DELIM'	=>	'}-->',

	//'SHOW_PAGE_TRACE'	=>	true,
	/*
	 * 设置模块及默认模块
	 * 'MODULE_ALLOW_LIST'	=>	array('Home','Admin'),
	 * 'DEFAULT_MODULE'		=>	'Home',
	 *
	 * 配置路由规则
	 * 'URL_ROUTE_RULES'	=>	array(
	 * 		'u'				=>	'Home/Index',//地址栏可以用u代替输入Home/Index
	 * )
	 *
	 *
	 */

	//邮件配置
	'THINK_EMAIL' => array(
			'SMTP_HOST'   => 'smtp.163.com', //SMTP服务器
			'SMTP_PORT'   => '25', //SMTP服务器端口
			'SMTP_USER'   => 'jaysir@163.com', //SMTP服务器用户名
			'SMTP_PASS'   => 'wapw521', //SMTP服务器密码
			'FROM_EMAIL'  => 'jaysir@163.com', //发件人EMAIL
			'FROM_NAME'   => '红网网络情感监控网', //发件人名称
			'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
			'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
			'WWW'		  => 'www.qinsir.com',//
	),

);