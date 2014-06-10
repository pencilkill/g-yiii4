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
	 * @var skinUrl(appAssetsUrl), based on app theme
	 */
	public $skinUrl;

	/**
	 * The filter method for 'rights' access filter.
	 */
	public function filters() {
		return array(
			'rights',
		);
	}

	public function init() {
		parent::init();
		// set language
		$this->languages();
		// skinUrl
		$this->skinUrl = HCTheme::publishThemeAssets();
		// pageTitle
		$this->pageTitle = Yii::app()->name;
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

}