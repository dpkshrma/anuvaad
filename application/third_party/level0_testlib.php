<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Level0_testlib extends CI_Controller{
	private static $instance;

	function __construct(){
	}

	public static function getInstance(){
	    if (self::$instance == null) {
			throw new UnexpectedValueException('Instance has not been set.');
		}
		return "This is your instance value right over here : ".self::$instance;
	} 

	public static function setInstance($instance){
	    if (self::$instance != null) {
	      throw new UnexpectedValueException('Instance has already been set.');
	    }
	    self::$instance = $instance;
	}

}