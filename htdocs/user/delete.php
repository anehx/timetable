<?php

session_start();

require_once(__DIR__ . '/../../inc/datamapper/UserMapper.class.php');
require_once(__DIR__ . '/../../inc/smarty.php');


if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser']) {
	if (isset($_GET['id'])) {
		$user = UserMapper::getInstance()->getUserByID($_GET['id']);

		if ($user->username != $_SESSION['username']) {
			$user->delete();
		}
	}
	header('Location: /user/');
}
else {
	$smarty->display('access_denied.tpl');
}