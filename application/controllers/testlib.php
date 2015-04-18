<?php if(!defined('BASEPATH')) exit("No direct script access allowed");

class Testlib extends CI_Controller{
	public function index(){
		$params = array();
		$this->load->library("google/gds/GoogleDSS");
/*		if ($this->googledss->read_by_name('table_name','k1')) {
			var_dump($this->googledss->read_by_name('table_name','primary key value'));
		}else{
			echo "key not found";
		}*/

		echo "<pre>";
		$kind = 'quote_stats_'.explode('@',$this->session->userdata('email'))[0];
		$res = null;
		$res = $this->googledss->read_by_name($kind,"drseuss161986",['result_seen','score','time_left']);
		var_dump($res);
		echo "<br><br>";

		$params = array(
				'req_fields'=>array('result_seen','score','time_left'),
				'key_name'=>'drseuss161986',
				'result_seen'=>"1",
				'score'=>$res['score'],
				'time_left'=>$res['time_left'],
			);
		$this->googledss->write_by_name($kind,$params);

		$res = $this->googledss->read_by_name($kind,"drseuss161986",['result_seen','score','time_left']);
		var_dump($res);

		// var_dump($this->googledss->read_by_name('registered_users',$this->session->userdata('email'),['name']));
		/*$params = ["key_name"=>"k4","propfield"=>["email","phoneno"],"somefield"=>"newprop"];
		$req_fields = ['propfield','somefield'];
		$params['req_fields'] = $req_fields;
		$this->googledss->write_by_name("table_name",$params);
		*/
		// var_dump($this->googledss->read_by_name('registered_users',$this->session->userdata('email')));
		// $this->googledss->delete_entity("table_name",$params);

		// var_dump($this->googledss->get_all_entities('table_name'));
		// var_dump($this->googledss->run_gql('table_name','k1'));

		/*$params = array("instance"=>"new instance");
		$this->load->library("level1_testlib",$params);
		$this->level1_testlib->getinst();*/
	}
}