<?php

session_start();

require_once(__DIR__ . '/../../inc/datamapper/UserMapper.class.php');
require_once(__DIR__ . '/../../inc/smarty.php');

if (isset($_SESSION['is_superuser']) && $_SESSION['is_superuser']) {
	$users = UserMapper::getInstance()->getUsers();
	$smarty->assign('users', $users);
	$smarty->display('user/list.tpl');
}
else {
	$smarty->display('access_denied.tpl');
}