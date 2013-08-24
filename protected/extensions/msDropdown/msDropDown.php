<?php
/**
 * CDropDownMenu class file.
 *
 * @author Herbert Maschke <thyseus@gmail.com>
 * @link http://www.yiiframework.com/
 */

/**
 * CDropDownMenu is an extension to CMenu that supports Drop-Down Menus using the
 * superfish jquery-plugin.
 *
 * Please be sure to also read the CMenu API Documentation to understand how this
 * menu works.
 *
 */

class msDropDown extends CInputWidget
{
	public $settings = array();
	public $style = 'skin2';
	public $cssFile = 'dd.css';
	public $position = CClientScript::POS_HEAD;

	public function init()
	{
		parent::init();
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		$this->registerClientScript();
	}

	protected function registerClientScript() {
		$basePath = Yii::getPathOfAlias('ext.msDropDown');
		$baseUrl = Yii::app()->getAssetManager()->publish($basePath.'/assets');

		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerCssFile($baseUrl . '/css/' . $this->cssFile);
		if(! $this->style){
			$cs->registerCssFile($baseUrl . '/css/' . 'skin2.css');
		}else{
			$cs->registerCssFile($baseUrl . '/css/' . $this->style . '.css');
		}

		$cs->registerScriptFile($baseUrl . '/js/' . 'jquery.dd.min.js',$this->position);
	}

}
