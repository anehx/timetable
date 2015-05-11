<?php

session_start();

require_once(__DIR__ . '/../inc/smarty.php');
require_once(__DIR__ . '/../inc/db.php');
require_once(__DIR__ . '/../inc/datamapper/UserMapper.class.php');

$errors = array();

if (isset($_SESSION['username'])) {
	header('Location: /');
}

if ($_POST) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	try {
		$user = UserMapper::getInstance()->getUserByUsername($username);
		if (password_verify($password, $user->password)) {
			$user->login();
			header('Location: /');
		}
		else {
			$errors[] = 'Wrong password!';
		}
	}
	catch (Exception $e) {
		$errors[] = 'No user with this username found!';
	}
}

$smarty->assign('errors', $errors);
$smarty->display('login.tpl');