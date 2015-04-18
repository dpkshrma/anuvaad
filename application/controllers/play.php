<?php if ( ! defined('BASEPATH')) exit("No direct script access allowed");

class Play extends CI_Controller{
	
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
	public function index( $play_type = "practice" ){
		
		$this->body_data['play_type'] = $play_type;

		$this->load->view('templates/loggedin/header',$this->header_data);
		$this->load->view('play/choose_game',$this->body_data);
		$this->load->view('templates/loggedin/footer');

		if (isset($_GET['logout'])) {
			$this->session->unset_userdata('access_token');
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
	public function comics($play_type){
		echo $play_type;
	}
	public function quotes_category($play_type){

		if ($play_type=='practice') {
		}
		else if($play_type == 'compete'){
		}

		$popular_topics = ['inspirational','motivational','funny','positive','Life','Love','Success','Wisdom','Happiness','Smile','Friendship','Change','Leadership','Education','Family','Music','Birthday',];
		$authors = [];
		
		$file = fopen(base_url()."assets/data/quote_authors.csv","r");
		$authors = fgetcsv($file);
		fclose($file);

		$this->body_data['play_type'] = $play_type;
		$this->body_data['authors'] = $authors;
		$this->body_data['topics'] = $popular_topics;

		$this->load->view('templates/loggedin/header',$this->header_data);
		$this->load->view('play/quotes/select_category',$this->body_data);
		$this->load->view('templates/loggedin/footer');
	}
	public function quotes($play_type){
		if (isset($_POST['selected_topics'])) {
			$this->session->set_userdata(array('selected_topics'=>explode(',',$_POST['selected_topics'])));
			if ($this->session->set_userdata('selected_authors') !== false) {
				$this->session->unset_userdata('selected_authors');
			}
		}
		if (isset($_POST['selected_authors'])) {
			$this->session->set_userdata(array('selected_authors'=>explode(',',$_POST['selected_authors'])));
			if ($this->session->set_userdata('selected_topics') !== false) {
				$this->session->unset_userdata('selected_topics');
			}
		}

		if ($this->session->userdata('selected_topics')) {
			$this->body_data['selected_topics'] = $this->session->userdata('selected_topics');
			// echo strlen( serialize( $this->session->userdata ) );
			$this->body_data['play_type'] = $play_type;
			$this->load->view('templates/loggedin/header',$this->header_data);
			$this->load->view('play/quotes/translate_quote',$this->body_data);
			$this->load->view('templates/loggedin/footer');
		}
		else if ($this->session->userdata('selected_authors')) {
			$this->body_data['selected_authors'] = $this->session->userdata('selected_authors');
			$this->body_data['play_type'] = $play_type;
			$this->load->view('templates/loggedin/header',$this->header_data);
			$this->load->view('play/quotes/translate_quote',$this->body_data);
			$this->load->view('templates/loggedin/footer');
		}
	}
	public function get_quote($author,$offset,$is_author) {
		$en_text = "";
		$hi_text = "";
		$initial = substr($author,0,1);
		if ($is_author == 1) {
			$url = "http://www.brainyquote.com/quotes/authors/".$initial."/".$author.".html";
		}else{
			$url = "http://www.brainyquote.com/quotes/topics/topic_".$author.".html";
		}
		$dom = new DomDocument;
		@$dom->loadHTML($this->file_get_contents_curl($url));
		$xpath = new DOMXPath($dom);

		$quotes = $xpath->query("//span[@class='bqQuoteLink']");

		$quote = $quotes->item($offset);
		$links = $quote->childNodes;
		$link = $links->item(0);
		$quote_id = $link->getAttribute('href');
		$quote_id = explode('.',end(explode('/', $quote_id)))[0];

		$this->load->library('google/gds/GoogleDSS');
		$kind = 'quote_stats_'.explode('@',$this->session->userdata('email'))[0];
		$res = null;
		$res = $this->googledss->read_by_name($kind,$quote_id,['result_seen']);

		// only untried quotes to be shown
		if ($res == null) {
			// if this quote matches to solved quotes list, then, dont use it!!
			$en_text = $link->nodeValue;

			$translate_from = 'en';
			$translate_into = 'hi';
			$translate_url = "http://translate.google.com/?sl=". $translate_from ."&tl=". $translate_into ."&js=n&prev=_t&hl=en&ie=UTF-8&eotf=1&text=". urlencode($link->nodeValue) ."";
			$new_dom = new DomDocument;
			@$new_dom->loadHTML($this->file_get_contents_curl($translate_url));
			$transxpath = new DOMXPath($new_dom);
			$text = $transxpath->query("//span[@id='result_box']");
			foreach ($text as $t) {
				$hi_text .= $t->nodeValue;
			}
			$data = array("hindi_text"=>$hi_text,"english_text"=>$en_text,"quote_id"=>$quote_id,"submitted_quote"=>false);
			echo json_encode($data);
		}else{
			$data = array("submitted_quote"=>true);
			echo json_encode($data);
		}
	}

	public function store_quote_score($quote_id,$score,$time_left){
		/*check if quuote has already been submitted if yes, and current quote is better than previous submission, oly then store in the database*/
		// key = email, props = arrays of
		$this->load->library('google/gds/GoogleDSS');
		$kind = 'quote_stats_'.explode('@',$this->session->userdata('email'))[0];
		$res = null;
		$res = $this->googledss->read_by_name($kind,$quote_id,['score']);
		if ($res == null) {
			$prop_vals = ['key_name'=>$quote_id,
						'score' => $score,
						'time_left'=>$time_left,
						'result_seen'=>'0']; // result_seen is for checking if user has seen the answer using quote contribution (while correcting google translation)
			$prop_vals['req_fields'] = ['score','time_left','result_seen'];
			$this->googledss->write_by_name($kind,$prop_vals);
		}
	}
	public function file_get_contents_curl($url) {
		$options =array("http"=>array("method" => "GET"));
		$context = stream_context_create($options);
		$data = file_get_contents($url, false, $context);
		return $data;
	}
}