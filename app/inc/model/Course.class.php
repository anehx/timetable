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

namespace inc\model;

use inc\datamapper\CourseMapper;
use inc\datamapper\UserMapper;
use inc\datamapper\LessonMapper;
use inc\validator\CourseValidator;

class Course extends \lib\Model {
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
	 * @return \inc\model\Course
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
	 * @return \inc\model\User
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
	 * @return \inc\datamapper\CourseMapper
	 */
	public function getMapper() {
		return CourseMapper::getInstance();
	}

	/**
	 * Returns the course validator
	 *
	 * @return \inc\validator\CourseValidator
	 */
	public function getValidator() {
		return new CourseValidator($this);
	}
}
