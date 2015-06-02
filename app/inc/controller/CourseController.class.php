<?php

/**
 * This is the course controller
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\controller;

use inc\model\Course;
use inc\datamapper\CourseMapper;
use inc\datamapper\UserMapper;

class CourseController extends \lib\Controller {
	/**
	 * The default template
	 *
	 * @var string
	 */
	protected $tpl = 'course/list.tpl';

	/**
	 * Handles all requests on this page
	 *
	 * @return void
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
	 *
	 * @return void
	 */
	private function handleDefault() {
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCourses());
	}

	/**
	 * Displays an edit page and handles its POST requests
	 *
	 * @return void
	 */
	private function handleEdit() {
		$this->requireSuperuser();
		$this->tpl = 'course/edit.tpl';

		if (isset($_GET['id'])) {
			try {
				$course = CourseMapper::getInstance()->getCourseByID($_GET['id']);
			}
			catch (\UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
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
				foreach ($validator->errors as $e) {
					$this->addErrorMessage($e);
				}
			}
		}
		
		$this->smarty->assign('users', UserMapper::getInstance()->getUsers(true));
		$this->smarty->assign('course', $course);
	}

	/**
	 * Handles the delete requests
	 *
	 * @return void
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
