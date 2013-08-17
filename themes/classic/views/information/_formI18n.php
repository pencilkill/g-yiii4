<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'information-form',
	'enableAjaxValidation' => true,
));
?>

<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>array(
		Yii::t('app', 'Tabs Basic') => $this->renderPartial('_form', array('form' => $form, 'model' => $model), true),
		'繁體中文' => $this->renderPartial('//informationI18n/_i18n', array('form' => $form, 'model' => $i18ns[1], 'language_id' => 1), true),
		'English' => $this->renderPartial('//informationI18n/_i18n', array('form' => $form, 'model' => $i18ns[2], 'language_id' => 2), true),
		'简体中文' => $this->renderPartial('//informationI18n/_i18n', array('form' => $form, 'model' => $i18ns[3], 'language_id' => 3), true),
	),
));
?>
<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->