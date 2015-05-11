<?php

require_once('controller/Controller.class.php');

class BaseController extends Controller {
	protected $tpl = 'home.tpl';

	public function handle() {
		$this->smarty->display($this->tpl);
	}
}