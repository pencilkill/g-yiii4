<?php
/**
 * this configuration is frontend only
 * see mian configuration to get more informaiton
 */
$main = require(__DIR__ . '/main.php');

return CMap::mergeArray($main, array(
	// preloading 'log' component
	'preload'=>array(
		//'log',
	),

	'import'=>array(
		'frontend.components.*',
		'frontend.models.*',
		'frontend.behaviors.*',
		'frontend.modules.rights.*',
		'frontend.modules.rights.components.*',
		'frontend.extensions.ELinkPager',
		'frontend.extensions.MobileDetect.MobileDetect',
		'frontend.extensions.shoppingCart.*',
	),

	'modules' => array(
		// check the component 'Controller extend RController'

		'rights'=>array(
			'superuserName'=>'Admin',
			'authenticatedName'=>'Authenticated',
			'userClass'=>'Customer',
			'userIdColumn'=>'customer_id',
			'userNameColumn'=>'username',
			'enableBizRule'=>true,
			'enableBizRuleData'=>true,
			'displayDescription'=>true,
			'flashSuccessKey'=>'RightsSuccess',
			'flashErrorKey'=>'RightsError',
			'install'=>false,
			'baseUrl'=>'/rights',
			'layout'=>'rights.views.layouts.main',
			'appLayout'=>'//layouts/main',
			// based on Yii->app()->controller->skinUrl
			'cssFile'=>'/stylesheet/rights.css',
			'debug'=>false,
		),

	),

	// application components
	'components'=>array(
		'user'=>array(
			'class' => 'WebUser',

			// enable cookie-based authentication
        	'allowAutoLogin' => true,
			'autoRenewCookie' => true,
			// Notice that the second parameter of Yii::app()->user->login($identity, $duration) can not be setted as 0 if you want to enable the authTimeout
			'authTimeout' => 60 * 24 * 365,

			'stateKeyPrefix' => 'front',
			'loginUrl' => array('/customer/login'),
			'profileUrl' => array('/customer/profile'),
			'logoutUrl' => array('/customer/logout'),
			'returnUrl' => array('/site/index'),
			// ajax session timeout
			'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
		),

		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
			// this is the deault role which user use to login, should be the lowest for backend
			'defaultRoles'=>array('Guest'),
			//DB table, maybe auth will be added frontend sometime
			'assignmentTable' => 'customer_authassignment',
			'itemTable' => 'customer_authitem',
			'itemChildTable' => 'customer_authitemchild',
			'rightsTable' => 'customer_rights',
		),

		'shoppingCart' => array(
			'class' => 'frontend.extensions.shoppingCart.EShoppingCart',
		),

		'coreMessages'=>array(
			/**
			 *  Set basePath as null, it will customize coreMessages
			 *  Notice that app will not translate from coreMessage of Yii::app()->language,
			 *  it will translate from coreMessage of Yii::app()->sourceLanguage if there is no onMissingTranslation event
			 *
			 *  uncomment the following to use framework coreMessages
			 */
            //'basePath'=>null,
        ),
		/*
        'urlManager'=>array(
            'urlFormat' => 'path',
        	'showScriptName' => false,
        	'urlSuffix' => '.html',
        ),
        */

		// example to config widget
		'widgetFactory' => array(
			'widgets' => array(
				'CBreadcrumbs' => array (
					  'tagName' => 'div',
					  'htmlOptions' => array (
					    'class' => 'breadcrumbs',
					  ),
					  'encodeLabel' => true,
					  'homeLink' => NULL,
					  'links' => array (
					  ),
					  'activeLinkTemplate' => '<a href="{url}">{label}</a>',
					  'inactiveLinkTemplate' => '<span>{label}</span>',
					  'separator' => ' &raquo; ',
				),
				// frontend.extensions.ELinkPager about configuration
				'ELinkPager' => array(
					'firstPageCssClass' => 'first',
					'lastPageCssClass' => 'last',
					'previousPageCssClass' => 'prev',
					'nextPageCssClass' => 'next',
					'internalPageCssClass' => 'page',
					'hiddenPageCssClass' => 'hidden',
					'selectedPageCssClass' => 'selected',
					'maxButtonCount' => 10,
					'nextPageLabel' => 'Next',
					'prevPageLabel' => 'Prev',
					'firstPageLabel' => false,
					'lastPageLabel' => false,
					'header' => '',
					'footer' => '',
					'cssFile' => '',
					'container' => 'div',
					'htmlOptions' => array('class' => 'pager'),
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		/**
		 *  Current language id, this is a required var
		 *  internal setting, cause the DB language relation foreign key is langauge_id
		 *	@see app behavior
		 */
		'languageId' => null,
		/**
		 * whether to show customer prefered lanuage parameter
		 * set it to boolean false to hidden language url key
		 * @var Mixed
		 * @see app behavior, components/controller
		 */
		'showLanguageVar' => true,	// boolean
		/**
		 * customer prefered lanuage parameter , this is a var like routeVar
		 * set it to boolean false to hidden language url key
		 * @var Mixed
		 * @see app behavior, components/controller
		 */
		'languageVar' => 'language',	// string
		/**
		 *  @var String, customer prefered lanuage cookie parameter
		 *	@see app behavior
		 */
		'languageCookieVar' => '__lanuage',
		/**
		 *  @var Array, all the enabled language
		 *	@see app behavior
		 */
		'languages' => array(),
	),
));