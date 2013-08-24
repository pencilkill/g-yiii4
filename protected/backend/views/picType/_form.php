<div id="content">
  <div class="breadcrumb">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
  </div>

  <?php foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
	<div class="<?php echo $key?>"><?php echo $message?></div>
  <?php endforeach;?>

  <div class="box">
    <div class="heading">
      <div class="buttons">
      	<a onclick="$('#pic-type-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      	<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
      </div>
    </div>
    <div class="content">

	<?php
		$form = $this->beginWidget('GxActiveForm', array(
			'id' => 'pic-type-form',
			'enableAjaxValidation' => true,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
	?>

		<table class="form">




		<tr>
			<td>
				<?php echo $form->labelEx($model,'pic_type'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'pic_type', array('maxlength' => 256)); ?>
				<?php echo $form->error($model,'pic_type'); ?>
			</td>
		</tr><!-- row -->



		</table>
	<?php
		$this->endWidget();
	?>
	</div><!-- form -->
  </div>
</div>