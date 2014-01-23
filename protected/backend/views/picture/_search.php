<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'sort_order'); ?>
		<?php echo $form->textField($model, 'sort_order'); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'pic'); ?>
		<?php echo HCUploader::ajaxImageUpload(array('model' => $model,'attribute' => 'pic')); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'picture_type_id'); ?>
		<?php echo $form->dropDownList($model, 'picture_type_id', GxHtml::listDataEx(PictureType::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
