<?php

require_once(__DIR__ . '/../model/User.class.php');
require_once(__DIR__ . '/Mapper.class.php');

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

		return User::fillFromRowData($result);
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

	public function getUsers() {
		$query = "SELECT * FROM `user`";

		$result = $this->db->query($query)->fetch_all(MYSQLI_ASSOC);

		if (!$result) {
			throw new UnexpectedValueException;
		}

		$users = array();

		foreach ($result as $row) {
			$users[] = User::fillFromRowData($row);
		}

		return $users;
	}

	public function __construct() {
		parent::__construct();
	}

	public function save($user) {
		if (!$user->id) {
			$query = sprintf("
				INSERT INTO `user` (`username`, `first_name`, `last_name`, `password_hash`, `password_salt`, `is_superuser`) VALUES (
					'%s', '%s', '%s', '%s', '%s', %d
				)
				",
				$user->username,
				$user->first_name,
				$user->last_name,
				$user->password_hash,
				$user->password_salt,
				$user->is_superuser
			);
		}
		else {
			$query = sprintf("
				UPDATE `user` SET 
					`first_name`= '%s',
					`last_name` = '%s',
					`password_hash` = '%s',
					`password_salt` = '%s',
					`is_superuser` = %d
				WHERE `user`.`id` = %d
				",
				$user->first_name,
				$user->last_name,
				$user->password_hash,
				$user->password_salt,
				(int)$user->is_superuser,
				(int)$user->id
			);
		}
		$this->db->query($query);
		if (!$user->id) {
			$user->id = $this->db->insert_id;
		}
	}
}