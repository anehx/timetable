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
		$courseID = isset($_GET['courseID']) ? (int)$_GET['courseID'] : null;

		if (!$courseID) {
			$errors[] = 'No course id given';
			$lessons = null;
		}
		else {
			$lessons = LessonMapper::getInstance()->getLessonsByCourse($courseID);
		}

		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('courseID', $courseID);
		$this->smarty->assign('lessons', $lessons);
	}

}