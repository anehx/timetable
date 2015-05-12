<?php

require_once('/datamapper/Mapper.class.php');
require_once('/model/LectionTime.class.php');

class LectionTimeMapper extends Mapper {
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
	 Returns a single lection time by its id

	 @param int $id
	 @returns LectionTime
	*/
	public function getLectionTimeByID($id) {
		$stmt = $this->db->prepare('
			SELECT * FROM `lectiontime`
			WHERE `id` = ?
			LIMIT 1
		');

		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if (!$result->num_rows) {
			throw new UnexpectedValueException('No lection time with this ID found');
		} else {
			$data = $result->fetch_assoc();
			return LectionTime::fillFromRowData($data);
		}
	}
}