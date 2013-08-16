<?php

// this contains the application parameters that can be maintained via GUI
return array(
		// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
		// upload directory, parent folder must be webroot
		// in many cases, uploadDir will be used in different class here and there
		// therefore, it should be better setting in params rather than in application components
		'uploadDir' => 'upload',
		// cache directory
		// see uploadDir
		'cacheDir' => 'assets/cache',
);
