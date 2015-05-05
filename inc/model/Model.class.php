<?php

class Model {
	public function save() {
		$this->getMapper()->save($this);
	}

	public function delete() {
		$this->getMapper()->delete($this->id);
	}
}