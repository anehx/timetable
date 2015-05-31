<?php

namespace controller;

use controller\Controller;
use datamapper\CourseMapper;
use datamapper\UserMapper;
use datamapper\LessonTimeMapper;
use datamapper\LessonMapper;
use model\Lesson;

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
			$this->smarty->assign('weekdays', Lesson::WEEKDAY_MAP);
			$this->smarty->assign('lessons', LessonMapper::getInstance()->getLessonsByCourse($_GET['id']));
		}
	}
}
