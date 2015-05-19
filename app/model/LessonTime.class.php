<?php

require_once('/model/Model.class.php');
require_once('/datamapper/LessonTimeMapper.class.php');
require_once('/validator/LessonTimeValidator.class.php');

class LessonTime extends Model {
	/*
	 The id of the lesson
	*/
	public $id = null;

	/*
	 The start time of the lesson time
	*/
	public $startTime = null;

	/*
	 The end time of the lesson time
	*/
	public $endTime = null;

	/*
	 Fills the lession time model from a db row

	 @param array $data
	*/
	public static function fillFromRowData($data) {
		$dataMap = array(
			'id'        => (int)$data['id'],
			'startTime' => new DateTime(date('H:i:s', strtotime($data['startTime']))),
			'endTime'   => new DateTime(date('H:i:s', strtotime($data['endTime'])))
		);

		return parent::fill($dataMap);
	}

	/*
	 Returns the display name
	*/
	public function getDisplayName() {
		return sprintf('%s - %s', $this->startTime->format('H:i'), $this->endTime->format('H:i'));
	}

	/*
	 Returns the datamapper
	*/
	public function getMapper() {
		return LessonTimeMapper::getInstance();
	}

	/*
	 Returns the validator
	*/
	public function getValidator() {
		return new LessonTimeValidator($this);
	}
}