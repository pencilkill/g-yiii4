<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'product-form',
	'enableAjaxValidation' => true,
));
?>
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>array(
		Yii::t('app', 'Tabs Basic') => $this->renderPartial('_form', array('form' => $form, 'model' => $model, 'categories' => $categories, 'categoryIds' => $categoryIds,), true),
		'繁體中文' => $this->renderPartial('//productI18n/_i18n', array('form' => $form, 'model' => $i18ns[1], 'language_id' => 1), true),
		'English' => $this->renderPartial('//productI18n/_i18n', array('form' => $form, 'model' => $i18ns[2], 'language_id' => 2), true),
		'简体中文' => $this->renderPartial('//productI18n/_i18n', array('form' => $form, 'model' => $i18ns[3], 'language_id' => 3), true),
		Yii::t('app', 'Product Images') => $this->renderPartial('_swfupload', array('gallery' => $gallery, 'galleries' => $galleries,), true),
	),
));
?>
<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->