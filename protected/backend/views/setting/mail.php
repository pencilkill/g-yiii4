<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'setting-form',
	'enableAjaxValidation' => false,
));
?>

		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Mail Contact Email'); ?>
		</label>
		<?php $key = 'mail_contact_email'; ?>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>5, 'cols'=>50)); ?>
		</div><!-- row -->


		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Mail Smtp Host'); ?>
		</label>
		<?php $key = 'mail_smtp_host'; ?>
		<?php echo CHtml::textField("Setting[{$key}]", Yii::app()->config->get($key)); ?>
		</div><!-- row -->


		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Mail Smtp User'); ?>
		</label>
		<?php $key = 'mail_smtp_user'; ?>
		<?php echo CHtml::textField("Setting[{$key}]", Yii::app()->config->get($key)); ?>
		</div><!-- row -->


		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Mail Smtp Password'); ?>
		</label>
		<?php $key = 'mail_smtp_password'; ?>
		<?php echo CHtml::textField("Setting[{$key}]", Yii::app()->config->get($key)); ?>
		</div><!-- row -->


		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Mail Smtp Port'); ?>
		</label>
		<?php $key = 'mail_smtp_port'; ?>
		<?php echo CHtml::textField("Setting[{$key}]", Yii::app()->config->get($key)); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->