<?php

session_start();

use inc\controller;

$page = isset($_GET['page']) ? $_GET['page'] : null;

switch ($page) {
	case 'user':
		$controller = new controller\UserController();
		break;
	case 'course':
		$controller = new controller\CourseController();
		break;
	case 'lessonTime':
		$controller = new controller\LessonTimeController();
		break;
	case 'lesson':
		$controller = new controller\LessonController();
		break;
	default:
		$controller = new controller\DefaultController();
		break;
}

$controller->handle();