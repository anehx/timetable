<?php

require_once('controller/Controller.class.php');
require_once('datamapper/CourseMapper.class.php');
require_once('datamapper/UserMapper.class.php');

class BaseController extends Controller {
	/*
	 The default template
	*/
	protected $tpl = 'home.tpl';

	public function handle() {
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCourses());

		parent::handle();
	}

}