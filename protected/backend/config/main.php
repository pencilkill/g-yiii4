<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

$backend=dirname(dirname(__FILE__));
$frontend=dirname($backend);
Yii::setPathOfAlias('backend', $backend);

// RBAC rights
Yii::setPathOfAlias('rights', Yii::getPathOfAlias('frontend.modules.rights'));

// This is the backend main Web application configuration.
$frontCfg = require_once($frontend.'/config/main.php');

// This is the backend main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$backCfg = array(
	'basePath'=>$frontend,

	'theme'=>'_ozman',

	'name'=>$frontCfg['name'].' - 網站管理',

	'language'=>'zh_tw',

	/**
	 * uncomment the following when system maintenance
	 * change the controller if you like
	 */
	/*
	'catchAllRequest'=>array('site/maintenance'),
	*/

	'controllerPath' => $backend.'/controllers',
    'viewPath' => $backend.'/views',
    'runtimePath' => $backend.'/runtime',

	// preloading 'log' component
	//'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'backend.models.*',
		'backend.components.*',
		'backend.behaviors.*',
		'frontend.modules.rights.*',
		'frontend.modules.rights.components.*',
	),


	'defaultController'=>'site/index',

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			//uncomment the following to disable giix
			'generatorPaths' => array(
            	'ext.giix-core', // giix generators
        	),
			'password'=>'3661000',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.*','::1'),
		),
		*/


		'rights'=>array(
		   'superuserName'=>'admin',
		   'authenticatedName'=>'Authenticated',
		   'userClass'=>'Admin',
		   'userIdColumn'=>'admin_id',
		   'userNameColumn'=>'username',
		   'enableBizRule'=>false,
		   'enableBizRuleData'=>false,
		   'displayDescription'=>true,
		   'flashSuccessKey'=>'RightsSuccess',
		   'flashErrorKey'=>'RightsError',
		   'install'=>false,
		   'baseUrl'=>'/rights',
		   'layout'=>'rights.views.layouts.main',
		   'appLayout'=>'backend.views.layouts.main',
		   'cssFile'=>'/_ozman/stylesheet/rights.css',
		   'debug'=>false,
		),

	),

	'behaviors' => array(
    	'app' => 'backend.behaviors.BeforeRequestBehavior',
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'RWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'stateKeyPrefix'=>'back',
			'loginUrl'=>array('site/login'),
			'returnUrl'=>array('site/index'),
		),

		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
			'defaultRoles'=>array('Guest'),
			//DB table, maybe auth will be added frontend sometime
			'assignmentTable' => 'authassignment',
		    'itemTable' => 'authitem',
		    'itemChildTable' => 'authitemchild',
		    'rightsTable' => 'rights',
		),

        'messages'=>array(
			'basePath'=>$backend.'/messages',
		),

		// uncomment the following to enable URLs in path-format
        /*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database

		//'db'=>require_once(dirname(__FILE__).'/cfg.db.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
				/*
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace',
					'categories'=>'system.db.CDbCommand',
				),
				*/

			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);

//return main confinguration from both frontend and backend ,override frontend configuration which existed
return CMap::mergeArray($frontCfg, $backCfg);