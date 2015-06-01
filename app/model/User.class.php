<?php

/**
 * This is user model
 *
 * @package    timetable
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 **/

namespace model;

use datamapper\UserMapper;
use model\Model;
use validator\UserValidator;

class User extends Model {
	/**
	 * The identifier of the user
	 **/
	public $id = null;

	/**
	 * The unique username of the user
	 **/
	public $username = null;

	/**
	 * The password hash of the user
	 **/
	public $password = null;

	/**
	 * The plain password of the user
	 * This is only used for creation and password change
	 **/
	public $rawPassword = null;

	/**
	 * The first name of the user (optional)
	 **/
	public $firstName = null;

	/**
	 * The last name of the user (optional)
	 **/
	public $lastName = null;

	/**
	 * Is this user a superuser?
	 **/
	public $isSuperuser = false;

	/**
	 * Fills the user model from a db row
	 *
	 * @param array $data
	 * @return User
	 **/
	public static function fillFromRowData($data) {
		$dataMap = array(
			'id'           => (int)$data['id'],
			'username'     => (string)$data['username'],
			'password'     => (string)$data['password'],
			'firstName'    => (string)$data['firstName'],
			'lastName'     => (string)$data['lastName'],
			'isSuperuser'  => (bool)$data['isSuperuser']
		);

		return parent::fill($dataMap);
	}

	/**
	 * Returns the display name of the user
	 *
	 * @return string
	 **/
	public function getDisplayName() {
		if (!empty($this->firstName) && !empty($this->lastName)) {
			return sprintf('%s %s', $this->firstName, $this->lastName);
		}
		else {
			return $this->username;
		}
	}

	/**
	 * Returns the user datamapper
	 *
	 * @return UserMapper
	 **/
	public function getMapper() {
		return UserMapper::getInstance();
	}

	/**
	 * Returns the user validator
	 *
	 * @return UserValidator
	 **/
	public function getValidator() {
		return new UserValidator($this);
	}
}
