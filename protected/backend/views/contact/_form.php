<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'contact-form',
	'enableAjaxValidation' => true,
));
?>




		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->textField($model, 'gender', array('maxlength' => 16)); ?>
		<?php echo $form->error($model,'gender'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'telphone'); ?>
		<?php echo $form->textField($model, 'telphone', array('maxlength' => 16)); ?>
		<?php echo $form->error($model,'telphone'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'cellphone'); ?>
		<?php echo $form->textField($model, 'cellphone', array('maxlength' => 16)); ?>
		<?php echo $form->error($model,'cellphone'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'fax'); ?>
		<?php echo $form->textField($model, 'fax', array('maxlength' => 16)); ?>
		<?php echo $form->error($model,'fax'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 64)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'corporation'); ?>
		<?php echo $form->textField($model, 'corporation', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'corporation'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model, 'address', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'address'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model, 'message'); ?>
		<?php echo $form->error($model,'message'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model, 'note'); ?>
		<?php echo $form->error($model,'note'); ?>
		</div><!-- row -->




<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->