<?php
/*
 * ************** start swfupload extension translations *********
Yii::t('app', 'Select A Image');
Yii::t('app', 'Confirm Gallery Image Delete?');
Yii::t('app', 'Gallery Image Delete');
 * ************** end of swfupload extension translations *********
*/

$this->widget('frontend.extensions.swfupload.CSwfUpload', array(
		'photos' => $photos,
		'model' => CHtml::modelName($photo),
		'attribute' => 'pic',
		'attributes' => array(
			array(
				'attribute' => 'product_id',
			),
		),
		'config' => array(
			'button_text' => '<span class="button">'.Yii::t('app', 'Select A Image').' [400 * 300]</span>',
		),
    )
);
?>