<?php

/**
 * EImageSelect widget class file.
 * @author Sam <sam@ozchamp.net>

 * EImageSelect extends CWidget and implements a base class for a imageselect widget.
 * more about imgareaselect can be found at http://odyniec.net/projects/imgareaselect/, version: 0.9.10.
 */

class EImageSelect extends CWidget {
    // @ string the taget element on DOM
    public $target;
    // @ string the taget element on DOM
    public $ajaxUrl;
    // @ array of config settings for imageselect
    public $config = array();

    // function to init the widget
    public function init() {
    	if(empty($this->ajaxUrl)){
    		$this->ajaxUrl = CHtml::normalizeUrl(array('site/ajaxCrop'));
    	}
        // publish the required assets
        $this->publishAssets();
    }

    // function to run the widget
    public function run() {
        $config = CJavaScript::encode($this->config);
        if(!empty($this->target)){
	        Yii::app()->clientScript->registerScript($this->getId(), "
				$('{$this->target}').imgAreaSelect($config);
			");
        }
    }

    // function to publish and register assets on page
    public function publishAssets() {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCssFile($baseUrl . '/css/imgareaselect-default.css');
            //Yii::app()->clientScript->registerCssFile($baseUrl . '/css/imgareaselect-animated.css');
            //Yii::app()->clientScript->registerCssFile($baseUrl . '/css/imgareaselect-deprecated.css');
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/scripts/jquery.imgareaselect.pack.js', CClientScript::POS_END);
        } else {
            throw new Exception('EImageSelect - Error: Couldn\'t find assets to publish.');
        }
    }

}