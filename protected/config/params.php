<?php

// this contains the application parameters that can be maintained via GUI
return array(
		/**
		 *  Current language id, this is a required var
		 *  internal setting, cause the DB language relation foreign key is langauge_id
		 *	@see app behavior
		 */
		'languageId' => null,
		/**
		 * customer prefered lanuage parameter , this is a var like routeVar
		 * set it to boolean false to hidden language url key
		 * @var Mixed
		 * @see app behavior, components/controller
		 */
		'languageVar' => 'language',	// string or false
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

		// upload directory, parent folder must be webroot
		// in many cases, uploadDir will be used in different class here and there
		// therefore, it should be better setting in params rather than in application components
		'uploadDir' => 'upload',
		// cache directory
		// see uploadDir
		'cacheDir' => 'assets/cache',
);
