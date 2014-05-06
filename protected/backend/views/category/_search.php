<div class="wide form buttons">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'parent_id'); ?>
		<?php echo $form->dropDownList($model, 'parent_id', GxHtml::listDataEx(Category::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'sort_order'); ?>
		<?php echo $form->textField($model, 'sort_order'); ?>
	</div>



	<div class="row">
		<?php echo GxHtml::linkButton(Yii::t('app', 'Search'), array('class' => 'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
