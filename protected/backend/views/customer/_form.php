<div id="content">
  <div class="breadcrumb">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
  </div>

  <div id="messageBox">
  <?php foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
	<div class="<?php echo $key?>"><?php echo $message?></div>
  <?php endforeach;?>
  </div>

  <div class="box">
    <div class="heading">
      <div class="buttons">
      	<a onclick="$('#customer-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      	<?php if($returnUrl = Yii::app()->user->getState('customer-grid-url')):?>
		<a onclick="location = '<?php  echo $returnUrl; ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php ;else:?>
		<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php endif;?>
      </div>
    </div>
    <div class="content">

	<?php
		$form = $this->beginWidget('GxActiveForm', array(
			'id' => 'customer-form',
			'enableAjaxValidation' => true,
			'htmlOptions' => array('enctype' => 'multipart/form-data', 'autocomplete' => 'off'),
		));
	?>

	<?php
		if($returnUrl = Yii::app()->user->getState('customer-grid-url')){
			echo CHtml::hiddenField('returnUrl', $returnUrl);
		}
	?>

		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'name'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'name', array('maxlength' => 32)); ?>
				<?php echo $form->error($model,'name'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'username'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'username', array('maxlength' => 32, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'username'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'password'); ?>
			</td>
			<td>
				<?php echo $form->passwordField($model, 'password', array('maxlength' => 32, 'value' => '')); ?>
				<?php echo $form->error($model,'password'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'confirm_password'); ?>
			</td>
			<td>
				<?php echo $form->passwordField($model, 'confirm_password', array('maxlength' => 32, 'value' => '')); ?>
				<?php echo $form->error($model,'confirm_password'); ?>
			</td>
		</tr><!-- row -->

		<tr style="display:none;">
			<td>
				<?php echo $form->labelEx($model,'customer_type_id'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($model, 'customer_type_id', CHtml::listData(CustomerType::model()->findAll(), 'customer_type_id', 'name')); ?>
				<?php echo $form->error($model,'customer_type_id'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'activated'); ?>
			</td>
			<td>
				<?php echo $form->checkBox($model, 'activated'); ?>
				<?php echo $form->error($model,'activated'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'status'); ?>
			</td>
			<td>
				<?php echo $form->checkBox($model, 'status'); ?>
				<?php echo $form->error($model,'status'); ?>
			</td>
		</tr><!-- row -->

		</table>

	<?php
		$this->endWidget();
	?>
	</div><!-- form -->
  </div>
</div>