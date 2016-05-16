<?php
namespace Admin\Controller;
use Think\Controller;



class IndexController extends Controller {
    public function index(){
		
    	if(!I('session.admin')){
    		$this->redirect('Admin/Login/index');
    		die();
    	}
    	$this->display();
    }
    public function header(){
    	$this->display();
    }
    public function menu(){
    	$this->display();
    }
    public function main(){
    	$this->display();
    }
}







