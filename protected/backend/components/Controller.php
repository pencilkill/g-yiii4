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

	public function init() {
		parent::init();
		// set language
		$this->languages();
		// pageTitle
		$this->pageTitle = Yii::app()->name;
	}

	public function filters() {
		return array(
			'rights',
		);
	}

	public function languages() {
		$qa = array(
			'select' => '*',
			'from' => 'language',
			'where' => array(
				'status = 1',
			),
			'order' => "field(code, '".Yii::app()->language."') desc, sort desc",
		);

		$languages = Yii::app()->db->createCommand($qa)->queryAll();

		$this->languages = $languages;

		if(isset($languages[0]['language_id'])){
			$this->language_id = $languages[0]['language_id'];
		}
	}

	/**
	 * This is for HAS_MANY or MANY_MANY to get value when using gridview
	 * cause using index when we defined relations, the related data type is associate sometimes
	 * e.g. $data->related[0]->name is not aways correct
	 * @param Object $data
	 * @param Integer $row
	 * @param CDataColumn $column
	 * return mixed
	 */
	public function columnValue($data, $row, $column){
		$r = explode('.', $column->name);
		$i = $data->$r[0];
		return (sizeOf($r)===1) ? $i : $i[key($i)][$r[1]];
	}
}