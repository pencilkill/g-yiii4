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
      	<a onclick="$('#customer-type-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      	<?php if($returnUrl = Yii::app()->user->getState('customer-type-grid-url')):?>
		<a onclick="location = '<?php  echo $returnUrl; ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php ;else:?>
		<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php endif;?>
      </div>
    </div>
    <div class="content">

	<?php
		$form = $this->beginWidget('GxActiveForm', array(
			'id' => 'customer-type-form',
			'enableAjaxValidation' => true,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
	?>

	<?php
		if($returnUrl = Yii::app()->user->getState('customer-type-grid-url')){
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
				<?php echo $form->labelEx($model,'default'); ?>
			</td>
			<td>
				<?php echo $form->checkBox($model, 'default'); ?>
				<?php echo $form->error($model,'default'); ?>
			</td>
		</tr><!-- row -->

		</table>

	<?php
		$this->endWidget();
	?>
	</div><!-- form -->
  </div>
</div>