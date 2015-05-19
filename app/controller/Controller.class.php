<?php

class Controller {
	/*
	 The default template
	*/
	protected $tpl = 'index.tpl';

	/*
	 Global smarty object
	*/
	protected $smarty = null;

	/*
	 Page requires superuser permission
	 Displays access denied page if not allowed
	*/
	protected function requireSuperuser() {
		if (!isset($_SESSION['isSuperuser']) || !$_SESSION['isSuperuser']) {
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}

	/*
	 Page requires ownage of given course
	 Displays access denied page if not allowed

	 @param Course $course
	*/
	protected function requireCourseOwnage($course) {
		if ($_SESSION['userID'] !== $course->userID) {
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}

	/*
	 Page requires logged in user
	 Displays access denied page if not allowed
	*/
	protected function requireLogin() {
		if (!isset($_SESSION['username'])) {
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}

	/*
	 The class constructor
	*/
	public function __construct() {
		$this->smarty = $GLOBALS['smarty'];
	}

	/*
	 Handles all requests on this page
	*/
	public function handle() {
		$this->smarty->display($this->tpl);
	}
}