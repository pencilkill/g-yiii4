<?php

/**
 * ELayer widget class file.
 * @author Sam <mail.song.de.qiang@gmail.com>

 * more about layer can be found at http://sentsin.com/jquery/layer/api.html, http://www.layui.com/
 */

class ELayer extends CWidget {

	// function to run the widget
    public function run() {
    	$assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/layer.min.js', CClientScript::POS_HEAD);
        } else {
            throw new Exception(__CLASS__ . ' - Error: Couldn\'t find assets to publish.');
        }
    }
}