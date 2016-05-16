<?php
namespace Home\Controller;

use Think\Controller;
use Home\Model\UserModel;

class LoginController extends Controller{
	
	public function index(){
		$this->error('页面不存在！',U('/Home/Index/index'));
	}
	public function login(){
		$this->display();
	}
	public function register(){
		if(!I('post.account'))
		{
			$this->display();//echo I('post.account');
		}else{
			if(M('user')->where(array('account'=>I('post.account')))->count() >0){
				$this->error("注册失败！ 账号已存在！ 请重试。",U('/Home/Login/register'));
			}else{
				$user=new UserModel();
				$user->create();
				$user->time=time();
				$_SESSION['account']=$user->account;
				$user->add();
				$this->success("注册成功，即将跳转到首页！",U("/Home/Index/index"));
			}
		}
	}
	public function checkLogin(){
		if(!I('post.account'))
		{
			$this->error("错误页面！",U('Home/Login/index'));
		}else{
			$user=new UserModel();
			$user->create();
			if(M('user')->where(array('account'=>$user->account,'password'=>$user->password))->count()>0){
				$_SESSION['account']=$user->account;
				$this->success("登陆成功！",U('/Home/Index/index'));
			}else{
				$this->error('密码错误，请重新登陆！',U('Home/Login/login'));
			}
		}
	}
	/*注册相关*/
	public function checkAccount(){
		
		$ac=I('POST.ac');
		$num=M('user')->where(array('account'=>$ac))->count();
		if($num>0)echo false;
		else echo true;
	}
	/*END注册相关*/
	public function logout(){
		session_destroy();
		$this->success('退出成功!',U('/Home/Index/index'));
	}
	
}