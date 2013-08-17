<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'setting-form',
	'enableAjaxValidation' => false,
));
?>

		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Analysis Google'); ?>
		</label>
		<?php $key = 'analysis_google'; ?>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>5, 'cols'=>50)); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->
