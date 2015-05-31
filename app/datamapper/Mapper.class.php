<?php

/**
 * This is the basic class of all mapper
 *
 * @package    timetable
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
**/

namespace datamapper;

use mysqli;
use util\DbManager;

class Mapper {
	/**
	 * Mapper singleton
	 *
	 * This needs to be in every children of this
	 * class too, to use getInstance()
	**/
	protected static $singleton = null;

	/**
	 * The DB connection
	**/
	protected $db = null;

	/**
	 * Returns an instance of the called mapper
	 *
	 * @return static
	**/
	public static function getInstance() {
		if (static::$singleton === null) {
			static::$singleton = new static();
		}

		return static::$singleton;
	}

	/**
	 * The class constructor
	**/
	public function __construct() {
		$this->db = DbManager::getConnection();
	}
}
