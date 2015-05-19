<?php

require_once('/validator/Validator.class.php');
require_once('/model/Lesson.class.php');
require_once('/datamapper/CourseMapper.class.php');
require_once('/datamapper/LessonMapper.class.php');
require_once('/datamapper/LessonTimeMapper.class.php');

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
		$this->validateName();
		$this->validateWeekday();
		$this->validateCourseID();
		$this->validateLessonTimeID();

		return $this;
	}

	/*
	 Validates the lesson name
	*/
	private function validateName() {
		$fieldName = 'Name';
		$fieldValue = $this->model->name;

		$this->checkSpecialChar($fieldValue, $fieldName);
		$this->checkLength($fieldValue, $fieldName, 1, 50);
	}

	/*
	 Validates the weekday
	*/
	private function validateWeekday() {
		if (!array_key_exists($this->model->weekday, Lesson::WEEKDAY_MAP)) {
			$this->errors[] = 'Invalid weekday';
			$this->isValid = false;
		}
	}

	/*
	 Validates the course
	*/
	private function validateCourseID() {
		if ($this->model->courseID) {
			try {
				$course = CourseMapper::getInstance()->getCourseByID($this->model->courseID);
			}
			catch (UnexpectedValueException $e) {
				$this->errors[] = $e->getMessage();
				$this->isValid  = false;
			}
		}
		else {
			$this->errors[] = 'Must provide a course';
			$this->isValid = false;
		}
	}

	/*
	 Validates the lesson time
	*/
	private function validateLessonTimeID() {
		if ($this->model->lessonTimeID) {
			try {
				$lessonTime = LessonTimeMapper::getInstance()->getLessonTimeByID($this->model->lessonTimeID);
			}
			catch (UnexpectedValueException $e) {
				$this->errors[] = $e->getMessage();
				$this->isValid  = false;
			}
		}
		else {
			$this->errors[] = 'Must provide a lesson time';
			$this->isValid = false;
		}

		try {
			$lesson = LessonMapper::getInstance()->getLessonByTimeAndCourse($this->model->lessonTimeID, $this->model->weekday, $this->model->courseID);
			if ($lesson->id !== $this->model->id) {
				$this->errors[] = 'Lesson with this lesson time already exists';
				$this->isValid = false;
			}
		}
		catch (UnexpectedValueException $e) {
			// expected behaviour
		}
	}
}