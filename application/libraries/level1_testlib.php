<?php if(!defined('BASEPATH')) die("No direct script access allowed");

set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR . get_include_path());
require_once APPPATH . 'third_party/level0_testlib.php';

class Level1_testlib {
	function __construct($instance=array()){
		Level0_testlib::setInstance($instance['instance']);
	}
	public function getinst(){
		var_dump(Level0_testlib::getInstance());
	}
}