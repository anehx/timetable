<?php

// Global config
define('PROJECT_PATH', __DIR__ . '/../');
set_include_path(__DIR__);
$config = parse_ini_file('config/xampp.ini');

// DB config
define('DB_HOST', $config['DB_HOST']);
define('DB_USER', $config['DB_USER']);
define('DB_PASS', $config['DB_PASS']);
define('DB_NAME', $config['DB_NAME']);

// Smarty config
require_once(PROJECT_PATH . 'lib/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir(PROJECT_PATH . 'app/templates');
$smarty->setCompileDir(PROJECT_PATH . 'tmp');
$smarty->setCacheDir(PROJECT_PATH . 'cache');
$smarty->setConfigDir(PROJECT_PATH . 'configs');
global $smarty;