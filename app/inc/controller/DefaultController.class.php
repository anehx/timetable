<?php

/**
 * This is the default controller
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\controller;

use inc\datamapper\CourseMapper;
use inc\datamapper\UserMapper;
use inc\datamapper\LessonTimeMapper;
use inc\datamapper\LessonMapper;
use inc\model\Lesson;

class DefaultController extends \lib\Controller {
	/**
	 * The default template
	 *
	 * @var string
	 */
	protected $tpl = 'home.tpl';

	/**
	 * Handles all requests on this page
	 *
	 * @return void
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

	/**
	 * Displays the default page
	 *
	 * @return void
	 */
	private function handleDefault() {
		$this->smarty->assign('courses', CourseMapper::getInstance()->getCourses());
	}

	/**
	 * Displays a overview of all courses
	 *
	 * @return void
	 */
	private function handleOverview() {
		$this->tpl = 'timetable.tpl';

		if (isset($_GET['id'])) {
			$course = CourseMapper::getInstance()->getCourseByID($_GET['id']);
			$this->smarty->assign('course', $course);
			$this->smarty->assign('lessonTimes', LessonTimeMapper::getInstance()->getLessonTimes());
			$this->smarty->assign('weekdays', Lesson::WEEKDAY_MAP);
			$this->smarty->assign('lessons', LessonMapper::getInstance()->getLessonsByCourse($_GET['id']));
		}
	}
}
