<div class="wide form buttons">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>





	<div class="row">
		<?php echo $form->label($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'firstname'); ?>
		<?php echo $form->textField($model, 'firstname', array('maxlength' => 32)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'lastname'); ?>
		<?php echo $form->textField($model, 'lastname', array('maxlength' => 32)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'sex'); ?>
		<?php echo $form->dropDownList($model, 'sex', array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'telephone'); ?>
		<?php echo $form->textField($model, 'telephone', array('maxlength' => 16)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'cellphone'); ?>
		<?php echo $form->textField($model, 'cellphone', array('maxlength' => 16)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'fax'); ?>
		<?php echo $form->textField($model, 'fax', array('maxlength' => 16)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('maxlength' => 64)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'company'); ?>
		<?php echo $form->textField($model, 'company', array('maxlength' => 256)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'address'); ?>
		<?php echo $form->textField($model, 'address', array('maxlength' => 256)); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'message'); ?>
		<?php echo $form->textArea($model, 'message', array('rows' => 5, 'cols' => 50, 'class' => '')); ?>
	</div>



	<div class="row">
		<?php echo $form->label($model, 'remark'); ?>
		<?php echo $form->textArea($model, 'remark', array('rows' => 5, 'cols' => 50, 'class' => '')); ?>
	</div>



	<div class="row">
		<?php echo GxHtml::linkButton(Yii::t('app', 'Search'), array('class' => 'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
