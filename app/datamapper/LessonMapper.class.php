<?php

require_once('/datamapper/Mapper.class.php');
require_once('/model/Lesson.class.php');

class LessonMapper extends Mapper {
	/*
	 Mapper singleton
	*/
	private static $singleton = null;

	/*
	 Returns an instance of this mapper
	*/
	public static function getInstance() {
		if (self::$singleton === null) {
			self::$singleton = new static();
		}

		return self::$singleton;
	}

	/*
	 Returns a single lesson by its id

	 @param int $id
	 @returns Lesson
	*/
	public function getLessonByID($id) {
		$stmt = $this->db->prepare('
			SELECT * FROM `lesson`
			WHERE `id` = ?
			LIMIT 1
		');

		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if (!$result->num_rows) {
			throw new UnexpectedValueException('No lesson with this ID found');
		} else {
			$data = $result->fetch_assoc();
			return Lesson::fillFromRowData($data);
		}
	}
}