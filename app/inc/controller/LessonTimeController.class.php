<?php

/**
 * This is the lesson time controller
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\controller;

use inc\datamapper\LessonTimeMapper;
use inc\model\LessonTime;

class LessonTimeController extends \lib\Controller {
	/**
	 * The default template
	 *
	 * @var string
	 */
	protected $tpl = 'lessontime/list.tpl';

	/**
	 * The page title
	 *
	 * @var string
	 */
	protected $title = 'Lesson times';

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
	 * Displays a list of all lesson times
	 *
	 * @return void
	 */
	private function handleDefault() {
		$this->requireSuperuser();
		$this->smarty->assign('lessonTimes', LessonTimeMapper::getInstance()->getLessonTimes());
	}

	/**
	 * Displays an edit page and handles its POST requests
	 *
	 * @return void
	 */
	private function handleEdit() {
		$this->requireSuperuser();
		$this->tpl = 'lessontime/edit.tpl';
		$this->title = 'Edit lesson time';

		if (isset($_GET['id'])) {
			try {
				$lessonTime = LessonTimeMapper::getInstance()->getLessonTimeByID($_GET['id']);
			}
			catch (\UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
				$lessonTime = null;
			}
		}
		else {
			$lessonTime = new LessonTime();
		}

		if ($_POST) {
			$lessonTime->startTime = new \DateTime(date('H:i:s', strtotime($_POST['startTime'])));
			$lessonTime->endTime = new \DateTime(date('H:i:s', strtotime($_POST['endTime'])));

			$validator = $lessonTime->validate();

			if ($validator->isValid) {
				$lessonTime->save();
				header('Location: /?page=lessonTime');
			}
			else {
				foreach ($validator->errors as $e) {
					$this->addErrorMessage($e);
				}
			}
		}

		$this->smarty->assign('lessonTime', $lessonTime);
	}

	/**
	 * Handles all delete requests
	 *
	 * @return void
	 */
	private function handleDelete() {
		$this->requireSuperuser();

		if (isset($_GET['id'])) {
			try {
				$lessonTime = LessonTimeMapper::getInstance()->getLessonTimeByID($_GET['id']);
				$lessonTime->delete();
			}
			catch (\UnexpectedValueException $e) {
				$this->addErrorMessage($e->getMessage());
			}
		}

		header('Location: /?page=lessonTime');
	}
}
