<?php

require_once(__DIR__ . '/../model/Model.class.php');
require_once(__DIR__ . '/../datamapper/CourseMapper.class.php');

class Course extends Model {
	/*
	 The ID of the course
	*/
	public $id = null;

	/*
	 The name of the course
	*/
	public $name = null;

	/*
	 The teacher ID of the course
	*/
	public $teacherID = null;

	/*
	 Fills the course model from a db row

	 @param array $data
	 @return Course
	*/
	public static function fillFromRowData($data) {
		$instance = new self();

		$data_map = array(
			'id'         => $data['id'],
			'name'       => $data['name'],
			'teacher_id' => $data['teacher_id']
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}
}