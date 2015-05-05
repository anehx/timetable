<?php

require_once('../inc/model/User.class.php');
require_once('../inc/datamapper/Mapper.class.php');

class UserMapper extends Mapper {

	public function getUserByID($id) {
		$query = sprintf('
			SELECT * FROM `user`
			WHERE `user`.`id` = %d
			LIMIT 1
		', $this->db->real_escape_string($id));

		$result = $this->db->query($query)->fetch_assoc();

		if (!$result) {
			throw new UnexpectedValueException;
		}

		return self::fillFromRowData($result->fetch_assoc());
	}

	public function getUserByUsername($username) {
		$query = sprintf("
			SELECT * FROM `user`
			WHERE `user`.`username` = '%s'
			LIMIT 1
		", $this->db->real_escape_string($username));

		$result = $this->db->query($query)->fetch_assoc();

		if (!$result) {
			throw new UnexpectedValueException;
		}

		return User::fillFromRowData($result);
	}

	public function __construct() {
		parent::__construct();
	}
}