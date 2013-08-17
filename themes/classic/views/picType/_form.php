<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'pic-type-form',
	'enableAjaxValidation' => true,
));
?>




		<div class="row">
		<?php echo $form->labelEx($model,'pic_type'); ?>
		<?php echo $form->textField($model, 'pic_type', array('maxlength' => 32)); ?>
		<?php echo $form->error($model,'pic_type'); ?>
		</div><!-- row -->



		<label><?php echo GxHtml::encode($model->getRelationLabel('pics')); ?></label>
		<?php echo $form->checkBoxList($model, 'pics', GxHtml::encodeEx(GxHtml::listDataEx(Pic::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->