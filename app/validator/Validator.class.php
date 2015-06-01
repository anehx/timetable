<?php

/**
 * This is the basic validator
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace validator;

class Validator {
	/**
	 * The model to validate
	 */
	protected $model = null;

	/**
	 * Is the model valid?
	 */
	public $isValid = true;

	/**
	 * The validation errors
	 */
	public $errors = [];

	/**
	 * The class constructor
	 */
	public function __construct($model) {
		$this->model = $model;
	}

	/**
	 * Checks if a string contains mutations
	 *
	 * @param string $str
	 * @param string $fieldName
	 */
	protected function checkMutation($str, $fieldName) {
		if (preg_match('/ÄÖÜäöüßéàè+/', $str)) {
			$this->errors[] = sprintf('Field "%s" must not contain mutations', $fieldName);
			$this->isValid  = false;
		}
	}


	/**
	 * Checks if a string contains whitespaces
	 *
	 * @param string $str
	 * @param string $fieldName
	 */
	protected function checkWhitespace($str, $fieldName) {
		if (preg_match('/\s+/', $str)) {
			$this->errors[] = sprintf('Field "%s" must not contain whitespaces', $fieldName);
			$this->isValid  = false;
		}
	}

	/**
	 * Checks if a string contains special chars
	 *
	 * @param string $str
	 * @param string $fieldName
	 */
	protected function checkSpecialChar($str, $fieldName) {
		if (preg_match('/[^A-Za-z0-9ÄÖÜäöüßéàè\s]+/', $str)) {
			$this->errors[] = sprintf('Field "%s" must not contain special chars', $fieldName);
			$this->isValid  = false;
		}
	}

	/**
	 * Checks if a string length is between $min and $max
	 *
	 * @param string $str
	 * @param string $fieldName
	 * @param int $min
	 * @param int $max
	 */
	protected function checkLength($str, $fieldName, $min, $max) {
		if (strlen($str) > $max || strlen($str) < $min) {
			$this->errors[] = sprintf('Field "%s" must be between %d and %d chars', $fieldName, $min, $max);
			$this->isValid  = false;
		}
	}

	/**
	 * Checks if a time is a datetime object
	 *
	 * @param datetime $dt
	 * @param string $fieldName
	 */
	protected function checkTime($dt, $fieldName) {
		if (!is_a($dt, 'DateTime')) {
			$this->errors[] = sprintf('Field "%s" must be a datetime', $fieldName);
			$this->isValid  = false;
		}
	}
}