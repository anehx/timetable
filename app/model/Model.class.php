<?php

class Model {
	/*
	 Returns the datamapper
	*/
	public function getMapper() {
		throw new UnexpectedValueException(sprintf('You need to define a getMapper function on the %s model', get_called_class()));
	}

	/*
	 Returns the validator
	*/
	public function getValidator() {
		throw new UnexpectedValueException(sprintf('You need to define a getValidator function on the %s model', get_called_class()));
	}

	/*
	 Saves this object to the DB
	*/
	public function save() {
		$this->getMapper()->save($this);
	}

	/*
	 Deletes this object from the DB
	*/
	public function delete() {
		$this->getMapper()->delete($this->id);
	}

	/*
	 Validates the model

	 @return Validator
	*/
	public function validate() { 
		return $this->getValidator()->validate();
	}

	/*
	 Fills the model from a db row

	 @param array $data
	 @return Model
	*/
	public static function fill($data) {
		$instance = new static();

		foreach ($data as $key => $value) {
			$instance->{$key} = $value;
		}

		return $instance;
	}
}