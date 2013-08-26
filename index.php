<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', (strpos($_SERVER['HTTP_HOST'], 'local') !== false));
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);	// Yii accessable now

$config=CMap::mergeArray(require(dirname(__FILE__).'/protected/config/main.php'), require(dirname(__FILE__).'/protected/config/front.php'));

Yii::createWebApplication($config)->run();
