<?php

/**
 * This is the user validator
 *
 * It validates every field of the user model
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace validator;

use datamapper\UserMapper;

class UserValidator extends Validator {
	/**
	 * The class constructor
	 *
	 * @param \model\User
	 * @return void
	 */
	public function __construct(\model\User $model) {
		parent::__construct($model);
	}

	/**
	 * Validates the whole user model
	 *
	 * @return void
	 */
	public function validate() {
		$this->validateUsername();
		$this->validatePassword();
		$this->validateFirstName();
		$this->validateLastName();

		return $this;
	}

	/**
	 * Validates the first name
	 *
	 * @return void
	 */
	private function validateFirstName() {
		if ($this->model->firstName) {
			$fieldName = 'First Name';
			$fieldValue = $this->model->firstName;

			$this->checkSpecialChar($fieldValue, $fieldName);
			$this->checkLength($fieldValue, $fieldName, 1, 50);
		}
	}

	/**
	 * Validates the last name
	 *
	 * @return void
	 */
	private function validateLastName() {
		if ($this->model->lastName) {
			$fieldName = 'Last Name';
			$fieldValue = $this->model->lastName;

			$this->checkSpecialChar($fieldValue, $fieldName);
			$this->checkLength($fieldValue, $fieldName, 1, 50);
		}
	}

	/**
	 * Validates the password
	 *
	 * @return void
	 */
	private function validatePassword() {
		if ($this->model->rawPassword) {
			$fieldName = 'Password';
			$fieldValue = $this->model->rawPassword;

			$this->checkLength($fieldValue, $fieldName, 6, 50);

			if (preg_match('/[^A-Za-z0-9#%&\/()?!$-_]+/', $fieldValue)) {
				$this->errors[] = 'Field "Password" can only contain these characters: A-Za-z0-9#%&/()?!$-_';
				$this->isValid = false;
			}

			if (!preg_match('/[0-9]{1}|[#%&\/()?!$-_]{1}/', $fieldValue)) {
				$this->errors[] = 'Field "Password" must contain at least one digit or special char';
				$this->isValid = false;
			}
		}
	}

	/**
	 * Validates the username
	 *
	 * @return void
	 */
	private function validateUsername() {
		if (!$this->model->id) {
			$fieldName = 'Username';
			$fieldValue = $this->model->username;

			$this->checkMutation($fieldValue, $fieldName);
			$this->checkSpecialChar($fieldValue, $fieldName);
			$this->checkWhitespace($fieldValue, $fieldName);
			$this->checkLength($fieldValue, $fieldName, 1, 50);

			try {
					$user = UserMapper::getInstance()->getUserByUsername($this->model->username);
					$this->errors[] = 'User with this username already exists';
					$this->isValid  = false;
				}
			catch (\UnexpectedValueException $e) {
				// expected behaviour
			}
		}
	}
}