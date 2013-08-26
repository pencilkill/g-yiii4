<?php
// The backend configuration will override this configuration using CMap::mergeArray()

// this contains the application parameters that can be maintained via GUI

// cause backend config merge with frontend
// be careful that those language var should be access for backend
// I just comment those and move language setting to app behavior
// see app behavior to get more about language setting please
return array(
		// upload directory, parent folder must be webroot
		// in many cases, uploadDir will be used in different class here and there
		// therefore, it should be better setting in params rather than in application components
		'uploadDir' => 'upload',
		// cache directory
		// see uploadDir
		'cacheDir' => 'assets/cache',
);
