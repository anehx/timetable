<?php

require_once('/controller/Controller.class.php');
require_once('/datamapper/LessonMapper.class.php');
require_once('/datamapper/CourseMapper.class.php');

class LessonController extends Controller {
	/*
	 The default template
	*/
	protected $tpl = 'lesson/courseList.tpl';

	/*
	 Handles all requests on this page
	*/
	public function handle() {
		$this->requireLogin();

		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case 'list':
					$this->handleList();
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
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCoursesByUser($_SESSION['userID']));
	}

	private function handleList() {
		$this->tpl = 'lesson/list.tpl';
		$errors = [];
		
		if (isset($_GET['courseID'])) {
			try {
				$course = CourseMapper::getInstance()->getCourseByID($_GET['courseID']);
				$this->requireCourseOwnage($course);
			}
			catch (UnexpectedValueException $e) {
				$errors[] = $e->getMessage();
				$course = null;
			}
		}
		else {
			$errors[] = 'No course id given';
			$course = null;
		}

		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('course', $course);
		$this->smarty->assign('lessons', $course ? $course->getLessons() : null);
	}

}