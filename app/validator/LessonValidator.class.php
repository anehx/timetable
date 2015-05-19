<?php

require_once('/validator/Validator.class.php');

class LessonValidator extends Validator {
	/*
	 The class constructor
	*/
	public function __construct($model) {
		parent::__construct($model);
	}

	/*
	 Validates the whole lesson time model
	*/
	public function validate() {
		return $this;
	}
}