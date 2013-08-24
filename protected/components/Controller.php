<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
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

	public function init() {
		parent::init();
		/**
		 *  see behavior to get more about init()
		 */
		// set language_id
		$this->setLanuageId(Yii::app()->language);
	}

	public function setLanuageId($languageCode){
		$this->language_id = Language::model()->findByAttributes(array('code'=>$languageCode))->language_id;
	}
}