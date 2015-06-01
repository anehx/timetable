<?php

/**
 * This is the lesson time mapper
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace datamapper;

use model\LessonTime;

class LessonTimeMapper extends Mapper {
	/**
	 * Mapper singleton
	 *
	 * @var \datamapper\LessonTimeMapper
	 */
	protected static $singleton = null;

	/**
	 * Returns a single lesson time by its identifier
	 *
	 * @param int $id
	 * @throws \UnexpectedValueException
	 * @return \model\LessonTime
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
			throw new \UnexpectedValueException('No lesson time with this ID found');
		} else {
			$data = $result->fetch_assoc();
			return LessonTime::fillFromRowData($data);
		}
	}

	/**
	 * Returns an array of all lesson times
	 *
	 * @return array
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

	/**
	 * Updates or creates a lesson time
	 *
	 * @param \model\LessonTime $lessonTime
	 * @return void
	 */
	public function save(\model\LessonTime $lessonTime) {
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

	/**
	 * Deletes a lesson time
	 *
	 * @param int $id
	 * @return void
	 */
	public function delete($id) {
		$stmt = $this->db->prepare("DELETE FROM `lessontime` WHERE `id` = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
}
