<?php

require_once('/datamapper/Mapper.class.php');
require_once('/model/Lection.class.php');

class LectionMapper extends Mapper {
	/*
	 Mapper singleton
	*/
	private static $singleton = null;

	/*
	 Returns an instance of this mapper
	*/
	public static function getInstance() {
		if (self::$singleton === null) {
			self::$singleton = new static();
		}

		return self::$singleton;
	}

	/*
	 Returns a single lection by its id

	 @param int $id
	 @returns Lection
	*/
	public function getLectionByID($id) {
		$stmt = $this->db->prepare('
			SELECT * FROM `lection`
			WHERE `id` = ?
			LIMIT 1
		');

		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if (!$result->num_rows) {
			throw new UnexpectedValueException('No lection with this ID found');
		} else {
			$data = $result->fetch_assoc();
			return Lection::fillFromRowData($data);
		}
	}
}