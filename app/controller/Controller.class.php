<?php

/**
 * This is the basic controller
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace controller;

use Smarty;
use util\ConfManager;

class Controller {
	/**
	 * The default template
	 */
	protected $tpl = 'index.tpl';

	/**
	 * Global smarty object
	 */
	protected $smarty = null;

	/**
	 * Page requires superuser permission
	 * Displays access denied page if not allowed
	 */
	protected function requireSuperuser() {
		if (!isset($_SESSION['isSuperuser']) || !$_SESSION['isSuperuser']) {
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}

	/**
	 * Page requires ownage of given course
	 * Displays access denied page if not allowed
	 *
	 * @param \model\Course $course
	 */
	protected function requireCourseOwnage(\model\Course $course) {
		if ($_SESSION['userID'] !== $course->userID) {
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}

	/**
	 * Page requires logged in user
	 * Displays access denied page if not allowed
	 */
	protected function requireLogin() {
		if (!isset($_SESSION['username'])) {
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}

	/**
	 * The class constructor
	 */
	public function __construct() {
		$conf = ConfManager::getConf();
		$this->smarty = new Smarty;
		$this->smarty->setTemplateDir($conf['PROJECT_PATH'] . '/app/templates');
		$this->smarty->setCompileDir($conf['PROJECT_PATH'] . '/tmp');
		$this->smarty->setCacheDir($conf['PROJECT_PATH'] . '/cache');
		$this->smarty->setConfigDir($conf['PROJECT_PATH'] . '/configs');
	}

	/**
	 * Handles all requests on this page
	 */
	public function handle() {
		$this->smarty->display($this->tpl);
	}
}
