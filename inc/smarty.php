<?php

require(__DIR__ . '/../lib/smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ . '/../templates');
$smarty->setCompileDir(__DIR__ . '/../tmp');
$smarty->setCacheDir(__DIR__ . '/../cache');
$smarty->setConfigDir(__DIR__ . '/../configs');