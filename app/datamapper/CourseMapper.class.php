<?php

require_once('datamapper/Mapper.class.php');
require_once('model/Course.class.php');

class CourseMapper extends Mapper {
	/*
	 Mapper singleton
	*/
	protected static $singleton = null;

	/*
	 Returns a single course by its id

	 @param int $id
	 @returns Course
	*/
	public function getCourseByID($id) {
		$stmt = $this->db->prepare('
			SELECT * FROM `course`
			WHERE `id` = ?
			LIMIT 1
		');

		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if (!$result->num_rows) {
			throw new UnexpectedValueException('No course with this ID found');
		} else {
			$data = $result->fetch_assoc();
			return Course::fillFromRowData($data);
		}
	}
	
	/*
	 Returns an array of all courses

	 @returns array
	*/
	public function getCourses() {
		$stmt = $this->db->prepare("SELECT * FROM `course` ORDER BY `name`");
		$stmt->execute();

		$result = $stmt->get_result();
		$courses = array();

		if ($result->num_rows) {
			while ($row = $result->fetch_assoc()) {
				$courses[] = Course::fillFromRowData($row);
			}
		}

		return $courses;
	}

	/*
	 Returns an array of all courses of an user

	 @param int $userID
	 @returns array
	*/
	public function getCoursesByUser($userID) {
		$stmt = $this->db->prepare("
			SELECT
				*
			FROM `course`
			WHERE `userID` = ?
		");

		$stmt->bind_param('i', $userID);
		$stmt->execute();

		$result = $stmt->get_result();
		$courses = array();

		if ($result->num_rows) {
			while ($row = $result->fetch_assoc()) {
				$courses[] = Course::fillFromRowData($row);
			}
		}

		return $courses;
	}

	/*
	 Updates or creates a course

	 @param Course $course
	*/
	public function save($course) {
		if (!$course->id) {
			$stmt = $this->db->prepare("
				INSERT INTO `course` (`name`, `userID`) VALUES (
					?, ?
				)
			");

			$stmt->bind_param(
				'si',
				$course->name,
				$course->userID
			);
		}
		else {
			$stmt = $this->db->prepare("
				UPDATE `course` SET 
					`name`= ?,
					`userID` = ?
				WHERE `id` = ?
				");

			$stmt->bind_param(
				'sii',
				$course->name,
				$course->userID,
				$course->id
			);
		}

		$stmt->execute();

		if (!$course->id) {
			$course->id = $this->db->insert_id;
		}
	}

	/*
	 Deletes a course
	*/
	public function delete($id) {
		$stmt = $this->db->prepare("DELETE FROM `course` WHERE `id` = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
}