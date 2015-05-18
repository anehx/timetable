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

	/*
	 Returns an array of all lesson times

	 @returns array
	*/
	public function getLessonTimes() {
		$stmt = $this->db->prepare("SELECT * FROM `lessontime` ORDER BY `startTime`");
		$stmt->execute();

		$result = $stmt->get_result();
		$lessonTimes = array();

		if ($result->num_rows) {
			while ($row = $result->fetch_assoc()) {
				$lessonTimes[] = LessonTime::fillFromRowData($row);
			}
		}

		return $lessonTimes;
	}

	/*
	 Updates or creates a lesson time

	 @param LessonTime $lessonTime
	*/
	public function save($lessonTime) {
		if (!$lessonTime->id) {
			$stmt = $this->db->prepare("
				INSERT INTO `lessontime` (`startTime`, `endTime`) VALUES (
					?, ?
				)
			");

			$stmt->bind_param(
				'ss',
				$lessonTime->startTime->format('H:i:s'),
				$lessonTime->endTime->format('H:i:s')
			);
		}
		else {
			$stmt = $this->db->prepare("
				UPDATE `lessontime` SET 
					`startTime`= ?,
					`endTime` = ?
				WHERE `id` = ?
				");

			$stmt->bind_param(
				'ssi',
				$lessonTime->startTime->format('H:i:s'),
				$lessonTime->endTime->format('H:i:s'),
				$lessonTime->id
			);
		}

		$stmt->execute();

		if (!$lessonTime->id) {
			$lessonTime->id = $this->db->insert_id;
		}
	}

	/*
	 Deletes a lesson time

	 @param int $id
	*/
	public function delete($id) {
		$stmt = $this->db->prepare("DELETE FROM `lessontime` WHERE `id` = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
}