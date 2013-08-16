<?php
if(strpos(strtolower($_SERVER['HTTP_HOST']),'local')!==false){
	return array(
		'emulatePrepare' => true,
		'charset' => 'utf8',
		'tablePrefix' => '',
		'connectionString' => 'mysql:host=localhost;dbname=yii_yiii4',
		'username' => 'root',
		'password' => '123456',
	);
}elseif(strpos(strtolower($_SERVER['HTTP_HOST']),'works.tw')!==false){
	return array(
		'emulatePrepare' => true,
		'charset' => 'utf8',
		'tablePrefix' => '',
		'connectionString' => 'mysql:host=localhost;dbname=yii_yiii',
		'username' => '',
		'password' => '',
	);
}else{
	return array(
		'emulatePrepare' => true,
		'charset' => 'utf8',
		'tablePrefix' => '',
		'connectionString' => 'mysql:host=localhost;dbname=yii_yiii',
		'username' => '',
		'password' => '',
	);
}