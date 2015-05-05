<?php

class Model {
	public function save() {
		$this->getMapper()->save($this);
	}
}