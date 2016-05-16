<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\AdminModel;
use Home\Model\UserModel;

class LoginController extends Controller{
	
	public function index(){
		if(I('session.admin')){
			$this->redirect('Admin/Index/index');
			die();
		}
		$this->display();
	}
	public function checkAccount(){
		$checkcode=I('post.checkcode');
		if(!check_verify($checkcode)){echo "验证码错误!";return 1;}
		else{
			$admin=new AdminModel();
			$admin->create();
			$find=M("admin")->where(array('account'=>$admin->account,'password'=>$admin->password))->count();
			if($find){
				$_SESSION['admin']=$admin->account;
				echo "1";
			}else{
				echo "账号密码不匹配！";
			}
		}
	}
	public function verify(){
		$config = array(
				'fontSize' => 15, // 验证码字体大小
				'length' => 4, // 验证码位数
				'useNoise' => false, // 关闭验证码杂点
				'useCurve'=>false,
				//'codeSet'	=> 'ABCDEFGHIGKLMNOPQRSTUVWXYZ',
				'fontttf'=>'7.otf',//字体
				'imageH'=>'34',
				'imageW'=>'120',
		);
		$Verify = new \Think\Verify($config);
		echo $Verify->entry();
	}
	
}
