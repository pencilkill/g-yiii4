<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'sort_id'); ?>
		<?php echo $form->textField($model, 'sort_id'); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'pic'); ?>
		<?php echo $form->textField($model, 'pic', array('maxlength' => 256)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'pic_type_id'); ?>
		<?php echo $form->dropDownList($model, 'pic_type_id', GxHtml::listDataEx(PicType::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
