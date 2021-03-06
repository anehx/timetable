<?php

/**
 * This is a helper class to parse the config
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace util;

class ConfManager {
	/**
	 * The path of the config ini file
	 *
	 * @var string
	 */
	const CONFIG_PATH = '/../config/config.ini';

	/**
	 * Returns the config as an array
	 *
	 * @return array
	 */
	public static function getConf() {
		return parse_ini_file(__DIR__ . self::CONFIG_PATH);
	}
}