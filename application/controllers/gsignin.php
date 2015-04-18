<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gsignin extends CI_Controller {

	public function index()
	{
		ob_start();
		$app_name = "Anuvaad";
		$dev_key = "AIzaSyAQUVYlq6colMkGH1rYQMfU7-voRIXHBbs";
		$client_id = "601147901460-4ds1ihmb72aoh20tuph2gfs3d3e0mrhh.apps.googleusercontent.com";
		$client_secret = "ZKOnWXjG1_FPvDRCkvQG9qUI";
		$scopes = array('https://www.googleapis.com/auth/plus.me','https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/admin.directory.user','https://www.google.com/m8/feeds');
		$redirect_uri = "http://".$_SERVER['HTTP_HOST']."/gsignin";

		$this->googleapi->setApplicationName($app_name);
		$this->googleapi->setDeveloperKey($dev_key);
		$this->googleapi->setClientId($client_id);
		$this->googleapi->setClientSecret($client_secret);
		$this->googleapi->setRedirectUri($redirect_uri);
		$this->googleapi->setScopes($scopes);

		if (isset($_GET['logout'])) {
			$this->session->unset_userdata('access_token');
			$this->session->sess_destroy();
		}

		if (isset($_GET['code'])) {
		    $this->googleapi->authenticate($this->input->get('code'));
			$this->session->set_userdata('access_token',$this->googleapi->getAccessToken());
		    $redirect = current_url(); // php_self doesnt work
		    $redirect = filter_var($redirect, FILTER_SANITIZE_URL);
		    redirect($redirect);
		}

		if ($this->session->userdata('access_token') != FALSE) {
    		$this->googleapi->setAccessToken($this->session->userdata('access_token'));
		}

		if ($this->googleapi->getAccessToken()) {
		    $access_token = $this->googleapi->getAccessToken();
			$client = array('client_obj'=>$this->googleapi);
			$this->load->library('google/GoogleOauth2',$client);
			$oauth = $this->googleoauth2;
			$user = $oauth->userinfo->get();

			$userinfo = array(
				'name'=>$user->name,
				'email'=>$user->email,
				'gender'=>$user->gender,
				'gplus_link'=>$user->link,
				'photo_link'=>$user->picture,
			);

			$this->session->set_userdata($userinfo);

			$query = $this->db->query('SELECT email FROM users where email='.$this->db->escape($userinfo['email']));
			if ($query->num_rows() == 0) {
				foreach ($userinfo as $key => $value) {
					$userinfo[$key] = $this->db->escape($userinfo[$key]);
				}
				$sql = "INSERT INTO users(uid, email, gplus_link, name, photo_link)
						VALUES (NULL,".$userinfo['email'].",".$userinfo['gplus_link'].",".$userinfo['name'].",".$userinfo['photo_link'].")";
				$this->db->query($sql);

				$url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=500&access_token='.json_decode($access_token)->access_token;
				$dom = new DomDocument;
				$dom->loadXML($this->file_get_contents_curl($url));
				$xpath = new DOMXPath($dom);
				$xpath->registerNamespace('gd', 'http://schemas.google.com/g/2005');

				$emails = $xpath->query('//gd:email');
				// $phonenos = $xpath->query('//gd:phoneNumber');
				$contacts = array();
				foreach ( $emails as $email )
				{
					$contact_name = $email->parentNode->getElementsByTagName('title')->item(0)->textContent;
					$contact_email = $email->getAttribute('address');
					$links = $email->parentNode->getElementsByTagName('link');

					$img_src = $links->item(0)->getAttribute('href').'?access_token='.json_decode($access_token)->access_token;
					$img_src_arr = explode('/', $img_src);
					$img_src_arr=$img_src_arr[count($img_src_arr)-2].'/'.explode('?',$img_src_arr[count($img_src_arr)-1])[0];
					$contacts[] = $contact_name.','.$contact_email.','.$img_src_arr;
				}

				$query = $this->db->query('SELECT uid FROM users where email='.$userinfo['email']);
				$uid = $query->row()->uid;

				$sql = "INSERT INTO contacts (uid, contacts)
				        VALUES (".$this->db->escape($uid).", ".$this->db->escape(json_encode($contacts)).")";
				$this->db->query($sql);
			}

			/*	Complete image path : (use urlencode while passing user email add)
				https://www.google.com/m8/feeds/photos/media/{useremail_add}/{img_src_arr}?access_token={from session}
			*/

/*			foreach ( $phonenos as $phno )
			{
				$phoneNumber = $phno->nodeValue;
				$links = $phno->parentNode->getElementsByTagName('link');
				$img_src = $links->item(0)->getAttribute('href').'?access_token='.json_decode($access_token)->access_token;
				$img_src_arr = explode('/', $img_src);
				$img_src_arr=$img_src_arr[count($img_src_arr)-2].'/'.explode('?',$img_src_arr[count($img_src_arr)-1])[0];
			}*/

			header("Location:".base_url());
		}
		else{
		    $data['auth_url'] = $this->googleapi->createAuthUrl();
		    $this->load->view('gsignin',$data);
		}
	}

	public function file_get_contents_curl($url) {
	    $options =array("http"=>array("method" => "GET"));
		$context = stream_context_create($options);
		$data = file_get_contents($url, false, $context);
	    return $data;
	}

}

/* End of file gsignin.php */
/* Location: ./application/controllers/gsignin.php */