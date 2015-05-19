<?php

session_start();

$page = isset($_GET['page']) ? $_GET['page'] : null;

switch ($page) {
	case 'user':
		require_once('/controller/UserController.class.php');
		$controller = new UserController();
		break;
	case 'course':
		require_once('/controller/CourseController.class.php');
		$controller = new CourseController();
		break;
	case 'lessonTime':
		require_once('/controller/LessonTimeController.class.php');
		$controller = new LessonTimeController();
		break;
	case 'lesson':
		require_once('/controller/LessonController.class.php');
		$controller = new LessonController();
		break;
	default:
		require_once('/controller/BaseController.class.php');
		$controller = new BaseController();
		break;
}

$controller->handle();