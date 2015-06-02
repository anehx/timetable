<?php

/**
 * This is the course validator
 *
 * It validates every field of the course model
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\validator;

use inc\datamapper\UserMapper;

class CourseValidator extends \lib\Validator {
	/**
	 * The class constructor
	 *
	 * @param \model\Course $model
	 * @return void
	 */
	public function __construct(\model\Course $model) {
		parent::__construct($model);
	}

	/**
	 * Validates the whole course model
	 *
	 * @return void
	 */
	public function validate() {
		$this->validateName();
		$this->validateUserID();

		return $this;
	}

	/**
	 * Validates the course name
	 *
	 * @return void
	 */
	private function validateName() {
		$fieldName = 'Name';
		$fieldValue = $this->model->name;

		$this->checkMutation($fieldValue, $fieldName);
		$this->checkSpecialChar($fieldValue, $fieldName);
		$this->checkWhitespace($fieldValue, $fieldName);
		$this->checkLength($fieldValue, $fieldName, 1, 50);
	}

	/**
	 * Validates the course user
	 *
	 * @return void
	 */
	private function validateUserID() {
		if ($this->model->userID) {
			try {
				$user = UserMapper::getInstance()->getUserByID($this->model->userID, true);
			}
			catch (\UnexpectedValueException $e) {
				$this->errors[] = $e->getMessage();
				$this->isValid  = false;
			}
		}
	}
}