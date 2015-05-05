<?php

require('../lib/smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('../templates');
$smarty->setCompileDir('../tmp');
$smarty->setCacheDir('../cache');
$smarty->setConfigDir('../configs');