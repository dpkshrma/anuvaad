<?php

require_once 'Model.php';

class datastore_retrieve extends Model{

	private static $model_kind = '';
	private $properties = array();
	private static $req_properties = [];

	/**
	 * [__construct : sets key id and property values in instance variables $key_name and $property_vals for every new entity of kind MODEL_KIND ]
	 * @param [String] $prop_values [Property values for new entity]
	 * @param [int] $id          [Entity Id]
	 */
	public function __construct( $prop_values=null) {
	    parent::__construct();
	    if ($prop_values) {
			foreach ($this->properties as $key => $value){ unset($this->properties[$key]);}
			$this->setKeyName($prop_values["key_name"]);
		    foreach ( self::$req_properties as $property ) {
		    	if (!array_key_exists($property, $prop_values)) {
		    		die("Property key ".$property." is not set. Required keys in properties array : ".implode(', ', self::$req_properties));
		    	}
		    	if ($prop_values[$property]!=null) {
					$this->properties[$property] = $prop_values[$property];
		    	}else{
		    		$this->properties[$property] = 0;
		    	}
		    }
	    }
	}

	public static function set_required_fields($rfields){
		// remove any previously stored values in required fields
		foreach (self::$req_properties as $key => $value) unset(self::$req_properties[$key]);

		foreach ($rfields as $field => $value) {
			self::$req_properties[] = $value;
		}
	}

	public function getObject() {
    	return $this->properties;
	}

	public static function setKind($kind){
		self::$model_kind = $kind;
	}

	protected static function getKindName() {
		return self::$model_kind;
	}

	/**
	* Generate the entity property map from the object properties fields.
	*/
	protected function getKindProperties() {
		$property_map = [];

	    foreach ( $this->properties as $property => $value)
			$property_map[$property] = parent::createStringProperty($value, true);

		return $property_map;
	}

	/**
	* Fetch a object given its email.  If get a cache miss, fetch from the Datastore.
	* @param $feed_url URL of the feed.
	*/
	public static function get($email) {
		$mc = new Memcache();
		$mc->connect('127.0.0.1', '11211');
		$key = self::getCacheKey($email);
		$response = $mc->get($key);
		if ($response) {
		  return [$response];
		}

		$query = parent::createQuery(self::$model_kind);
		$email_filter = parent::createStringFilter(self::$req_properties['propfield'],$email);
		$filter = parent::createCompositeFilter([$email_filter]);
		$query->setFilter($filter);
		$results = parent::executeQuery($query);
		$extracted = self::extractQueryResults($results);
		return $extracted;
	}

	private static function getCacheKey($email) {
		return sprintf("%s_%s", self::$model_kind, sha1($email));
	}

	/**
	* This method will be called after a Datastore put.
	*/
	protected function onItemWrite() {
/*		$mc = new Memcache();
		try {
			$key = self::getCacheKey($this->properties['propfield']);
			$mc->add($key, $this, 0, 120);
		}
		catch (Google_Cache_Exception $ex) {
			syslog(LOG_WARNING, "in onItemWrite: memcache exception");
		}*/
	}
	
	/**
	* This method will be called prior to a datastore delete
	*/
	protected function beforeItemDelete() {

		// Connection creation
/*		$mc = new Memcache();
		$mc->connect('127.0.0.1', '11211');
		$key = self::getCacheKey($this->properties['email']);
		$mc->delete($key);*/
	}

	/**
	* Extract the results of a Datastore query into FeedModel objects
	* @param $results Datastore query results
	*/
	protected static function extractQueryResults($results) {
		$query_results = [];
		foreach($results as $result) {
			$id = @$result['entity']['key']['path'][0]['id'];
			$key_name = @$result['entity']['key']['path'][0]['name'];
			$props = $result['entity']['properties'];
			$params = [];
			foreach (self::$req_properties as $property) {
				$params[$property] = $props[$property]->getStringValue();
			}
			$params['key_name'] = $key_name;
			$feed_model = new datastore_retrieve($params);
			$feed_model->setKeyId($id);
			$feed_model->setKeyName($key_name);
			// Cache this read feed.
			$feed_model->onItemWrite();

			$query_results[] = $feed_model;
		}
		// var_dump($query_results);
		return $query_results;
	}
}