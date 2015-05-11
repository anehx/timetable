<?php

class Controller {
	protected $tpl = 'index.tpl';
	protected $smarty = null;

	public function __construct() {
		$this->smarty = $GLOBALS['smarty'];
	}

	protected function requireSuperuser() {
		if (!isset($_SESSION['is_superuser']) || !$_SESSION['is_superuser']) {
			$this->smarty->display('access_denied.tpl');
			exit;
		}
	}
}