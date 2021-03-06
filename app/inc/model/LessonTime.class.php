<?php

/**
 * This is lesson time model
 * 
 * Lesson times are used to define time ranges in which
 * lessons can be hold
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\model;

use inc\datamapper\LessonTimeMapper;
use inc\validator\LessonTimeValidator;

class LessonTime extends \lib\Model {
	/**
	 * The identifier of the lesson time
	 *
	 * @var int
	 */
	public $id = null;

	/**
	 * The start time of the lesson time
	 *
	 * @var \DateTime
	 */
	public $startTime = null;

	/**
	 * The end time of the lesson time
	 *
	 * @var \DateTime
	 */
	public $endTime = null;

	/**
	 * Fills the lession time model from a db row
	 *
	 * @param array $data
	 * @return \inc\model\LessonTime
	 */
	public static function fillFromRowData($data) {
		$dataMap = array(
			'id'        => (int)$data['id'],
			'startTime' => new \DateTime(date('H:i:s', strtotime($data['startTime']))),
			'endTime'   => new \DateTime(date('H:i:s', strtotime($data['endTime'])))
		);

		return parent::fill($dataMap);
	}

	/**
	 * Returns the display name
	 *
	 * @return string
	 */
	public function getDisplayName() {
		return sprintf('%s - %s', $this->startTime->format('H:i'), $this->endTime->format('H:i'));
	}

	/**
	 * Returns the lesson time datamapper
	 *
	 * @return \inc\datamapper\LessonTimeMapper
	 */
	public function getMapper() {
		return LessonTimeMapper::getInstance();
	}

	/**
	 * Returns the lesson time validator
	 *
	 * @return \inc\validator\LessonTimeValidator
	 */
	public function getValidator() {
		return new LessonTimeValidator($this);
	}
}
