<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data = array();
		$data['title'] = "Anuvaad";
		if ($this->session->userdata('access_token') !=FALSE) {
			$data['user_image'] = $this->session->userdata('photo_link');
			$login_status = "loggedin";
		}else{
			$login_status = "loggedout";
		}
		$this->load->view('templates/'.$login_status.'/header',$data);
		$this->load->view('welcome_message');
		$this->load->view('templates/'.$login_status.'/footer');
		if (isset($_GET['logout'])) {
			$this->session->unset_userdata('access_token');
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */