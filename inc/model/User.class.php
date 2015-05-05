<?php

class User {
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
	 Fills the user model from a db row

	 @param array $data
	*/
	public static function fillFromRowData($data) {
		$instance = new self();

		$data_map = array(
			'id'            => $data['id'],
			'username'      => $data['username'],
			'password_hash' => $data['password_hash'],
			'password_salt' => $data['password_salt'],
			'first_name'    => $data['first_name'],
			'last_name'     => $data['last_name']
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}

	public function checkPassword($input) {
		return (crypt($input, $this->password_salt) == $this->password_hash);
	}

	public function login() {
		$_SESSION['username'] = $this->username;
	}
}