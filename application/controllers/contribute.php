<?php if(!defined('BASEPATH')) exit("No direct script access allowed");

class Contribute extends CI_Controller{
	private $header_data = [];
	private $body_data = [];
	private $footer_data = [];
	
	public function __construct(){
		parent::__construct();
		// Data common to all functions comes here
		$this->header_data['title'] = "Anuvaad -- Play";
		if ($this->session->userdata('access_token') !=FALSE) {
			$this->header_data['user_image'] = $this->session->userdata('photo_link');
		}
		else{
			redirect('welcome');
		}
	}

	public function quotes($quote_id=null){
		if ($quote_id!=null) {

			// add this quote as seen as soon as user visits this page
			$this->load->library("google/gds/GoogleDSS");
			$kind = 'quote_stats_'.explode('@',$this->session->userdata('email'))[0];
			$res = null;
			$res = $this->googledss->read_by_name($kind,$quote_id,['score','time_left']);

			$params = array(
					'req_fields'=>array('result_seen','score','time_left'),
					'key_name'=>$quote_id,
					'result_seen'=>"1",
					'score'=>"0",
					'time_left'=>"0",
				);

			if ($res != null) {
				$params['score'] = $res['score'];
				$params['time_left'] = $res['time_left'];
			}
			$this->googledss->write_by_name($kind,$params);

			// now show the quote for translation
			$en_text = "";
			$hi_text = "";
			$initial = substr($quote_id,0,1);
			$url = "http://www.brainyquote.com/quotes/quotes/".$initial."/".$quote_id.".html";
			$dom = new DomDocument;
			@$dom->loadHTML($this->file_get_contents_curl($url));
			$xpath = new DOMXPath($dom);

			$quotes = $xpath->query("//div[@class='bq_fq bq_fq_lrg']");

			$quote = $quotes->item(0)->childNodes->item(1);
			$en_text = $quote->nodeValue;

			$translate_from = 'en';
			$translate_into = 'hi';
			$translate_url = "http://translate.google.com/?sl=". $translate_from ."&tl=". $translate_into ."&js=n&prev=_t&hl=en&ie=UTF-8&eotf=1&text=". urlencode($quote->nodeValue) ."";

			$new_dom = new DomDocument;
			@$new_dom->loadHTML($this->file_get_contents_curl($translate_url));
			$transxpath = new DOMXPath($new_dom);
			$text = $transxpath->query("//span[@id='result_box']");
			foreach ($text as $t) {
				$hi_text .= $t->nodeValue;
			}
			$hi_text = array("hindi_text"=>$hi_text);
			$hi_text = substr(explode(':',json_encode($hi_text))[1],1,-2);

			$this->body_data = [
								'hindi_text'=>$hi_text,
								'english_text'=> $en_text,
								'quote_id'=>$quote_id
							];
			$this->load->view('templates/loggedin/header',$this->header_data);
			$this->load->view('contribute/quotes',$this->body_data);
			$this->load->view('templates/loggedin/footer',$this->footer_data);

		}
	}
	public function submit_improved_quote($quote_id=null,$en_trans=null){

		if ($quote_id == null || $en_trans == null) {
			redirect("play");
		}

		$this->load->library("google/gds/GoogleDSS");

		$this->body_data['written'] = false;

		if ($this->googledss->read_by_name('improved_quotes',$quote_id,['timestamp']) == null){
			$req_fields = ['submitted_by','timestamp','quote'];
			$params = [	"key_name"=>$quote_id,
						'submitted_by'=>$this->session->userdata('email'),
						'timestamp'=>date("Y-m-d H:i:s"),
						'quote'=>substr(json_encode(urldecode($en_trans)),1,-1),
						];
			$params['req_fields'] = $req_fields;
			$this->googledss->write_by_name("improved_quotes",$params);
			$this->body_data['written'] = true;
		}
		$this->load->view("templates/loggedin/header",$this->header_data);
		$this->load->view("contribute/quote_submit_success",$this->body_data);
		$this->load->view("templates/loggedin/footer",$this->footer_data);
	}
	public function file_get_contents_curl($url) {
		$options =array("http"=>array("method" => "GET"));
		$context = stream_context_create($options);
		$data = file_get_contents($url, false, $context);
		return $data;
	}
}