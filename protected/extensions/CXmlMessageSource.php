<?php

/*
 * Chive - web based MySQL database management
 * Copyright (C) 2010 Fusonic GmbH
 *
 * This file is part of Chive.
 *
 * Chive is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * Chive is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public
 * License along with this library. If not, see <http://www.gnu.org/licenses/>.
 */


class CXmlMessageSource extends CMessageSource
{

	const CACHE_KEY_PREFIX = 'Yii.CXmlMessageSource.';

	/**
	 * @var integer the time in seconds that the messages can remain valid in cache.
	 * Defaults to 0, meaning the caching is disabled.
	 */
	public $cachingDuration = 0;

	/**
	 * @var string the base path for all translated messages. Defaults to null, meaning
	 * the "messages" subdirectory of the application directory (e.g. "protected/messages").
	 */
	public $basePath;

	/**
	 * @see		CMessageSource::init()
	 */
	public function init()
	{
		parent::init();
		if($this->basePath === null)
		{
			$this->basePath = Yii::getPathOfAlias('application.messages');
		}
	}

	/**
	 * Publishes all messages to JavaScript files to use on client side.
	 */
	public function publishJavaScriptMessages()
	{
		$language = Yii::app()->getLanguage();

		// Load date of last change
		$maxFiletime = null;

		$files = glob($this->basePath . DIRECTORY_SEPARATOR . $language . DIRECTORY_SEPARATOR . '*.xml');

		$packages = array();
		foreach($files AS $file)
		{
			$packages[] = substr(basename($file), 0, strlen(basename($file)) - 4);
			$time = filemtime($file);
			if($time > $maxFiletime)
			{
				$maxFiletime = $time;
			}
		}

		// Get asset manager
		$assetManager = Yii::app()->getAssetManager();
		$assetPath = $assetManager->getBasePath() . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR . 'js';

		// Check for changes
		$publish = false;
		if(!is_dir($assetPath))
		{
			mkdir($assetPath, 0777, true);
			$publish = true;
		}
		elseif(!is_file($assetPath . DIRECTORY_SEPARATOR . $language . '.js'))
		{
			$publish = true;
		}
		elseif(filemtime($assetPath . DIRECTORY_SEPARATOR . $language . '.js') < $maxFiletime)
		{
			$publish = true;
		}

		// Publish if needed
		if($publish || YII_DEBUG)
		{
			$code = '';
			foreach($packages AS $package)
			{
				$code .= 'i18n.' . $package . ' = [];' . "\n";
				$data = $this->loadMessages($package, $language);
				foreach($data AS $key => $value)
				{
					$code .= 'i18n.' . $package . '["' . $key . '"] = ' . CJSON::encode($value) . ';' . "\n";
				}
			}
			file_put_contents($assetPath . DIRECTORY_SEPARATOR . $language . '.js', $code);
		}
	}

	/**
	 * @see		CMessageSource::loadMessages()
	 */
	public function loadMessages($category, $language)
	{
		// Caching things
		$cache = Yii::app()->getCache();
		$cacheKey = self::CACHE_KEY_PREFIX . $language . '.' . $category;

		// Try to load messages from cache
		if(!is_null($cache) && ($data = $cache->get($cacheKey)) !== false && !YII_DEBUG)
		{
			return $data;
		}

		// Try to load messages from file
		$messageFile = $this->basePath . DIRECTORY_SEPARATOR . $language . '.xml';

		if(is_file($messageFile))
		{
			$xml = simplexml_load_file($messageFile)->getAttributes;

			foreach($xml->children() as $entry)
			{
				foreach($entry as $key => $value) {
		            $messages[(string)$entry->attributes()][(string)$key] = (string)$value;
				}

				if(!is_null($cache))
				{
					$cache->set($cacheKey, $messages[(string)$entry->attributes()], $this->cachingDuration);
				}
			}
		}

		return isset($messages[$category]) ? $messages[$category] : array();
	}

}