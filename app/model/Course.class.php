<?php

/**
 * This is the course model
 *
 * A course is a group of students which are supervised by an
 * user (teacher)
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace model;

use datamapper\CourseMapper;
use datamapper\UserMapper;
use datamapper\LessonMapper;
use validator\CourseValidator;

class Course extends Model {
	/**
	 * The identifier of the course
	 *
	 * @var int
	 */
	public $id = null;

	/**
	 * The name of the course
	 *
	 * @var string
	 */
	public $name = null;

	/**
	 * The user of the course
	 *
	 * @var int
	 */
	public $userID = null;

	/**
	 * Fills the course model from a db row
	 *
	 * @param array $data
	 * @return \model\Course
	 */
	public static function fillFromRowData($data) {
		$dataMap = array(
			'id'     => (int)$data['id'],
			'name'   => (string)$data['name'],
			'userID' => (int)$data['userID'] ? (int)$data['userID'] : null
		);

		return parent::fill($dataMap);
	}

	/**
	 * Returns the referring user
	 *
	 * @return \model\User
	 */
	public function getUser() {
		return UserMapper::getInstance()->getUserByID($this->userID);
	}

	/**
	 * Returns all lessons of the course
	 *
	 * @return array
	 */
	public function getLessons() {
		return LessonMapper::getInstance()->getLessonsByCourse($this->id);
	}

	/**
	 * Returns the course datamapper
	 *
	 * @return \datamapper\CourseMapper
	 */
	public function getMapper() {
		return CourseMapper::getInstance();
	}

	/**
	 * Returns the course validator
	 *
	 * @return \validator\CourseValidator
	 */
	public function getValidator() {
		return new CourseValidator($this);
	}
}
