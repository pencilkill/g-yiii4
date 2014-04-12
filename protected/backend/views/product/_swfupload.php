<?php
/*
 * ************** start swfupload extension translations *********
Yii::t('app', 'Select A Image');
Yii::t('app', 'Confirm Gallery Image Delete?');
Yii::t('app', 'Gallery Image Delete');
 * ************** end of swfupload extension translations *********
*/

$this->widget('frontend.extensions.swfupload.CSwfUpload', array(
		// defined in init()
		//'jsHandlerUrl'=>$baseUrl.'/handlers.js',
		//
		'photos' => $photos,
		'attributes' => array(
			array(
				'attribute' => 'product_id',
			),
		),
		//This will be merge to config, see init()
		'config' => array(
			'post_params' => array(
				'model' => CHtml::modelName($photo),
			),
			'button_text' => '<span class="button">'.Yii::t('app', 'Select A Image').' [400 * 300]</span>',
		),
    )
);
?>