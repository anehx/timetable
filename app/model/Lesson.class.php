<?php

require_once('/model/Model.class.php');
require_once('/datamapper/LessonMapper.class.php');
require_once('/datamapper/LessonTimeMapper.class.php');
require_once('/validator/LessonValidator.class.php');

class Lesson extends Model {
	/*
	 The id of the lesson
	*/
	public $id = null;

	/*
	 The name of the lesson
	*/
	public $name = null;

	/*
	 The weekday of the lesson
	*/
	public $weekday = null;

	/*
	 The time of the lesson
	*/
	public $lessonTimeID = null;

	/*
	 The courseID of the lesson
	*/
	public $courseID = null;

	/*
	 Weekday integer to string map
	*/
	public $weekdayMap = array(
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday',
		7 => 'Sunday'
	);

	/*
	 Fills the lesson model from a db row

	 @param array $data
	 @return Lesson
	*/
	public static function fillFromRowData($data) {
		$dataMap = array(
			'id'           => (int)$data['id'],
			'name'         => (string)$data['name'],
			'weekday'      => (int)$data['weekday'],
			'lessonTimeID' => (int)$data['lessonTimeID'],
			'courseID'     => (int)$data['courseID']
		);

		return parent::fill($dataMap);
	}

	/*
	 Gets the weekday as a string
	*/
	public function getWeekday() {
		return $this->weekdayMap[$this->weekday];
	}

	/*
	 Gets related lesson time
	*/
	public function getLessonTime() {
		return LessonTimeMapper::getInstance()->getLessonTimeByID($this->lessonTimeID);
	}

	/*
	 Returns the datamapper
	*/
	public function getMapper() {
		return LessonMapper::getInstance();
	}

	/*
	 Returns the validator
	*/
	public function getValidator() {
		return new LessonValidator($this);
	}
}