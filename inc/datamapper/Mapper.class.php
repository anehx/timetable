<?php

include_once('../inc/db.php');

class Mapper {
	
	public $db = null;

	public static $singleton = null;

	public static function getInstance() {
		if (self::$singleton === null) {
			self::$singleton = new static();
		}

		return self::$singleton;
	}

	public function __construct() {
		$db_conf = getDbConf();
		$this->db = new mysqli($db_conf['servername'], $db_conf['username'], $db_conf['password'], $db_conf['dbname']);

		if ($this->db->connect_error) {
			die('Connection failed: ' . $this->db->connect_error);
		}
	}

}