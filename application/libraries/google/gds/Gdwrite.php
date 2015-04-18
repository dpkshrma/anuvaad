<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gdwrite extends CI_Controller {

	public $entity_kind;
	public $entity_name;
	private $gd;

	function __construct($args=array())
	{
		$this->gd = & get_instance();

		$this->entity_kind = "table_name";
		$this->entity_name = "primary key value";

		$google_api_config = array(
		  'application-id' => 'gcdc2014-anuvaad',
		  'service-account-name' => '601147901460-gd457ho3tv4iaiu96cip3m8v4cs6uk99@developer.gserviceaccount.com',
		  'private-key' => file_get_contents(BASEPATH.'../data/anuvaad_gds.p12'),
		  'dataset-id' => 'gcdc2014-anuvaad',
		);

		$scopes = array(
			"https://www.googleapis.com/auth/datastore",
			"https://www.googleapis.com/auth/userinfo.email",
		);

		$client = $args['client'];

		$client->setApplicationName($google_api_config['application-id']);
		$params = array(
			'service-account-name'=>$google_api_config['service-account-name'],
			'scopes'=>$scopes,
			'private-key'=>$google_api_config['private-key']
		);
		$this->gd->load->library('google/GoogleAuthAssertCredentials',$params);
		$auth_credentials = $this->gd->googleauthassertcredentials;
		$client->setAssertionCredentials($auth_credentials);

		$params = array('client'=>$client);
		$this->gd->load->library('google/gds/GoogleDatastore',$params);
		$service = $this->gd->googledatastore;
		$service_dataset = $service->datasets;
		$dataset_id = $google_api_config['dataset-id'];

		try {
			// test the config and connectivity by creating a test entity, building
			// a commit request for that entity, and creating/updating it in the datastore
			$req = $this->create_test_request();
			$service_dataset->commit($dataset_id, $req, []);
		}
		catch (Google_Exception $ex) {
			syslog(LOG_WARNING, 'Commit to Cloud Datastore exception: ' . $ex->getMessage());
			echo "There was an issue -- check the logs.";
			return;
		}

		echo "Connected!";
	}
	public function create_entity() {
		$this->gd->load->library('google/gds/GoogleDatastoreEntity');
		$entity = $this->gd->googledatastoreentity;
		$entity->setKey($this->createKeyForTestItem());
		$this->gd->load->library('google/gds/GoogleDatastoreProperty');
		$string_prop = $this->gd->googledatastoreproperty;
		$string_prop->setStringValue("prop val");
		$property_map = [];
		$property_map["propfield"] = $string_prop;
		$entity->setProperties($property_map);
		return $entity;
	}

	// entity kind = table name
	// entity name = primary key value
	public function createKeyForTestItem() {
		$this->gd->load->library('google/gds/GoogleDatastoreKeyPathElement');
		$path = $this->gd->googledatastorekeypathelement;
		$path->setKind($this->entity_kind);
		$path->setName($this->entity_name);
		$this->gd->load->library('google/gds/GoogleDatastoreKey');
		$key = $this->gd->googledatastorekey;
		$key->setPath([$path]);
		return $key;
	}

	public function create_test_request() {
		$entity = $this->create_entity();

		$this->gd->load->library('google/gds/GoogleDatastoreMutation');
		$mutation = $this->gd->googledatastoremutation;
		$mutation->setUpsert([$entity]);

		$this->gd->load->library('google/gds/GoogleDatastoreCommitRequest');
		$req =$this->gd->googledatastorecommitrequest;
		$req->setMode('NON_TRANSACTIONAL');
		$req->setMutation($mutation);
		return $req;
	}
}