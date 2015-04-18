<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR . get_include_path());
require_once APPPATH . 'third_party/Google/Auth/AssertionCredentials.php';

class GoogleAuthAssertCredentials extends Google_Auth_AssertionCredentials {
    function __construct($params = array()) {
        parent::__construct($params['service-account-name'],$params['scopes'],$params['private-key']);
    }
}