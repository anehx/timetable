<?php

require_once('/model/Model.class.php');

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
	 Fills the lessiontime model from a db row

	 @param array $data
	*/
	public static function fillFromRowData($data) {
		$instance = new self();

		$data_map = array(
			'id'        => (int)$data['id'],
			'startTime' => new DateTime(date('H:i:s', strtotime($data['startTime']))),
			'endTime'   => new DateTime(date('H:i:s', strtotime($data['endTime'])))
		);

		foreach ($data_map as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}
}