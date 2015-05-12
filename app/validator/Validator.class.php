<?php

class Validator {
	/*
	 The model to validate
	*/
	protected $model = null;

	/*
	 Is the model valid?
	*/
	public $isValid = true;

	/*
	 The validation errors
	*/
	public $errors = [];

	/*
	 The class constructor
	*/
	public function __construct($model) {
		$this->model = $model;
	}
}