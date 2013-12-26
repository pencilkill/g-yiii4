<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the backend main Web application configuration.


$backend=dirname(dirname(__FILE__));
$frontend=dirname($backend);

// This step should be done firstly
// cause require one file will run the script which may be define some variable besides configuration
$frontCfg = require_once($frontend.'/config/main.php');
// override safety now

// Notice that backend alias can be defined here only
// it is used to distinguish frontend
// for example, GiixCrudGenerator->getMethod()
Yii::setPathOfAlias('backend', $backend);

// RBAC rights
Yii::setPathOfAlias('rights', Yii::getPathOfAlias('frontend.modules.rights'));

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
	'defaultController'=>'site',

	// preloading 'log' component
	//'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'backend.models.*',
		'backend.components.*',
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
		   'superuserName'=>'Admin',
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
			'autoRenewCookie'=>true,
			// Notice that the second parameter of Yii::app()->user->login($identity, $duration) can not be setted as 0 if you want to enable the authTimeout
			'authTimeout'=>60 * 20,

			'stateKeyPrefix'=>'back',
			'loginUrl'=>array('site/login'),
			'returnUrl'=>array('site/index'),
			// ajax session timeout
			'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
		),

		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
			// this is the deault role which user use to login, should be the lowest for backend
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

		'widgetFactory' => array(
			'widgets' => array(
				'CLinkPager' => array (
					  'firstPageCssClass' => 'first',
					  'lastPageCssClass' => 'last',
					  'previousPageCssClass' => 'previous',
					  'nextPageCssClass' => 'next',
					  'internalPageCssClass' => 'page',
					  'hiddenPageCssClass' => 'hidden',
					  'selectedPageCssClass' => 'selected',
					  'maxButtonCount' => 10,
					  'nextPageLabel' => '>',
					  'prevPageLabel' => '<',
					  'firstPageLabel' => '<<',
					  'lastPageLabel' => '>>',
					  'header' => '',
					  'footer' => '',
					  'cssFile' => NULL,
					  'htmlOptions' => array (
					  ),
				),
				'CGridView' => array(
					'ajaxUpdate' => false,
				),
			),
		),

		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<language:\w+>/<controller:\w+>/<action:\w+>'=>'<language>/<controller>/<action>',
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
					'levels'=>'error,warning,profile,info,trace',
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
