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
      	<a onclick="$('#contact-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      	<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
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

		<table class="form">

		<tr>
			<td>
				<?php echo $form->labelEx($model,'name'); ?>
			</td>
			<td>
				<?php echo CHtml::value($model, 'name'); ?>
				<?php echo $form->error($model,'name'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'gender'); ?>
			</td>
			<td>
				<?php echo Contact::$genderList[CHtml::value($model, 'gender')]; ?>
				<?php echo $form->error($model,'gender'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'telphone'); ?>
			</td>
			<td>
				<?php echo CHtml::value($model, 'telphone'); ?>
				<?php echo $form->error($model,'telphone'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'cellphone'); ?>
			</td>
			<td>
				<?php echo CHtml::value($model, 'cellphone'); ?>
				<?php echo $form->error($model,'cellphone'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'fax'); ?>
			</td>
			<td>
				<?php echo CHtml::value($model, 'fax'); ?>
				<?php echo $form->error($model,'fax'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'email'); ?>
			</td>
			<td>
				<?php echo CHtml::value($model, 'email'); ?>
				<?php echo $form->error($model,'email'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'corporation'); ?>
			</td>
			<td>
				<?php echo CHtml::value($model, 'corporation'); ?>
				<?php echo $form->error($model,'corporation'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'address'); ?>
			</td>
			<td>
				<?php echo CHtml::value($model, 'address'); ?>
				<?php echo $form->error($model,'address'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'message'); ?>
			</td>
			<td>
				<?php echo $form->textArea($model, 'message', array('readonly'=>'readonly', 'cols'=>100, 'rows'=>5)); ?>
				<?php echo $form->error($model,'message'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'status'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($model, 'status', Contact::$statusList); ?>
				<?php echo $form->error($model,'status'); ?>
			</td>
		</tr><!-- row -->

		<tr>
			<td>
				<?php echo $form->labelEx($model,'note'); ?>
			</td>
			<td>
				<?php echo $form->textArea($model, 'note', array('cols'=>100, 'rows'=>5)); ?>
				<?php echo $form->error($model,'note'); ?>
			</td>
		</tr><!-- row -->



		</table>
	<?php
		$this->endWidget();
	?>
	</div><!-- form -->
  </div>
</div>