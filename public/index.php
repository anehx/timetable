<?php

session_start();

$page = isset($_GET['page']) ? $_GET['page'] : null;

switch ($page) {
	case 'user':
		require_once('controller/UserController.class.php');
		$controller = new UserController();
		break;
	default:
		require_once('controller/BaseController.class.php');
		$controller = new BaseController();
		break;
}

$controller->handle();