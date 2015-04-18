<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR . get_include_path());
require_once APPPATH . 'third_party/Google/Service/Datastore.php';

class GoogleDatastoreCommitRequest extends Google_Service_Datastore_CommitRequest {
    function __construct($params = array()) {
        parent::__construct();
    }
}