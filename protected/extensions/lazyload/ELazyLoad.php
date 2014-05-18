<?php

/**
 * ELazyLoad widget class file.
 * @author Sam <mail.song.de.qiang@gmail.com>

 * ELazyLoad extends CWidget and implements a base class for a lazyload widget.
 * more about lazeload can be found at https://github.com/tuupola/jquery_lazyload/
 */

class ELazyLoad extends CWidget {
    // @ string the taget element on DOM
    public $target;
    // @ array of config settings for imageselect
    public $config = array();

    // function to init the widget
    public function init() {
        // publish the required assets
        $this->publishAssets();
    }

    // function to run the widget
    public function run() {
        $config = CJavaScript::encode($this->config);
        if(!empty($this->target)){
	        Yii::app()->clientScript->registerScript($this->getId(), "
				$('{$this->target}').lazeload($config);
			");
        }
    }

    // function to publish and register assets on page
    public function publishAssets() {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/lazeload', CClientScript::POS_HEAD);
        } else {
            throw new Exception(__CLASS__ . ' - Error: Couldn\'t find assets to publish.');
        }
    }

}