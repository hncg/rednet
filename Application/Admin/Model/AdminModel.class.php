<?php
namespace Admin\Model;

use Think\Model;

class AdminModel extends Model{
	protected $_auto = array(
			array('password','md5',3,'function')
	);
}