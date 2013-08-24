<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'top'); ?>
		<?php echo $form->dropDownList($model, 'top', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'sort_id'); ?>
		<?php echo $form->textField($model, 'sort_id'); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'date_added'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'date_added',
			'language' => Yii::app()->language,
			'options' => array(
				'showButtonPanel' => false,
				'changeYear' => true,
				'changeMonth' => true,
				'dateFormat' => 'yy-mm-dd',
				'yearRange' => '-5:+5',
			),
			'htmlOptions' => array(
				'readonly' => 'readonly',
				'value' => $model->date_added ? date('Y-m-d', strtotime($model->date_added)) : date('Y-m-d'),
			),
			));
; ?>
	</div>



	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
