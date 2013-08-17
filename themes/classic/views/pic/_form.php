<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'pic-form',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>






		<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php echo CSite::ajaxImageUpload(array('model' => $model,'attribute' => 'pic'))?>
		<?php echo $form->error($model,'pic'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model, 'url', array('maxlength' => 256)); ?>
		<?php echo $form->error($model,'url'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'pic_type_id'); ?>
		<?php echo $form->dropDownList($model, 'pic_type_id', GxHtml::listDataEx(PicType::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'pic_type_id'); ?>
		</div><!-- row -->


		<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model, 'status'); ?>
		<?php echo $form->error($model,'status'); ?>
		</div><!-- row -->

		<div class="row">
		<?php echo $form->labelEx($model,'sort_id'); ?>
		<?php echo $form->textField($model, 'sort_id', array('maxlength' => 11)); ?>
		<?php echo $form->error($model,'sort_id'); ?>
		</div><!-- row -->



<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->