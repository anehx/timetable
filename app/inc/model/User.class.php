<?php

/**
 * This is user model
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\model;

use inc\datamapper\UserMapper;
use inc\validator\UserValidator;

class User extends \lib\Model {
	/**
	 * The identifier of the user
	 *
	 * @var int
	 */
	public $id = null;

	/**
	 * The unique username of the user
	 *
	 * @var string
	 */
	public $username = null;

	/**
	 * The password hash of the user
	 *
	 * @var string
	 */
	public $password = null;

	/**
	 * The plain password of the user
	 * This is only used for creation and password change
	 *
	 * @var string
	 */
	public $rawPassword = null;

	/**
	 * The first name of the user (optional)
	 *
	 * @var string
	 */
	public $firstName = null;

	/**
	 * The last name of the user (optional)
	 *
	 * @var string
	 */
	public $lastName = null;

	/**
	 * Is this user a superuser?
	 *
	 * @var boolean
	 */
	public $isSuperuser = false;

	/**
	 * Fills the user model from a db row
	 *
	 * @param array $data
	 * @return \inc\model\User
	 */
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
	 */
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
	 * @return \inc\datamapper\UserMapper
	 */
	public function getMapper() {
		return UserMapper::getInstance();
	}

	/**
	 * Returns the user validator
	 *
	 * @return \inc\validator\UserValidator
	 */
	public function getValidator() {
		return new UserValidator($this);
	}
}
