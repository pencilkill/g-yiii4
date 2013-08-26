<?php
/**
 * ***********************************************************************
 * ***********************************************************************
 * ** About This Config **
 * ** The backend configuration will override this configuration using CMap::mergeArray()
 * ** That is mean, there is something we should not be setting in this config like CLinkPager
 * ** unless someone can override all of this config using backend config to make a real backend config
 * ** but we don't need to override in that case, why not just make two config that are separate from each other?
 *
 * ** so parts of config are dynamic setted
 * ** see compenents/controller and its behavior to get more about those dynamic settings please
 * **
 * ***********************************************************************
 * ***********************************************************************
 */


// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

$frontend=dirname(dirname(__FILE__));
Yii::setPathOfAlias('frontend', $frontend);

//Yii::setPathOfAlias('weburl', strtr('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'], array(strtr($_SERVER['SCRIPT_FILENAME'], array(Yii::getPathOfAlias('webroot')=>''))=>'')));

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>$frontend,

	'language'=>'zh_tw',

	'name'=>'元伸科技',

	// preloading 'log' component
	/*
	'preload'=>array(
		'log',
	),
	*/

	// autoloading model and component classes
	'import'=>array(
		//required for module giix
		'ext.giix-components.*',
		//helpers
		'frontend.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

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


	),

	'behaviors' => array(
    	'app' => 'frontend.behaviors.BeforeRequestBehavior',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			//'allowAutoLogin'=>true,
			'stateKeyPrefix'=>'front',
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
		'db'=>require_once(dirname(__FILE__).'/DB.php'),

		'config' => array(
         	'class' => 'ext.EConfig',
			'strictMode' => false,
		),

		'image'=>array(
            'class'=>'ext.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'assets'),
        ),
		 // assets
		 'assetManager' => array(
		 	'forceCopy' => (boolean)YII_DEBUG,
		 ),
		 // mail
		 'mail'=>array(
            'class'=>'frontend.extensions.mail.Mail',
        ),
        // EShoppingCart
        'shoppingCart' => array(
		        'class' => 'ext.eshoppingcart.EShoppingCart',
		),
		// example to config widget
		'widgetFactory' => array(
			'widgets' => array(
				'CLinkPager' => array(
					// Don't place you configuration for CLinkPager at here
					// CLinkPager configuration is dynamic, see app behavior
				),
			),
		),
        // error
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		// log
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
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);