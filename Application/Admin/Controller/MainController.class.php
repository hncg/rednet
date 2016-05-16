<?php
namespace Admin\Controller;

use Think\Controller;
use Admin\Model\AdminModel;
use Home\Model\FeelModel;

class MainController extends Controller{

	private $pageSize=10;
	private $spiderProcess="tasklist.exe";
	private $StartSpiderCommond="tasklist";

	public function member(){
		if(!check_admin())die();
		switch(I('get.m')){
			case 1:$tmpl='adminManage';break;
			case 2:$tmpl='manage';break;
			case 3:$tmpl='changeInf' ;break;
			default:$this->error("出现错误！",U('Admin/Index/main'));die();
		}
		if(check_admin()==1&&(I('get.m')==1||I('get.m')==2)){
			$this->error("你没有权限！",U("Admin/Index/main"));
			die();
		}
		$this->redirect("Admin/Main/".$tmpl);
		//$this->display("main:member/".$tmpl);
	}
	public function download(){
		if(!check_admin())die();
		switch(I('get.m')){
			case 1:$tmpl='downloadData';break;
			default:$this->error("出现错误！",U('Admin/Index/main'));die();
		}
		$this->redirect("Admin/Main/".$tmpl);
		//$this->display("main:download/".$tmpl);
	}
	public function spider(){
		if(!check_admin())die();
		switch(I('get.m')){
			case 1:$tmpl='spiderSwitch';break;
			default:$this->error("出现错误！",U('Admin/Index/main'));die();
		}
		$this->redirect("Admin/Main/".$tmpl);
	}
	public function record(){
		if(!check_admin())die();
		switch(I('get.m')){
			case 1:$tmpl='visitRecord';break;
			case 2:$tmpl='downloadRecord';break;
			default:$this->error("出现错误！",U('Admin/Index/main'));die();
		}
		$this->redirect("Admin/Main/".$tmpl);
		//$this->display("main:record/".$tmpl);
	}
	public function updataAdmin(){
		$admin=new AdminModel();
		$data=array(
				'ID'=>I('post.ID'),
				'account'=>I('post.account'),
				'email'=>I('post.email'),
				'tel'=>I('post.tel'),
				'name'=>I('post.name'),
		);
		$admin->save($data);
	}
	public function deleteAdmin(){
		M("admin")->delete(I('post.ID'));
	}


/*
 *
 * 后台管理页
 *
 *
 */
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


	/***
	 *
	 * member
	 *
	 * ***/
	public function adminManage(){

		if(!$this->check_power())die();

		$page=I('get.page',1);
		$adminlist=M("admin")->field("password",true)->page($page,$this->pageSize)->select();
		for($i=0;$i<count($adminlist);$i++){
			$adminlist[$i]['time']=date('Y-m-d',$adminlist[$i]['time']);
		}
		$adminNum=count(M('admin')->select());
		$pageNum=ceil($adminNum/$this->pageSize);
		$pageInf=array('next'=>$page+1,'pre'=>$page-1,'now'=>$page,'last'=>$pageNum);

		$this->assign("pageInf",$pageInf);
		$this->assign("adminlist",$adminlist);
		$this->assign("pageNum",$pageNum);
		//dump(M('admin')->select());
		$this->display("main:member/".__FUNCTION__);
	}
	public function manage(){

		if(!$this->check_login())die();

		$page=I('get.page',1);
		$userlist=M("user")->field("password",true)->page($page,$this->pageSize)->select();
		for($i=0;$i<count($userlist);$i++){
			$userlist[$i]['time']=date('Y-m-d',$userlist[$i]['time']);
		}
		$userNum=count(M('user')->select());
		$pageNum=ceil($userNum/$this->pageSize);
		$pageInf=array('next'=>$page+1,'pre'=>$page-1,'now'=>$page,'last'=>$pageNum);

		$this->assign("pageInf",$pageInf);
		$this->assign("userlist",$userlist);
		$this->assign("pageNum",$pageNum);
		//dump(M('admin')->select());
		$this->display("main:member/".__FUNCTION__);
	}
	public function changeInf(){
		if(!$this->check_login())die();

		$data=M('admin')->field('password',true)->where(array('account'=>I('session.admin')))->find();

		$this->assign("admin",$data);

		$this->display("main:member/".__FUNCTION__);
	}


	/***
	 *
	 * record
	 *
	 * ***/
	public function downloadRecord(){

		if(!$this->check_login())die();
		$page=I('get.page',1);
		$recordlist=M("downloadrecord")->page($page,$this->pageSize)->select();
		for($i=0;$i<count($recordlist);$i++){
			$recordlist[$i]['time']=date('Y-m-d',$recordlist[$i]['time']);
		}
		$recordNum=count(M('downloadrecord')->select());
		$pageNum=ceil($recordNum/$this->pageSize);
		$pageInf=array('next'=>$page+1,'pre'=>$page-1,'now'=>$page,'last'=>$pageNum);

		$this->assign("pageInf",$pageInf);
		$this->assign("recordlist",$recordlist);
		$this->assign("pageNum",$pageNum);

		$this->display("main:record/".__FUNCTION__);
	}
	public function visitRecord(){

		if(!$this->check_login())die();
		$page=I('get.page',1);
		$recordlist=M("visitrecord")->page($page,$this->pageSize)->select();
		for($i=0;$i<count($recordlist);$i++){
			$recordlist[$i]['time']=date('Y-m-d',$recordlist[$i]['time']);
		}
		$recordNum=count(M('visitrecord')->select());
		$pageNum=ceil($recordNum/$this->pageSize);
		$pageInf=array('next'=>$page+1,'pre'=>$page-1,'now'=>$page,'last'=>$pageNum);

		$this->assign("pageInf",$pageInf);
		$this->assign("recordlist",$recordlist);
		$this->assign("pageNum",$pageNum);

		$this->display("main:record/".__FUNCTION__);
	}

	/***
	 *
	 * download
	 *
	 * ***/
	public function downloadData(){

		if(!$this->check_login())die();

		$this->display("main:download/".__FUNCTION__);
	}

	/***
	 *
	 * spider
	 *
	 * ***/
	public function spiderSwitch(){
		//exec("taskkill /f /PID ".$match[0]);
		if(!$this->check_login())die();
		$spiderProcess=$this->spiderProcess;
		$startSpiderCommon=$this->StartSpiderCommond;

		exec("tasklist",$tasklist);
		$pregPid='/[0-9]+/';
		for($i=0;$i<count($tasklist);$i++){
			if(substr_count($tasklist[$i],$spiderProcess)){
				preg_match($pregPid,$tasklist[$i],$match);
				$taskNum=$i;
			}
		}
		$temp=explode(" ", $tasklist[$taskNum]);
		for($i=0,$j=0;$i<count($temp);$i++){
			if($temp[$i]!==""){
				$taskInf[$j]=$temp[$i];$j++;
			}
		}
		$task=array("name"=>$taskInf[0],"pid"=>$taskInf[1],"spkname"=>$taskInf[2],"spknum"=>$taskInf[3],"memory"=>$taskInf[4].' '.$taskInf[5]);

		$pre=M("spider_record")->query("select *from spider_record order by num desc limit 0,1");
		$pre=$pre[0];
		if($task['name']&&$pre){
			$pre["lastSec"]=time()-$pre["starttime"];
			$pre["starttimeYmd"]=date("Y-m-d H:i:s",$pre["starttime"]);
			$pre["endtimeYmd"]=$pre["endtime"]?date("Y-m-d H:i:s",$pre["endtime"]):"";
			$pre["nowYmd"]=date("Y-m-d H:i:s",time());
			$pre["lastTime"]=secToTime($pre["lastSec"]);
			/*持续时间格式化*/
			{
				$temp=$pre["lastTime"];
				if($temp["day"]<10)$temp["day"]="00".$temp["day"];
				elseif ($temp["day"]<100)$temp["day"]="0".$temp["day"];
				if($temp["hou"]<10)$temp["hou"]="0".$temp["hou"];
				if($temp["min"]<10)$temp["min"]="0".$temp["min"];
				if($temp["sec"]<10)$temp["sec"]="0".$temp["sec"];
				$pre["lastTime"]=$temp["day"]."天".$temp["hou"]."小时 ".$temp["min"]."分".$temp["sec"]."秒";
			}
			/*		$pre 结构
			 * 		num   		编号
			 * 		account 	操作账号
			 * 		ip			IP
			 * 		starttime	开始时间
			 * 		endtime		结束时间
			 *
			 * 		lastSec		持续时间   单位秒
			 * 		lastTime	持续时间	换算到  天小时分秒  [day][hou][min][sec]
			 * 		starttimeYmd开始时间	转换成Y-m-d格式
			 * 		endimeYmd	结束时间	转换成Y-m-d格式(未结束的记为空)
			 * 		nowYmd		现在时间	转换成Y-m-d格式
			 * */
			$this->assign("pre",$pre["endtime"]?"":$pre);
			$this->assign("task",$task);
		}
		//dump($pre);
		//dump($task);
		$this->display("main:spider/".__FUNCTION__);
		die();

		$result=exec($startSpiderCommon,$output);
		$a=exec("tasklist",$tasklist,$status);
		dump($a);
		echo "xxxxxxxxxxxxxxx"."<br/>";
		dump($tasklist);
		echo "xxxxxxxxxxxxxxx"."<br/>";
		dump($status);
		echo "xxxxxxxxxxxxxxx"."<br/>";

		die();
		$this->display("main:spider/".__FUNCTION__);
	}




	/*
	 *
	 * ajax
	 *
	 * */
	public function checkAdminAct(){

		if(!$this->check_power())die();

		$data=M('admin')->where(array('account'=>I('post.account')))->find();//dump($data);
		if($data)echo true;
		else echo false;
	}
	public function addAdmin(){

		if(!$this->check_power())die();

		$admin=new AdminModel();
		$admin->create();
		$admin->time=time();
		if($admin->add()==true)echo true;
		else echo false;
	}
	public function changeSelfInf(){
		if(!$this->check_login())die();
		$data=array(
				'ID'=>I('post.ID'),
				'email'=>I('post.email'),
				'tel'=>I('post.tel'),
				'name'=>I('post.name'),
		);
		$admin=new AdminModel();
		if($admin->save($data))echo true;else echo false;
	}
	public function changepsw(){
		if(!$this->check_login())die();
		if(!check_verify(I('post.checkcode'))){
			echo '验证码错误！';die();
		}
		$admin=new AdminModel();
		if(!$admin->where(array('ID'=>I('post.ID'),'password'=>I('p0')))->find()){
			echo '密码错误！';die();
		}
		$password=I('post.password');
		$confirmpsw=I('post.p1');
		if($password!==$confirmpsw){
			echo '两次新密码不一致！';die();
		}
		if(strlen($password)<6){
			echo '密码小于6位！';die();
		}
		$admin->create();
		$data=array(
			'ID'=>I('post.ID'),
			'password'=>$admin->password
		);
		if($admin->save($data))echo true;
		else echo false;
	}
	public function downloadMoreData(){

		if(!$this->check_login())die();
		$start=I('post.start');		$st=$start;
		//$start='2014-01-15';		$st=$start;
		$start=explode('-',$start);$start[0]=(int)$start[0];$start[1]=(int)$start[1];$start[2]=(int)$start[2];
		$end=I('post.end');			$en=$end;
		//$end='2014-11-15';			$en=$end;
		$end=explode('-',$end);$end[0]=(int)$end[0];$end[1]=(int)$end[1];$end[2]=(int)$end[2];
		$city=I("post.city",'0');

		$start_str=(int)$start[0].($start[1]<10?'0'.$start[1]:$start[1]).($start[2]<10?'0'.$start[2]:$start[2]);
		$end_str=$end[0].($end[1]<10?'0'.$end[1]:$end[1]).($end[2]<10?'0'.$end[2]:$end[2]);

		/****		获取feel表数据	****/
		if($city==0){
			$sql="select *from feel where year>=".$start[0]." and year<=".$end[0]." order by year asc,month asc,day asc,A_number asc";

		}else{
			$sql="select *from feel where A_number=".$city." and year>=".$start[0]."and year<=".$end[0]." order year asc,month asc,day asc";
		}
		$temps=M("feel")->query($sql);
		for($i=0,$j=0;$i<count($temps);$i++){
			$str=(int)$temps[$i]['year'].($temps[$i]['month']<10?'0'.$temps[$i]['month']:$temps[$i]['month']).($temps[$i]['day']<10?'0'.$temps[$i]['day']:$temps[$i]['day']);
			if($str>$end_str)break;
			if($str>=$start_str){

				$feel[$j]=$temps[$i];$j++;
			}
		}
		/****		获取  精帖  表数据	****/

		$sql="select *from max_article where A_number=15 and year>=".$start[0]." and year<=".$end[0]." order by year asc,month asc,day asc";
		$temps=M("max_article")->query($sql);
		for($i=0,$j=0;$i<count($temps);$i++){
			$str=(int)$temps[$i]['year'].($temps[$i]['month']<10?'0'.$temps[$i]['month']:$temps[$i]['month']).($temps[$i]['day']<10?'0'.$temps[$i]['day']:$temps[$i]['day']);
			if($str>$end_str)break;
			if($str>=$start_str){
				$jh[$j]=$temps[$i];$j++;
			}
		}
		$city=array('','长沙市','株洲市','湘潭市','衡阳市','岳阳市','益阳市','常德市','邵阳市','娄底市','永州市','郴州市','怀化市','湘西州','张家界');
		$data=array('feel'=>$feel,'jh'=>$jh,'city'=>$city);
		$fileName=__CSV__.'admin/'.I('session.admin').'/';
		if(!is_dir($fileName)){mkdir($fileName);}
		$fileName.='temp.csv';
		$download=__CSVD__.'admin/'.I('session.admin').'/temp.csv';
		copy(__CSV__.'x.csv', $fileName);

		$this->writeData($fileName,$data);
		echo $download;
	}
	public function recordDownload(){
		if(!$this->check_login())die();
		$city=array('所有','长沙市','株洲市','湘潭市','衡阳市','岳阳市','益阳市','常德市','邵阳市','娄底市','永州市','郴州市','怀化市','湘西州','张家界');
		$data=array(
			'time'=>time(),
			'account'=>I("session.admin"),
			'ip'=>getIp(),
			'download'=>$city[I('post.city')].I('post.start').'->'.I('post.end')
		);//dump($data);
		if(M('admindownloadrecord')->data($data)->add())echo true;else echo false;

	}


	private function writeData($fileName,$data){

		$fp=fopen($fileName,'w');
		flock($fp,LOCK_EX);
		fwrite($fp,"\xEF\xBB\xBF");//解决汉字乱码
		$blank=array("","");

		/*******		写入feel数据		**********/
		/*  "日期","地区","happy","good","anger","sorrow","fear","evil","surprise","cps" */
		$temp=array("日期","地区","happy","good","anger","sorrow","fear","evil","surprise","cps");
		fputcsv($fp, $temp);
		for($i=0;$i<count($data['feel']);$i++){
			$y=$data['feel'][$i]['year'];
			$m=$data['feel'][$i]['month'];	if($m<10)$m='0'.$m;
			$d=$data['feel'][$i]['day'];	if($d<10)$d='0'.$d;
			$arr=array(
					$y.$m.$d,
					$data['city'][$data['feel'][$i]['A_number']],
					$data['feel'][$i]['happy'],
					$data['feel'][$i]['good'],
					$data['feel'][$i]['anger'],
					$data['feel'][$i]['sorrow'],
					$data['feel'][$i]['fear'],
					$data['feel'][$i]['evil'],
					$data['feel'][$i]['surprise'],
					$data['feel'][$i]["cps"]
			);
			fputcsv($fp, $arr);
		}
		/*****			*******/
		fputcsv($fp, $blank);
		fputcsv($fp, $blank);	/**		两空行	***/

		/******		红网精帖数据	*****/
		fputcsv($fp, array('红网精帖'));
		$temp=array('日期','地区','标题','作者','链接','回复数');
		fputcsv($fp, $temp);
		for($i=0;$i<count($data['jh']);$i++){
			$y=$data['jh'][$i]['year'];
			$m=$data['jh'][$i]['month'];	if($m<10)$m='0'.$m;
			$d=$data['jh'][$i]['day'];	if($d<10)$d='0'.$d;
			$arr=array(
					$y.$m.$d,
					$data['city'][$data['jh'][$i]['A_number']],
					$data['jh'][$i]['title'],
					$data['jh'][$i]['author'],
					$data['jh'][$i]['url'],
					$data['jh'][$i]['replies']
			);
			fputcsv($fp, $arr);
		}
		/******		END   红网精帖数据	*****/
	}
}