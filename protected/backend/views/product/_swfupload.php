<?php
/*
 * ************** start swfupload extension translations *********
Yii::t('app', 'Select A Image');
Yii::t('app', 'Confirm Gallery Image Delete?');
Yii::t('app', 'Gallery Image Delete');
 * ************** end of swfupload extension translations *********
*/
$modelClass = is_object($gallery) ? CHtml::modelName($gallery) : $gallery;
$languages = 0;

$this->widget('frontend.extensions.swfupload.CSwfUpload', array(
		// defined in init()
		//'jsHandlerUrl'=>$baseUrl.'/handlers.js',
		//
		'galleries' => $galleries,
		// This will be merge to config's post_params, see init()
		'postParams' => array(
			'modelClass' => $modelClass,
			'languages' => $languages,
			// thumbnail resize
			//'resize' => array(),
		),
		//
		//This will be merge to config's custom_setting, see init()
		/*
		'customSettings' => array(
			// Notic that '?' is required if thumb_url has no query string
			'thumb_url'=>CHtml::normalizeUrl(Yii::app()->createUrl('conroller/action')),
		),
		*/
		//This will be merge to config, see init()
		//'config' => array(),
    )
);
?>
