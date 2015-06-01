<?php

/**
 * This is the lesson controller
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace controller;

use datamapper\LessonMapper;
use datamapper\CourseMapper;
use datamapper\LessonTimeMapper;
use model\Lesson;

class LessonController extends Controller {
	/**
	 * The default template
	 */
	protected $tpl = 'lesson/courseList.tpl';

	/**
	 * Handles all requests on this page
	 */
	public function handle() {
		$this->requireLogin();

		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case 'list':
					$this->handleList();
					break;
				case 'edit':
					$this->handleEdit();
					break;
				case 'delete':
					$this->handleDelete();
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

	/**
	 * Displays an overview of all courses of an user
	 */
	private function handleDefault() {
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCoursesByUser($_SESSION['userID']));
	}

	/**
	 * Displays a list of lessons for a given course
	 */
	private function handleList() {
		$this->tpl = 'lesson/list.tpl';
		$errors = [];
		
		if (isset($_GET['courseID'])) {
			try {
				$course = CourseMapper::getInstance()->getCourseByID($_GET['courseID']);
				$this->requireCourseOwnage($course);
			}
			catch (\UnexpectedValueException $e) {
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

	/**
	 * Displays an edit page and handles its POST requests
	 */
	private function handleEdit() {
		$this->tpl = 'lesson/edit.tpl';
		$errors = [];
		$lesson = null;
		$course = null;
		
		if (isset($_GET['id'])) {
			try {
				$lesson = LessonMapper::getInstance()->getLessonByID($_GET['id']);
				$course = $lesson->getCourse();
			}
			catch (\UnexpectedValueException $e) {
				$errors[] = $e->getMessage();
			}
		}
		else {
			if (isset($_GET['courseID'])) {
				try {
					$course = CourseMapper::getInstance()->getCourseByID($_GET['courseID']);
					$lesson = new Lesson();
				}
				catch (\UnexpectedValueException $e) {
					$errors[] = $e->getMessage();
				}
			}
			else {
				$errors[] = 'No course id given';
			}
		}

		$this->requireCourseOwnage($course);

		if ($_POST) {
			$lesson->name = trim($_POST['name']);
			$lesson->weekday = (int)$_POST['weekday'];
			$lesson->lessonTimeID = (int)$_POST['lessonTimeID'];

			if (!$lesson->id) {
				$lesson->courseID = $course->id;
			}

			$validator = $lesson->validate();

			if ($validator->isValid) {
				$lesson->save();
				header(sprintf('Location: /?page=lesson&action=list&courseID=%d', $course->id));
			}
			else {
				$errors = array_merge($errors, $validator->errors);
			}			
		}

		$this->smarty->assign('lessonTimes', LessonTimeMapper::getInstance()->getLessonTimes());
		$this->smarty->assign('weekdays', Lesson::WEEKDAY_MAP);
		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('course', $course);
		$this->smarty->assign('lesson', $lesson);
	}

	/**
	 * Handles all delete requests
	 */
	private function handleDelete() {
		if (isset($_GET['id'])) {
			$lesson = LessonMapper::getInstance()->getLessonByID($_GET['id']);
			$course = $lesson->getCourse();
		}
		$this->requireCourseOwnage($course);
		$lesson->delete();

		header(sprintf('Location: /?page=lesson&action=list&courseID=%d', $course->id));
	}
}
