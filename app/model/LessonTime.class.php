<?php

/**
 * This is lesson time model
 * 
 * Lesson times are used to define time ranges in which
 * lessons can be hold
 *
 * @package    timetable
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace model;

use datamapper\LessonTimeMapper;
use validator\LessonTimeValidator;

class LessonTime extends Model {
	/**
	 * The identifier of the lesson time
	 */
	public $id = null;

	/**
	 * The start time of the lesson time
	 */
	public $startTime = null;

	/**
	 * The end time of the lesson time
	 */
	public $endTime = null;

	/**
	 * Fills the lession time model from a db row
	 *
	 * @param array $data
	 * @return \model\LessonTime
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
	 * @return \datamapper\LessonTimeMapper
	 */
	public function getMapper() {
		return LessonTimeMapper::getInstance();
	}

	/**
	 * Returns the lesson time validator
	 *
	 * @return \validator\LessonTimeValidator
	 */
	public function getValidator() {
		return new LessonTimeValidator($this);
	}
}
