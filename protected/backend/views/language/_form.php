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
      	<a onclick="$('#language-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      	<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
      </div>
    </div>
    <div class="content">

	<?php
		$form = $this->beginWidget('GxActiveForm', array(
			'id' => 'language-form',
			'enableAjaxValidation' => true,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
	?>

		<table class="form">


		<tr>
			<td>
				<?php echo $form->labelEx($model,'image'); ?>
			</td>
			<td>
				<select id="<?php echo CHtml::activeId($model, 'image')?>" name="<?php echo CHtml::activeName($model, 'image')?>" length="5">
					<?php foreach($images as $val):?>
						<?php if($val['value'] == CHtml::value($model, 'image')):?>
						<option value="<?php echo $val['value']?>" data-image="<?php echo $val['data-image']?>" selected="selected"><?php echo $val['text']?></option>
						<?php ;else:?>
						<option value="<?php echo $val['value']?>" data-image="<?php echo $val['data-image']?>"><?php echo $val['text']?></option>
						<?php endif;?>
					<?php endforeach;?>
				</select>
				<?php echo $form->error($model,'image'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'code'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'code', array('maxlength' => 8)); ?>
				<?php echo $form->error($model,'code'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'title'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'title', array('maxlength' => 64)); ?>
				<?php echo $form->error($model,'title'); ?>
			</td>
		</tr><!-- row -->


		<tr>
			<td>
				<?php echo $form->labelEx($model,'sort_id'); ?>
			</td>
			<td>
				<?php echo $form->textField($model, 'sort_id'); ?>
				<?php echo $form->error($model,'sort_id'); ?>
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
<?php $this->widget('ext.msDropdown.msDropDown', array())?>
<script type="text/javascript">
jQuery('#<?php echo CHtml::activeId($model, 'image')?>').msDropDown();
</script>