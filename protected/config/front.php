<?php
/**
 * this configuration is frontend only
 * see mian configuration to get more informaiton
 */
return array(
	'import'=>array(
		'frontend.models.*',
		'frontend.components.*',
	),
	// application components
	'components'=>array(
        // EShoppingCart
        'shoppingCart' => array(
		        'class' => 'ext.eshoppingcart.EShoppingCart',
		),
		// example to config widget
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
					  'nextPageLabel' => NULL,
					  'prevPageLabel' => NULL,
					  'firstPageLabel' => NULL,
					  'lastPageLabel' => NULL,
					  'header' => NULL,
					  'footer' => '',
					  'cssFile' => NULL,
					  'htmlOptions' => array (
					  ),
				),
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
		'showLanguageVar' => false,	// boolean
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
);