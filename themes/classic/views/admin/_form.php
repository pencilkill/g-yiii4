<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'admin-form',
	'enableAjaxValidation' => true,
));
?>




		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->


		<div class="row">
		<?php if($model->isNewRecord){?>
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model, 'username', array('maxlength' => 32)); ?>
			<?php echo $form->error($model,'username'); ?>
		<?php }else{?>
			<?php echo $form->label($model,'username'); ?>
			<?php echo $form->textField($model, 'username', array('name' => '', 'disabled' => 'disabled')); ?>
		<?php }?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('maxlength' => 32, 'value' => '')); ?>
		<?php echo $form->error($model,'password'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'confirm_password'); ?>
		<?php echo $form->passwordField($model, 'confirm_password', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'confirm_password'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model, 'status'); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->




<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->