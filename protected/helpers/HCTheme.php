<?php
/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
 *
 */
class HCTheme {
	/**
	 * Using to get publishUrl dynamically, base on theme
	 * @param $assets resource relative to theme
	 */
	public static function publishThemeAssets($base = NULl){
		if($base == null){
			$base = CAssetManager::DEFAULT_BASEPATH;	// assets
		}

		// default as webroot
		$skinUrl = Yii::app()->baseUrl;

		if(Yii::app()->theme && is_dir($path = Yii::app()->theme->basePath . DIRECTORY_SEPARATOR . $base)){
			/**
			 * Assets folder published should be deleted for re-publishing in this case
			 * backend GUI for assets management is accessable for administrator
			 * uncomment the following as a published folder
			 */
			$skinUrl = Yii::app()->assetManager->publish($path);

			/**
			 * Without assets, we can update file(s) immediately in this case
			 * uncomment the following if you do not need to publish folder
			 */
			//$skinUrl = Yii::app()->theme->baseUrl . '/' . $base;
		}

		return $skinUrl;
	}
}
?>