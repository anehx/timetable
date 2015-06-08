<?php

/**
 * This is the lesson controller
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\controller;

use inc\datamapper\LessonMapper;
use inc\datamapper\CourseMapper;
use inc\datamapper\LessonTimeMapper;
use inc\model\Lesson;

class LessonController extends \lib\Controller {
	/**
	 * The default template
	 *
	 * @var string
	 */
	protected $tpl = 'lesson/courseList.tpl';

	/**
	 * The page title
	 *
	 * @var string
	 */
	protected $title = 'Lessons';


	/**
	 * Handles all requests on this page
	 *
	 * @return void
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
	 *
	 * @return void
	 */
	private function handleDefault() {
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCoursesByUser($_SESSION['userID']));
	}

	/**
	 * Displays a list of lessons for a given course
	 *
	 * @return void
	 */
	private function handleList() {
		$this->tpl = 'lesson/list.tpl';
		
		if (isset($_GET['courseID'])) {
			try {
				$course = CourseMapper::getInstance()->getCourseByID($_GET['courseID']);
				$this->requireCourseOwnage($course);
			}
			catch (\UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
				$course = null;
			}
		}
		else {
			$this->addErrorMessage('No course id given');
			$course = null;
		}

		$this->title = 'Lessons for ' . $course->name;
		$this->smarty->assign('course', $course);
		$this->smarty->assign('lessons', $course ? $course->getLessons() : null);
	}

	/**
	 * Displays an edit page and handles its POST requests
	 *
	 * @return void
	 */
	private function handleEdit() {
		$this->tpl = 'lesson/edit.tpl';
		$this->title = 'Edit lesson';
		$lesson = null;
		$course = null;
		
		if (isset($_GET['id'])) {
			try {
				$lesson = LessonMapper::getInstance()->getLessonByID($_GET['id']);
				$course = $lesson->getCourse();
			}
			catch (\UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
			}
		}
		else {
			if (isset($_GET['courseID'])) {
				try {
					$course = CourseMapper::getInstance()->getCourseByID($_GET['courseID']);
					$lesson = new Lesson();
				}
				catch (\UnexpectedValueException $e) {
					$this->addErrorMessage($e->getMessage());
				}
			}
			else {
				$this->addErrorMessage('No course id given');
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
				foreach ($validator->errors as $e) {
					$this->addErrorMessage($e);
				}
			}			
		}

		$this->smarty->assign('lessonTimes', LessonTimeMapper::getInstance()->getLessonTimes());
		$this->smarty->assign('weekdays', Lesson::$weekday_map);
		$this->smarty->assign('course', $course);
		$this->smarty->assign('lesson', $lesson);
	}

	/**
	 * Handles all delete requests
	 *
	 * @return void
	 */
	private function handleDelete() {
		if (isset($_GET['id'])) {
			try {
				$lesson = LessonMapper::getInstance()->getLessonByID($_GET['id']);
				$course = $lesson->getCourse();
				$this->requireCourseOwnage($course);
				$lesson->delete();
			}
			catch (\UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
			}
		}

		header(sprintf('Location: /?page=lesson&action=list&courseID=%d', $course->id));
	}
}
