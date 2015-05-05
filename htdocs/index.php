<?php

session_start();

require_once('../inc/smarty.php');

var_export($_SESSION, true);

$smarty->display('home.tpl');