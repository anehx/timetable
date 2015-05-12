<?php

require_once('/validator/Validator.class.php');

class CourseValidator extends Validator {
	public function __construct($model) {
		parent::__construct($model);
	}

	public function validate() {
		$this->validateName();
		$this->validateUserID();

		return $this;
	}

	private function validateName() {
		if (preg_match('/[^A-Za-z0-9]+/', $this->model->name)) {
			$this->errors[] = 'No special chars allowed';
			$this->isValid  = false;
		}
	}

	private function validateUserID() {
		try {
			$user = UserMapper::getInstance()->getUserByID($this->model->userID, true);
		}
		catch (UnexpectedValueException $e) {
			$this->errors[] = $e->getMessage();
			$this->isValid  = false;
		}
	}
}