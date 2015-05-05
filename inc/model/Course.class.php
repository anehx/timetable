<?php

class Course {
	/*
	 The id of the course
	*/
	public $id = null;

	/*
	 The name of the course
	*/
	public $name = null;

	/*
	 The teacher id of the course
	*/
	public $teacher_id = null;

	/*
	 Fills the course model from a db row

	 @param array $data
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