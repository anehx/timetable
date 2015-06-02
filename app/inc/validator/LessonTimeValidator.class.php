<?php

/**
 * This is the lesson time validator
 *
 * It validates every field of the lesson time model
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\validator;

class LessonTimeValidator extends \lib\Validator {
	/**
	 * The class constructor
	 *
	 * @param \model\LessonTime $model
	 * @return void
	 */
	public function __construct(\model\LessonTime $model) {
		parent::__construct($model);
	}

	/**
	 * Validates the whole lesson time model
	 *
	 * @return void
	 */
	public function validate() {
		$this->validateStartTime();
		$this->validateEndTime();

		return $this;
	}

	/**
	 * Validates the start time
	 *
	 * @return void
	 */
	private function validateStartTime() {
		$fieldName = 'Start Time';
		$fieldValue = $this->model->startTime;

		$this->checkTime($fieldValue, $fieldName);
	}

	/**
	 * Validates the end time
	 *
	 * @return void
	 */
	private function validateEndTime() {
		$fieldName = 'End Time';
		$fieldValue = $this->model->endTime;

		$this->checkTime($fieldValue, $fieldName);
	}
}