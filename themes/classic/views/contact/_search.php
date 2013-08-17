<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 32)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'gender'); ?>
		<?php echo $form->textField($model, 'gender', array('maxlength' => 16)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'telphone'); ?>
		<?php echo $form->textField($model, 'telphone', array('maxlength' => 16)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'cellphone'); ?>
		<?php echo $form->textField($model, 'cellphone', array('maxlength' => 16)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'fax'); ?>
		<?php echo $form->textField($model, 'fax', array('maxlength' => 16)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 64)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'corporation'); ?>
		<?php echo $form->textField($model, 'corporation', array('maxlength' => 256)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'address'); ?>
		<?php echo $form->textField($model, 'address', array('maxlength' => 256)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'message'); ?>
		<?php echo $form->textArea($model, 'message'); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'note'); ?>
		<?php echo $form->textArea($model, 'note'); ?>
	</div>



	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
