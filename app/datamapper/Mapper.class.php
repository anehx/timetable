<?php

class Mapper {
	/*
	 Mapper singleton
	*/
	protected static $singleton = null;

	/*
	 The db connection
	*/
	protected $db = null;

	/*
	 Returns an instance of this mapper
	*/
	public static function getInstance() {
		if (static::$singleton === null) {
			static::$singleton = new static();
		}

		return static::$singleton;
	}

	/*
	 The class constructor
	*/
	public function __construct() {
		$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ($this->db->connect_error) {
			die('Connection failed: ' . $this->db->connect_error);
		}

		$this->db->set_charset('utf-8');
	}

}