<?php

require_once('/model/Model.class.php');
require_once('/datamapper/CourseMapper.class.php');
require_once('/datamapper/UserMapper.class.php');
require_once('/validator/CourseValidator.class.php');

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
	 The user ID of the course
	*/
	public $userID = null;

	/*
	 Fills the course model from a db row

	 @param array $data
	 @return Course
	*/
	public static function fillFromRowData($data) {
		$instance = new self();

		$data_map = array(
			'id'     => $data['id'],
			'name'   => $data['name'],
			'userID' => $data['userID']
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}

	/*
	 Returns the referring user

	 @return User
	*/
	public function getUser() {
		return UserMapper::getInstance()->getUserByID($this->userID);
	}

	/*
	 Returns the datamapper
	*/
	public function getMapper() {
		return CourseMapper::getInstance();
	}

	/*
	 Returns the validator
	*/
	public function getValidator() {
		return new CourseValidator($this);
	}
}