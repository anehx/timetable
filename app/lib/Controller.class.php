<?php

/**
 * This is the basic controller
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace lib;

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
	 * The default title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * Global smarty object
	 *
	 * @var Smarty
	 */
	protected $smarty = null;

	/**
	 * Messages
	 *
	 * @var array
	 */
	private $messages = null;

	/**
	 * Page requires superuser permission
	 * Displays access denied page if not allowed
	 *
	 * @return void
	 */
	protected function requireSuperuser() {
		if (!isset($_SESSION['isSuperuser']) || !$_SESSION['isSuperuser']) {
			$this->smarty->assign('messages', $this->messages);
			$this->smarty->assign('title', 'Access denied');
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}

	/**
	 * Adds an error message
	 *
	 * @param string $text
	 * @return void
	 */
	protected function addErrorMessage($text) {
		$this->messages[] = array(
			'text' => $text,
			'type' => 'danger'
		);
	}

	/**
	 * Adds a notify message
	 *
	 * @param string $text
	 * @return void
	 */
	protected function addNotifyMessage($text) {
		$this->messages[] = array(
			'text' => $text,
			'type' => 'info'
		);
	}

	/**
	 * Adds a success message
	 *
	 * @param string $text
	 * @return void
	 */
	protected function addSuccessMessage($text) {
		$this->messages[] = array(
			'text' => $text,
			'type' => 'success'
		);
	}

	/**
	 * Page requires ownage of given course
	 * Displays access denied page if not allowed
	 *
	 * @param \inc\model\Course $course
	 * @return void
	 */
	protected function requireCourseOwnage(\inc\model\Course $course) {
		if ($_SESSION['userID'] !== $course->userID) {
			$this->smarty->assign('messages', $this->messages);
			$this->smarty->assign('title', 'Access denied');
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
			$this->smarty->assign('messages', $this->messages);
			$this->smarty->assign('title', 'Access denied');
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
		$this->smarty->assign('messages', $this->messages);
		$this->smarty->assign('title', $this->title);
		$this->smarty->display($this->tpl);
	}
}