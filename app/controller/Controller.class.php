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
	 The class constructor
	*/
	public function __construct() {
		$this->smarty = $GLOBALS['smarty'];
	}

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
}