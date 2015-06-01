<?php

/**
 * This is the lesson mapper
 *
 * @package    timetable
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 **/

use datamapper\Mapper;
use model\Lesson;

class LessonMapper extends Mapper {
	/**
	 * Mapper singleton
	 **/
	protected static $singleton = null;

	/**
	 * Returns a single lesson by its identifier
	 *
	 * @param int $id
	 * @throws UnexpectedValueException
	 * @return model\Lesson
	 **/
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

	/**
	 * Returns all lessons of a course
	 *
	 * @param int $courseID
	 * @return array
	 **/
	public function getLessonsByCourse($courseID) {
		$stmt = $this->db->prepare('
			SELECT * FROM `lesson`
			WHERE `courseID` = ?
			ORDER BY `weekday`
		');

		$stmt->bind_param('i', $courseID);
		$stmt->execute();

		$result = $stmt->get_result();
		$lessons = array();

		if ($result->num_rows) {
			while ($row = $result->fetch_assoc()) {
				$lessons[] = Lesson::fillFromRowData($row);
			}
		}

		return $lessons;
	}

	/**
	 * Returns a lesson of a course on a specific time
	 *
	 * @param int $lessonTimeID
	 * @param int $weekday
	 * @param int $courseID
	 * @throws UnexpectedValueException
	 * @return model\Lesson
	 **/
	public function getLessonByTimeAndCourse($lessonTimeID, $weekday, $courseID) {
		$stmt = $this->db->prepare('
			SELECT * FROM `lesson`
			WHERE `courseID` = ? AND `lessonTimeID` = ? AND `weekday` = ?
			LIMIT 1
		');

		$stmt->bind_param('iii', $courseID, $lessonTimeID, $weekday);
		$stmt->execute();

		$result = $stmt->get_result();

		if (!$result->num_rows) {
			throw new UnexpectedValueException('No lesson with this time and course found');
		} else {
			$data = $result->fetch_assoc();
			return Lesson::fillFromRowData($data);
		}
	}

	/**
	 * Updates or creates a lesson
	 *
	 * @param model\Lesson $lesson
	 **/
	public function save(model\Lesson $lesson) {
		if (!$lesson->id) {
			$stmt = $this->db->prepare("
				INSERT INTO `lesson` (`name`, `weekday`, `lessonTimeID`, `courseID`) VALUES (
					?, ?, ?, ?
				)
			");

			$stmt->bind_param(
				'siii',
				$lesson->name,
				$lesson->weekday,
				$lesson->lessonTimeID,
				$lesson->courseID
			);
		}
		else {
			$stmt = $this->db->prepare("
				UPDATE `lesson` SET 
					`name`= ?,
					`weekday` = ?,
					`lessonTimeID` = ?
				WHERE `id` = ?
				");

			$stmt->bind_param(
				'siii',
				$lesson->name,
				$lesson->weekday,
				$lesson->lessonTimeID,
				$lesson->id
			);
		}

		$stmt->execute();

		if (!$lesson->id) {
			$lesson->id = $this->db->insert_id;
		}
	}

	/**
	 * Deletes a lesson
	 *
	 * @param int $id
	 **/
	public function delete($id) {
		$stmt = $this->db->prepare("DELETE FROM `lesson` WHERE `id` = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
}
