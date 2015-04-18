<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		$data['curl'] = current_url();
		$this->load->view('rules',$data);
	}
}