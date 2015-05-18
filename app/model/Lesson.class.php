<?php

require_once('/model/Model.class.php');

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
	 Fills the lesson model from a db row

	 @param array $data
	*/
	public static function fillFromRowData($data) {
		$instance = new self();

		$data_map = array(
			'id'           => (int)$data['id'],
			'name'         => (string)$data['name'],
			'weekday'      => (int)$data['weekday'],
			'lessonTimeID' => (int)$data['lessonTimeID'],
			'courseID'     => (int)$data['courseID']
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}
}