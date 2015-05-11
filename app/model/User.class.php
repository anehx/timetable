<?php

require_once('model/Model.class.php');
require_once('datamapper/UserMapper.class.php');

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
			'id'          => (int)$data['id'],
			'username'    => (string)$data['username'],
			'password'    => (string)$data['password'],
			'firstName'   => (string)$data['firstName'],
			'lastName'    => (string)$data['lastName'],
			'isSuperuser' => (bool)$data['isSuperuser']
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}

	/*
	 Returns the datamapper
	*/
	public function getMapper() {
		return UserMapper::getInstance();
	}
}