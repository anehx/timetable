<?php

/**
 * This is a helper class for a db connection
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace util;

class DbManager {
	/**
	 * The static db connection
	 *
	 * @var \mysqli
	 */
	private static $db = null;

	/**
	 * Returns a db connection
	 *
	 * @return \mysqli
	 */
	public static function getConnection() {
		if (self::$db === null) {
			$conf   = ConfManager::getConf();
			$mysqli = new \mysqli(
				$conf['DB_HOST'],
				$conf['DB_USER'],
				$conf['DB_PASS'],
				$conf['DB_NAME']
			);

			if ($mysqli->connect_error) {
				die('Connection failed: ' . $mysqli->connect_error);
			}

			$mysqli->set_charset('utf-8');

			self::$db = $mysqli;
		}

		return self::$db;
	}
}
