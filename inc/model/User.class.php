<?php

require_once(__DIR__ . '/../model/Model.class.php');
require_once(__DIR__ . '/../datamapper/UserMapper.class.php');

class User extends Model {
	/*
	 The id of the user
	*/
	public $id = null;

	/*
	 The username of the user (unique)
	*/
	public $username = null;

	/*
	 The password hash of the user
	*/
	public $password_hash = null;

	/*
	 The password salt of the user
	*/
	public $password_salt = null;

	/*
	 The first name of the user (optional)
	*/
	public $first_name = null;

	/*
	 The last name of the user (optional)
	*/
	public $last_name = null;

	/*
	 The is the user a superuser?
	*/
	public $is_superuser = false;

	/*
	 Fills the user model from a db row

	 @param array $data
	*/
	public static function fillFromRowData($data) {
		$instance = new self();

		$data_map = array(
			'id'            => (int)$data['id'],
			'username'      => (string)$data['username'],
			'password_hash' => (string)$data['password_hash'],
			'password_salt' => (string)$data['password_salt'],
			'first_name'    => (string)$data['first_name'],
			'last_name'     => (string)$data['last_name'],
			'is_superuser'  => (bool)$data['is_superuser']
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}

	/*
	 Checks if the given password validates

	 @param string $input
	*/
	public function checkPassword($input) {
		return (crypt($input, $this->password_salt) == $this->password_hash);
	}

	/*
	 Logs the user in
	*/
	public function login() {
		$_SESSION['username'] = $this->username;
		$_SESSION['is_superuser'] = $this->is_superuser;
	}

	/*
	 Generates a new password salt
	*/
	public function generateSalt() {
		$this->password_salt = uniqid(mt_rand(), true);
	}

	/*
	 Returns the datamapper
	*/
	public function getMapper() {
		return UserMapper::getInstance();
	}
}