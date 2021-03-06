<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
	'sourcePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR,
	'messagePath'=>dirname(__FILE__),
	'languages'=>array('zh_tw'),
	'fileTypes'=>array('php'),
	'overwrite'=>true,
	'exclude'=>array(
		'.svn',
		'.gitignore',
		'yiilite.php',
		'yiit.php',
		'/i18n/data',
		'/messages',
		'/vendors',
		'/web/js',
		// exclude addon
		'/runtime',
		'/backend',
		'/extensions',
		'/helpers',
		'/modules/rights',
	),
	'translator' => 'Yii::t',	// preg_match_all(regex)
	'removeOld' => true,
	// exclude core category
	'excludeCore' => array(
		'yii',
		'zii',
		'giix',
	),
);
