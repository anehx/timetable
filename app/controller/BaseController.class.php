<?php

require_once('controller/Controller.class.php');
require_once('datamapper/CourseMapper.class.php');
require_once('datamapper/UserMapper.class.php');
require_once('datamapper/LessonTimeMapper.class.php');

class BaseController extends Controller {
	/*
	 The default template
	*/
	protected $tpl = 'home.tpl';

	/*
	 Handles all requests on this page
	*/
	public function handle() {

		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case 'overview':
					$this->handleOverview();
					break;
				default:
					$this->handleDefault();
					break;
			}
		}
		else {
			$this->handleDefault();
		}

		parent::handle();
	}

	/*
	 The default page
	*/
	private function handleDefault() {
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCourses());
	}

	/*
	 The lessons
	*/
	private function handleOverview() {
		$this->tpl = 'list.tpl';

		if (isset($_GET['id'])) {
			$course = CourseMapper::getInstance()->getCourseByID($_GET['id']);
			$this->smarty->assign('course', $course);
			$this->smarty->assign('lessonTimes', LessonTimeMapper::getInstance()->getLessonTimes());
		}
	}
}
