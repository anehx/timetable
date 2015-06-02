<?php

/**
 * This is the basis class of all models
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace lib;

class Model {
	/**
	 * Returns the datamapper
	 *
	 * @throws UnexpectedValueException
	 * @return void
	 */
	public function getMapper() {
		throw new \UnexpectedValueException(sprintf('You need to define a getMapper function on the %s model', get_called_class()));
	}

	/**
	 * Returns the validator
	 *
	 * @throws UnexpectedValueException
	 * @return void
	 **/
	public function getValidator() {
		throw new \UnexpectedValueException(sprintf('You need to define a getValidator function on the %s model', get_called_class()));
	}

	/**
	 * Saves this object to the DB
	 *
	 * @return void
	 */
	public function save() {
		$this->getMapper()->save($this);
	}

	/**
	 * Deletes this object from the DB
	 *
	 * @return void
	 */
	public function delete() {
		$this->getMapper()->delete($this->id);
	}

	/**
	 * Validates the model
	 *
	 * @return \lib\Validator
	 */
	public function validate() { 
		return $this->getValidator()->validate();
	}

	/**
	 * Fills the model from a db row
	 *
	 * @param array $data
	 * @return static
	 */
	public static function fill($data) {
		$instance = new static();

		foreach ($data as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}
}
