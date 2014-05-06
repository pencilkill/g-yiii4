<div class="wide form buttons">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'customer_group_id'); ?>
		<?php echo $form->dropDownList($model, 'customer_group_id', GxHtml::listDataEx(CustomerGroup::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 32)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'username'); ?>
		<?php echo $form->textField($model, 'username', array('maxlength' => 32)); ?>
	</div>




	<div class="row">
		<?php echo $form->label($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo GxHtml::linkButton(Yii::t('app', 'Search'), array('class' => 'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
