<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR . get_include_path());
require_once APPPATH . 'third_party/Google/Service/Oauth2.php';
// require_once base_url().'../third_party/Google/Client.php';

class GoogleOauth2 extends Google_Service_Oauth2 {
    function __construct($params = array()) {
        parent::__construct($params['client_obj']);
    }
}