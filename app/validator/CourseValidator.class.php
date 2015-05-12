<?php

require_once('/validator/Validator.class.php');

class CourseValidator extends Validator {
	/*
	 The class constructor
	*/
	public function __construct($model) {
		parent::__construct($model);
	}

	/*
	 Validates the whole course model
	*/
	public function validate() {
		$this->validateName();
		$this->validateUserID();

		return $this;
	}

	/*
	 Validates the course name
	*/
	private function validateName() {
		$fieldName = 'Name';
		$fieldValue = $this->model->name;

		$this->checkMutation($fieldValue, $fieldName);
		$this->checkSpecialCharOrWhitespace($fieldValue, $fieldName);
		$this->checkLength($fieldValue, $fieldName, 1, 50);
	}

	/*
	 Validates the course user
	*/
	private function validateUserID() {
		if ($this->model->userID) {
			try {
				$user = UserMapper::getInstance()->getUserByID($this->model->userID, true);
			}
			catch (UnexpectedValueException $e) {
				$this->errors[] = $e->getMessage();
				$this->isValid  = false;
			}
		}
	}
}