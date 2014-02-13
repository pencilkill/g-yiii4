<?php
if(strpos(strtolower($_SERVER['HTTP_HOST']),'local')!==false){
	return array(
		'initSQLs'=>array('SET time_zone=\'+08:00\';'),
		'emulatePrepare' => true,
		'connectionString' => 'mysql:host=localhost;dbname=yii_yiii4',
		'username' => 'root',
		'password' => '123456',
		/*
		'connectionString' => 'sqlsrv:Server=pc-20120330mgyk\sqlexpress;Database=twheiar',
		'username' => 'sa',
		'password' => '123456',
		*/
		'charset' => 'utf8',
		'tablePrefix' => '',
		//
		'enableProfiling' => true,
     	'enableParamLogging' => true,
	);
}elseif(strpos(strtolower($_SERVER['HTTP_HOST']),'works.tw')!==false){
	return array(
		'initSQLs'=>array('SET time_zone=\'+08:00\';'),
		'emulatePrepare' => true,
		'connectionString' => 'mysql:host=localhost;dbname=yii_yiii',
		'username' => '',
		'password' => '',
		'charset' => 'utf8',
		'tablePrefix' => '',
		//
		'enableProfiling' => true,
     	'enableParamLogging' => true,
	);
}else{
	return array(
		'initSQLs'=>array('SET time_zone=\'+08:00\';'),
		'emulatePrepare' => true,
		'connectionString' => 'mysql:host=localhost;dbname=yii_yiii',
		'username' => '',
		'password' => '',
		'charset' => 'utf8',
		'tablePrefix' => '',
		//
		'enableProfiling' => true,
     	'enableParamLogging' => true,
	);
}