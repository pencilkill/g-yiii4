<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @var ar
	 * default language code is Yii::app()->language code which using to get language_id if the request does not set a language id
	 */
	public $language_id;

	/**
	 * @var object
	 * all the languages for Db content i18n
	 */

	public $languages;

	/**
	 * @var skinUrl(assetsUrl), based on theme
	 */
	public $skinUrl;


	public function init() {
		parent::init();
		// set language
		$this->languages();
		// skinUrl
		$this->skinUrl = $this->publishThemeAssets();
		// pageTitle
		$this->pageTitle = Yii::app()->name;
	}

	public function filters() {
		return array(
			'rights',
		);
	}

	public function languages() {
		$criteria = new CDbCriteria;
		$criteria->alias = 't';
		//$criteria->compare('t.status', '1');
		$criteria->order = "FIELD(t.code, '".Yii::app()->language."') DESC, t.sort_order DESC";

		$languages = Language::model()->findAll($criteria);

		$this->languages = $languages;

		if($languages){
			$this->language_id = $languages[key($languages)]['language_id'];
		}
	}

	/**
	 * Using to get publishUrl dynamically, base on theme
	 * @see this->init()
	 * @param $assets
	 */
	public function publishThemeAssets($base = NULl){
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
			//$skinUrl = Yii::app()->assetManager->publish($path);

			/**
			 * Without assets, we can update file(s) immediately in this case
			 * uncomment the following if you do not need to publish folder
			 */
			$skinUrl = Yii::app()->theme->baseUrl . '/' . $base;
		}

		return $skinUrl;
	}
}