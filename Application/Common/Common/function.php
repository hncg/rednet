<?php
/**
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function send_checkCode_mail($to, $name, $checkCode,$subject = '', $body = '', $attachment = null){
	$config = C('THINK_EMAIL');
	vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
	try {
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
		$mail->SMTPAuth   = true;                  //开启认证
		$mail->Port       = $config['SMTP_PORT'];
		$mail->Host       = $config['SMTP_HOST'];
		$mail->Username   = $config['SMTP_USER'];
		$mail->Password   = $config['SMTP_PASS'];
		//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
		$mail->AddReplyTo("phpddt1990@163.com","mckee");//回复地址
		$mail->From       = $config['FROM_EMAIL'];
		$mail->FromName   = $config['FROM_NAME'];
		$to = empty($to)?"616142437@qq.com":$to;
		$mail->AddAddress($to);
		$mail->Subject  = "红网网络情感监控网找回密码验证邮件";
		$mail->Body = "<h1>红网网络情感监控网找回密码验证邮件</h1>这是红网网络情感监控网（<font color=red>".$config["WWW"]."</font>）对找回密码验证验证码。<br/><p>"."您的验证码是：".$checkCode."，有效期半小时，请保管好验证码，请勿告诉他人以免造成损失。</p>";
		$mail->AltBody    = "您的验证码是：".$checkCode."，有效期半小时，请保管好验证码，请勿告诉他人以免造成损失。"; //当邮件不支持html时备用显示，可以省略
		$mail->WordWrap   = 80; // 设置每行字符串的长度
		//$mail->AddAttachment("f:/test.png");  //可以添加附件
		$mail->IsHTML(true);
		$mail->Send();
		//echo '邮件已发送';
		return true;
	} catch (phpmailerException $e) {
		//echo "邮件发送失败：".$e->errorMessage();
		return "邮件发送失败：".$e->errorMessage();
	}
// 	$mail             = new PHPMailer(); //PHPMailer对象
// 	$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
// 	$mail->IsSMTP();  // 设定使用SMTP服务
// 	$mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
// 	// 1 = errors and messages
// 	// 2 = messages only
// 	$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
// 	$mail->SMTPSecure = 'ssl';                 // 使用安全协议


// 	$mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
// 	$replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
// 	$replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
// 	$mail->AddReplyTo($replyEmail, $replyName);
// 	$mail->Subject    = $subject;
// 	$mail->MsgHTML($body);
// 	$mail->AddAddress($to, $name);
// 	if(is_array($attachment)){ // 添加附件
// 		foreach ($attachment as $file){
// 			is_file($file) && $mail->AddAttachment($file);
// 		}
// 	}
// 	return $mail->Send() ? true : $mail->ErrorInfo;
}
function checkCodeMd20($str){
	return substr(md5($str),0,20);
}
function pswMd($str){
	return md5($str);
}
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
function getCityDepAnumber($num){

	switch($num){
		case 3 : $cname="长沙市";break;
		case 2 : $cname="株洲市";break;
		case 7 : $cname="湘潭市";break;
		case 5 : $cname="衡阳市";break;
		case 10 : $cname="岳阳市";break;
		case 4 : $cname="益阳市";break;
		case 9 : $cname="常德市";break;
		case 12 : $cname="邵阳市";break;
		case 13 : $cname="娄底市";break;
		case 8: $cname="永州市";break;
		case 11: $cname="郴州市";break;
		case 6: $cname="怀化市";break;
		case 14: $cname="湘西州";break;
		case 1: $cname="张家界";break;
		default  : $cname="xxx";  break;
	}
	return $cname;
}

