<?php

session_start();

require_once(__DIR__ . '/../../inc/smarty.php');
require_once(__DIR__ . '/../../inc/datamapper/UserMapper.class.php');
require_once(__DIR__ . '/../../inc/model/User.class.php');

if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser']) {
	$errors = array();

	if ($_POST) {
		$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;

		if ($user_id) {
			$user = UserMapper::getInstance()->getUserByID($user_id);
		}
		else {
			$user = new User();
			$user->username = $_POST['username'];
		}

		if ($_POST['new_password'] !== '' && $_POST['new_password'] == $_POST['confirm_password']) {
			$user->generateSalt();
			$user->password_hash = crypt($_POST['new_password'], $user->password_salt);
		}

		$user->first_name = $_POST['first_name'];
		$user->last_name  = $_POST['last_name'];

		$user->save();
		header(sprintf('Location: /user/edit.php?id=%d', $user->id));
	}

	if (isset($_GET['id'])) {
		$user_id = $_GET['id'];
		try {
			$user = UserMapper::getInstance()->getUserByID($user_id);
		}
		catch (UnexpectedValueException $e) {
			$errors[] = 'No user with this id available!';
			$user = null;
		}
	}
	else {
		$user = new User();
	}
	$smarty->assign('user', $user);
	$smarty->assign('errors', $errors);
	$smarty->display('user/edit.tpl');
}
else {
	$smarty->display('access_denied.tpl');
}