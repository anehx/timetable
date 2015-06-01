<?php

/**
 * This is the lesson model
 *
 * Lessons are displayed in the overview and are separated
 * by courses
 *
 * @package    timetable
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace model;

use datamapper\CourseMapper;
use datamapper\LessonMapper;
use datamapper\LessonTimeMapper;
use validator\LessonValidator;

class Lesson extends Model {
	/**
	 * Weekday integer to string map
	 */
	const WEEKDAY_MAP = array(
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
	 */
	public $id = null;

	/**
	 * The name of the lesson
	 */
	public $name = null;

	/**
	 * The weekday on which the lesson is hold
	 */
	public $weekday = null;

	/**
	 * The time range of the lesson
	 */
	public $lessonTimeID = null;

	/**
	 * The courseID of the lesson
	 */
	public $courseID = null;

	/**
	 * Fills the lesson model from a db row
	 *
	 * @param array $data
	 * @return \model\Lesson
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
		return self::WEEKDAY_MAP[$this->weekday];
	}

	/**
	 * Returns the related lesson time
	 *
	 * @return \model\LessonTime
	 */
	public function getLessonTime() {
		return LessonTimeMapper::getInstance()->getLessonTimeByID($this->lessonTimeID);
	}

	/**
	 * Returns the related course
	 *
	 * @return \model\Course
	 */
	public function getCourse() {
		return CourseMapper::getInstance()->getCourseByID($this->courseID);
	}

	/**
	 * Returns the lesson datamapper
	 *
	 * @return \datamapper\LessonMapper
	 */
	public function getMapper() {
		return LessonMapper::getInstance();
	}

	/**
	 * Returns the lesson validator
	 *
	 * @return \validator\LessonValidator
	 */
	public function getValidator() {
		return new LessonValidator($this);
	}
}
