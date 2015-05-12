<?php

require_once('/model/Model.class.php');

class Lection extends Model {
	/*
	 The id of the lection
	*/
	public $id = null;

	/*
	 The name of the lection
	*/
	public $name = null;

	/*
	 The weekday of the lection
	*/
	public $weekday = null;

	/*
	 The time of the lection
	*/
	public $lectionTimeID = null;

	/*
	 The courseID of the lection
	*/
	public $courseID = null;

	/*
	 Fills the lection model from a db row

	 @param array $data
	*/
	public static function fillFromRowData($data) {
		$instance = new self();

		$data_map = array(
			'id'            => (int)$data['id'],
			'name'          => (string)$data['name'],
			'weekday'       => (int)$data['weekday'],
			'lectionTimeID' => (int)$data['lectionTimeID'],
			'courseID'      => (int)$data['courseID']
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}
}