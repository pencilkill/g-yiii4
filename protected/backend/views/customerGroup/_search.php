<div class="wide form buttons">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 32)); ?>
	</div>

	<div class="row">
		<?php echo GxHtml::linkButton(Yii::t('app', 'Search'), array('class' => 'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
