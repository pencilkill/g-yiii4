<div class="wide form buttons">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'top'); ?>
		<?php echo $form->dropDownList($model, 'top', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'sort_order'); ?>
		<?php echo $form->textField($model, 'sort_order'); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'date_added'); ?>
		<?php echo $form->textField($model, 'date_added', array('class' => 'CJuiDatePicker', 'value' => ($a = CHtml::resolveValue($model, 'date_added')) ? date('Y-m-d', strtotime($a)) : date('Y-m-d'))); ?>
	</div>



	<div class="row">
		<?php echo GxHtml::linkButton(Yii::t('app', 'Search'), array('class' => 'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
