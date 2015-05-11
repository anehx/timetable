<?php

require_once('datamapper/Mapper.class.php');
require_once('model/Course.class.php');

class CourseMapper extends Mapper {
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
		$stmt = $this->db->prepare("SELECT * FROM `course`");
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
	 Deletes a course
	*/
	public function delete($id) {
		$stmt = $this->db->prepare("DELETE FROM `course` WHERE `id` = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
}