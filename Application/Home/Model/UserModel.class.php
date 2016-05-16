<?php
namespace Home\Model;
use Think\Model;

class UserModel extends Model{
	
	protected $_auto = array(
		array('password','md5',3,'function')
	);
}