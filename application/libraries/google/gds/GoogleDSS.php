<?php if(!defined('BASEPATH')) exit("No direct script access allowed");

set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR . get_include_path());
require_once APPPATH . 'third_party/datastore_retrieve.php';

class GoogleDSS extends datastore_retrieve{

	function __construct($params = array()){
		$google_api_config = array(
		  'application-id' => 'gcdc2014-anuvaad',
		  'service-account-name' => '601147901460-gd457ho3tv4iaiu96cip3m8v4cs6uk99@developer.gserviceaccount.com',
		  'private-key' => file_get_contents(BASEPATH.'../data/anuvaad_gds.p12'),
		  'dataset-id' => 'gcdc2014-anuvaad',
		);
		DatastoreService::setInstance(new DatastoreService($google_api_config));
	}

	public function read_by_name($kind,$key_name,$req_fields){
		datastore_retrieve::setKind($kind);
		datastore_retrieve::set_required_fields($req_fields);
		$data_model_fetched = datastore_retrieve::fetch_by_name($key_name);
		if (isset($data_model_fetched[0])) {
			return $data_model_fetched[0]->getObject();
		}
		return null;
	}

	public function write_by_name($kind,$prop_vals){
		datastore_retrieve::setKind($kind);
		datastore_retrieve::set_required_fields($prop_vals['req_fields']);
		$datamodel = new datastore_retrieve($prop_vals);
		$datamodel->put();
	}
	public function delete_entity($kind,$prop_vals,$txn = null) {
		datastore_retrieve::setKind($kind);
		datastore_retrieve::set_required_fields($prop_vals['req_fields']);
		$datamodel = new datastore_retrieve();
		$datamodel->setKeyName($prop_vals["key_name"]);
		$datamodel->delete($txn);
	}

	public function run_gql($kind,$key_name,$txn=null){
		if (isset(datastore_retrieve::execute_gql($kind,$key_name,$txn)[0])) {
			$data_model_fetched = datastore_retrieve::execute_gql($kind,$key_name,$txn);
			return $data_model_fetched;
		}
		return null;
	}

	public function get_all_entities($kind){
		datastore_retrieve::setKind($kind);
		return datastore_retrieve::all();
	}
}