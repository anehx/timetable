<?php

session_start();

require_once(__DIR__ . '/../inc/smarty.php');

$smarty->display('home.tpl');
