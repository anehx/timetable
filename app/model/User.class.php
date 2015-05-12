<?php

require_once('/model/Model.class.php');
require_once('/datamapper/UserMapper.class.php');
require_once('/validator/UserValidator.class.php');

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
	 The password of the user
	*/
	public $password = null;

	/*
	 The raw password of the user (only used for creation and pw change)
	*/
	public $raw_password = null;

	/*
	 The first name of the user (optional)
	*/
	public $firstName = null;

	/*
	 The last name of the user (optional)
	*/
	public $lastName = null;

	/*
	 The is the user a superuser?
	*/
	public $isSuperuser = false;

	/*
	 Fills the user model from a db row

	 @param array $data
	*/
	public static function fillFromRowData($data) {
		$instance = new self();

		$data_map = array(
			'id'           => (int)$data['id'],
			'username'     => (string)$data['username'],
			'password'     => (string)$data['password'],
			'firstName'    => (string)$data['firstName'],
			'lastName'     => (string)$data['lastName'],
			'isSuperuser'  => (bool)$data['isSuperuser']
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}

	/*
	 Retruns the display name of the user

	 @return string
	*/
	public function getDisplayName() {
		if (!empty($this->firstName) && !empty($this->lastName)) {
			return sprintf('%s %s', $this->firstName, $this->lastName);
		}
		else {
			return $this->username;
		}
	}

	/*
	 Returns the datamapper
	*/
	public function getMapper() {
		return UserMapper::getInstance();
	}

	/*
	 Returns the validator
	*/
	public function getValidator() {
		return new UserValidator($this);
	}
}