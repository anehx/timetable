<?php

require_once('controller/Controller.class.php');
require_once('datamapper/CourseMapper.class.php');
require_once('datamapper/UserMapper.class.php');

class CourseController extends Controller {
	/*
	 The default template
	*/
	protected $tpl = 'course/list.tpl';

	/*
	 Handles all requests on this page
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

		$this->smarty->display($this->tpl);
	}

	/*
	 The default page
	*/
	private function handleDefault() {
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCourses());
	}

	/*
	 The edit page
	*/
	private function handleEdit() {
		$this->requireSuperuser();
		$this->tpl = 'course/edit.tpl';
		$errors = [];

		if (isset($_GET['id'])) {
			try {
				$course = CourseMapper::getInstance()->getCourseByID($_GET['id']);
			}
			catch (UnexpectedValueException $e) {
				$errors[] = 'No course with this id found';
				$course = null;
			}
		}
		else {
			$course = new Course();
		}

		if ($_POST) {
			$course->name = trim($_POST['name']);
			$course->userID = (int)$_POST['userID'];
			$course->save();
			header('Location: /?page=course');
		}
		
		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('users', UserMapper::getInstance()->getUsers(true));
		$this->smarty->assign('course', $course);
	}

	/*
	 The delete page
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