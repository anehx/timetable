<?php

/**
 * This is the lesson model
 *
 * Lessons are displayed in the overview and are separated
 * by courses
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\model;

use inc\datamapper\CourseMapper;
use inc\datamapper\LessonMapper;
use inc\datamapper\LessonTimeMapper;
use inc\validator\LessonValidator;

class Lesson extends \lib\Model {
	/**
	 * Weekday integer to string map
	 *
	 * @var array
	 */
	public static $weekday_map = array(
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday',
		7 => 'Sunday'
	);

	/**
	 * The identifier of the lesson
	 *
	 * @var int
	 */
	public $id = null;

	/**
	 * The name of the lesson
	 *
	 * @var string
	 */
	public $name = null;

	/**
	 * The weekday on which the lesson is hold
	 *
	 * @var int
	 */
	public $weekday = null;

	/**
	 * The time range of the lesson
	 *
	 * @var int
	 */
	public $lessonTimeID = null;

	/**
	 * The courseID of the lesson
	 *
	 * @var int
	 */
	public $courseID = null;

	/**
	 * Fills the lesson model from a db row
	 *
	 * @param array $data
	 * @return \inc\model\Lesson
	 */
	public static function fillFromRowData($data) {
		$dataMap = array(
			'id'           => (int)$data['id'],
			'name'         => (string)$data['name'],
			'weekday'      => (int)$data['weekday'],
			'lessonTimeID' => (int)$data['lessonTimeID'],
			'courseID'     => (int)$data['courseID']
		);

		return parent::fill($dataMap);
	}

	/**
	 * Returns the weekday as a string
	 *
	 * @return string
	 */
	public function getWeekday() {
		return self::$weekday_map[$this->weekday];
	}

	/**
	 * Returns the related lesson time
	 *
	 * @return \inc\model\LessonTime
	 */
	public function getLessonTime() {
		return LessonTimeMapper::getInstance()->getLessonTimeByID($this->lessonTimeID);
	}

	/**
	 * Returns the related course
	 *
	 * @return \inc\model\Course
	 */
	public function getCourse() {
		return CourseMapper::getInstance()->getCourseByID($this->courseID);
	}

	/**
	 * Returns the lesson datamapper
	 *
	 * @return \inc\datamapper\LessonMapper
	 */
	public function getMapper() {
		return LessonMapper::getInstance();
	}

	/**
	 * Returns the lesson validator
	 *
	 * @return \inc\validator\LessonValidator
	 */
	public function getValidator() {
		return new LessonValidator($this);
	}
}
