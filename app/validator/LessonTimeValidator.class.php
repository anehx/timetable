<?php

namespace validator;

use validator\Validator;

class LessonTimeValidator extends Validator {
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
		$this->validateStartTime();
		$this->validateEndTime();

		return $this;
	}

	/*
	 Validates the start time
	*/
	private function validateStartTime() {
		$fieldName = 'Start Time';
		$fieldValue = $this->model->startTime;

		$this->checkTime($fieldValue, $fieldName);
	}

	/*
	 Validates the end time
	*/
	private function validateEndTime() {
		$fieldName = 'End Time';
		$fieldValue = $this->model->endTime;

		$this->checkTime($fieldValue, $fieldName);
	}
}
