<div class="form">

<?php
	$juiTabs = array();
	
	foreach ($this->languages as $language) {
		$juiTabs[$language['title']] = $this->renderPartial('//setting/_i18n/meta', array('language_id' => $language['language_id']), true);
	}
?>

<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'product-form',
	'enableAjaxValidation' => true,
));
?>
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>$juiTabs,
));
?>
<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->