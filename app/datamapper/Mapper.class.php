<?php

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
		$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($this->db->connect_error) {
			die('Connection failed: ' . $this->db->connect_error);
		}

		$this->db->set_charset('utf-8');
	}

}