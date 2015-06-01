<?php

/**
 * This is the course controller
 *
 * @package    timetable
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace controller;

use model\Course;
use datamapper\CourseMapper;
use datamapper\UserMapper;

class CourseController extends Controller {
	/**
	 * The default template
	 */
	protected $tpl = 'course/list.tpl';

	/**
	 * Handles all requests on this page
	 */
	public function handle() {
		$this->requireSuperuser();

		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
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
	 * Displays a list of all courses
	 */
	private function handleDefault() {
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCourses());
	}

	/**
	 * Displays an edit page and handles its POST requests
	 */
	private function handleEdit() {
		$this->requireSuperuser();
		$this->tpl = 'course/edit.tpl';
		$errors = [];

		if (isset($_GET['id'])) {
			try {
				$course = CourseMapper::getInstance()->getCourseByID($_GET['id']);
			}
			catch (\UnexpectedValueException $e) {
				$errors[] = $e->getMessage();
				$course = null;
			}
		}
		else {
			$course = new Course();
		}

		if ($_POST) {
			$course->name = trim($_POST['name']);
			$course->userID = (int)$_POST['userID'] ? (int)$_POST['userID'] : null;
			$validator = $course->validate();

			if ($validator->isValid) {
				$course->save();
				header('Location: /?page=course');
			}
			else {
				$errors = array_merge($errors, $validator->errors);
			}
		}
		
		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('users', UserMapper::getInstance()->getUsers(true));
		$this->smarty->assign('course', $course);
	}

	/**
	 * Handles the delete requests
	 */
	private function handleDelete() {
		$this->requireSuperuser();

		if (isset($_GET['id'])) {
			$course = CourseMapper::getInstance()->getCourseByID($_GET['id']);
			$course->delete();
		}

		header('Location: /?page=course');
	}
}
