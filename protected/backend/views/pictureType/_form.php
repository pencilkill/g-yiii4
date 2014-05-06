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
      	<a onclick="$('#picture-type-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      	<?php if($returnUrl = Yii::app()->user->getState('picture-type-grid-url')):?>
		<a onclick="location = '<?php  echo $returnUrl; ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php ;else:?>
		<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php endif;?>
      </div>
    </div>
    <div class="content">

	<?php
		$form = $this->beginWidget('GxActiveForm', array(
			'id' => 'picture-type-form',
			'enableAjaxValidation' => true,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
	?>

	<?php 
		if($returnUrl = Yii::app()->user->getState('picture-type-grid-url')){
			echo CHtml::hiddenField('returnUrl', $returnUrl);
		}
	?>

		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'picture_type'); ?>
			</td>
			<td>
				<?php echo HCUploader::ajaxImageUpload(array('model' => $model,'attribute' => 'picture_type')); ?>
				<?php echo $form->error($model,'picture_type'); ?>
			</td>
		</tr><!-- row -->

		</table>

	<?php
		$this->endWidget();
	?>
	</div><!-- form -->
  </div>
</div>