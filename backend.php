<?php
// see index.php to get more
// change the following paths if necessary

$yii=dirname(__FILE__).'/framework/yii.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', (strpos($_SERVER['HTTP_HOST'], 'local') !== false));
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

$config=require_once(dirname(__FILE__).'/protected/backend/config/main.php');

Yii::createWebApplication($config)->run();