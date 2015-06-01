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
     */
    const CONFIG_PATH = __DIR__ . '/../config/config.ini';

    /**
     * Returns the config as an array
     *
     * @return array
     */
    public static function getConf() {
        return parse_ini_file(self::CONFIG_PATH);
    }
}
