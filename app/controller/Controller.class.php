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

use util\ConfManager;
use Smarty;

class Controller {
	/**
	 * The default template
	 *
	 * @var string
	 */
	protected $tpl = 'index.tpl';

	/**
	 * Global smarty object
	 *
	 * @var Smarty
	 */
	protected $smarty = null;

	/**
	 * Page requires superuser permission
	 * Displays access denied page if not allowed
	 *
	 * @return void
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
	 * @return void
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
	 *
	 * @return void
	 */
	protected function requireLogin() {
		if (!isset($_SESSION['username'])) {
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}

	/**
	 * The class constructor
	 *
	 * @return void
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
	 *
	 * @return void
	 */
	public function handle() {
		$this->smarty->display($this->tpl);
	}
}
