<?php

require_once('/controller/Controller.class.php');
require_once('/datamapper/LessonTimeMapper.class.php');

class LessonTimeController extends Controller {
	/*
	 The default template
	*/
	protected $tpl = 'lessontime/list.tpl';

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

		parent::handle();
	}

	/*
	 The default page
	*/
	private function handleDefault() {
		$this->requireSuperuser();
		$this->smarty->assign('lessonTimes', LessonTimeMapper::getInstance()->getLessonTimes());
	}

	/*
	 The edit page
	*/
	private function handleEdit() {
		$this->requireSuperuser();
		$this->tpl = 'lessontime/edit.tpl';
		$errors = array();

		if (isset($_GET['id'])) {
			try {
				$lessonTime = LessonTimeMapper::getInstance()->getLessonTimeByID($_GET['id']);
			}
			catch (UnexpectedValueException $e) {
				$errors[] = $e->getMessage();
				$lessonTime = null;
			}
		}
		else {
			$lessonTime = new LessonTime();
		}

		if ($_POST) {
			$lessonTime->startTime = new DateTime(date('H:i:s', strtotime($_POST['startTime'])));
			$lessonTime->endTime = new DateTime(date('H:i:s', strtotime($_POST['endTime'])));

			$validator = $lessonTime->validate();

			if ($validator->isValid) {
				$lessonTime->save();
				header('Location: /?page=lessonTime');
			}
			else {
				$errors = array_merge($errors, $validator->errors);
			}
		}

		$this->smarty->assign('errors', $errors);
		$this->smarty->assign('lessonTime', $lessonTime);
	}

	/*
	 The delete page
	*/
	private function handleDelete() {
		$this->requireSuperuser();

		if (isset($_GET['id'])) {
			$lessonTime = LessonTimeMapper::getInstance()->getLessonTimeByID($_GET['id']);
			$lessonTime->delete();
		}

		header('Location: /?page=lessonTime');
	}
}