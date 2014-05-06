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
      	<a onclick="$('#contact-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      	<?php if($returnUrl = Yii::app()->user->getState('contact-grid-url')):?>
		<a onclick="location = '<?php  echo $returnUrl; ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php ;else:?>
		<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php endif;?>
      </div>
    </div>
    <div class="content">

	<?php
		$form = $this->beginWidget('GxActiveForm', array(
			'id' => 'contact-form',
			'enableAjaxValidation' => true,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
	?>

	<?php
		if($returnUrl = Yii::app()->user->getState('contact-grid-url')){
			echo CHtml::hiddenField('returnUrl', $returnUrl);
		}
	?>

		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'firstname'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'firstname', array('maxlength' => 32, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'firstname'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'lastname'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'lastname', array('maxlength' => 32, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'lastname'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'sex'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($model, 'sex', array('0' => Yii::t('app', 'Female'), '1' => Yii::t('app', 'Male')), array('readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'sex'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'telephone'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'telephone', array('maxlength' => 16, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'telephone'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'cellphone'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'cellphone', array('maxlength' => 16, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'cellphone'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'fax'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'fax', array('maxlength' => 16, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'fax'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'email'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'email', array('maxlength' => 64, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'email'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'company'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'company', array('maxlength' => 256, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'company'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'address'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'address', array('maxlength' => 256, 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'address'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'message'); ?>
			</td>
			<td>
				<?php echo $form->textArea($model, 'message', array('rows' => 10, 'cols' => 100, 'class' => '', 'readonly' => 'readonly')); ?>
				<?php echo $form->error($model,'message'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'status'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($model, 'status', array('0' => Yii::t('app', 'Unnoticed'), '1' => Yii::t('app', 'Noticed'))); ?>
				<?php echo $form->error($model,'status'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'remark'); ?>
			</td>
			<td>
				<?php echo $form->textArea($model, 'remark', array('rows' => 10, 'cols' => 100, 'class' => '')); ?>
				<?php echo $form->error($model,'remark'); ?>
			</td>
		</tr><!-- row -->

		</table>

	<?php
		$this->endWidget();
	?>
	</div><!-- form -->
  </div>
</div>