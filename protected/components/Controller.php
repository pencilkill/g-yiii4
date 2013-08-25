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
	 * see app behavior to get more about init()
	 */
	public function init() {
		parent::init();
	}

	public function createUrl($route,$params=array(),$ampersand='&')
    {
    	/**
		 * default name is "language"
		 */
		$languageVar = (isset(Yii::app()->params->languageVar))? Yii::app()->params->languageVar : false;
    	// append language param
        if ($languageVar !== false && (! isset($params[$languageVar])))
        {
            $params[$languageVar] = Yii::app()->language;
        }
        // to make a no language parameter url sometimes
        if($languageVar === false || (isset($params[$languageVar]) && $params[$languageVar] === false)){
        	unset($params[$languageVar]);
        }
        // create
        if($route===''){
            $route=$this->getId().'/'.$this->getAction()->getId();
        }
        else if(strpos($route,'/')===false){
            $route=$this->getId().'/'.$route;
        }
        if($route[0]!=='/' && ($module=$this->getModule())!==null){
            $route=$module->getId().'/'.$route;
        }
        return Yii::app()->createUrl(trim($route,'/'),$params,$ampersand);
    }

}