<?php

require_once('/datamapper/Mapper.class.php');
require_once('/model/LessonTime.class.php');

class LessonTimeMapper extends Mapper {
	/*
	 Mapper singleton
	*/
	protected static $singleton = null;

	/*
	 Returns a single lesson time by its id

	 @param int $id
	 @returns LessonTime
	*/
	public function getLessonTimeByID($id) {
		$stmt = $this->db->prepare('
			SELECT * FROM `lessontime`
			WHERE `id` = ?
			LIMIT 1
		');

		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if (!$result->num_rows) {
			throw new UnexpectedValueException('No lesson time with this ID found');
		} else {
			$data = $result->fetch_assoc();
			return LessonTime::fillFromRowData($data);
		}
	}
}