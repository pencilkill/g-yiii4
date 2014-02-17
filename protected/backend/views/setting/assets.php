<?php

$this->breadcrumbs = array(
	Yii::t('setting', 'Setting') => array('asset'),
	Yii::t('setting', 'Asset Manager'),
);

?>
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
      	<a onclick="$('#setting-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      </div>
    </div>
    <div class="content">
		<?php
			$form = $this->beginWidget('GxActiveForm', array(
				'id' => 'setting-form',
				'enableAjaxValidation' => true,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));
		?>

		<table class="form">

		<tr>
			<td>
				<?php echo Yii::t('app', 'Files'); ?>
			</td>
			<td>
				<div class="scrollbox" style="height: 500px; width: 500px;">
					<?php $class='odd'?>
					<?php foreach ($files as $file):?>
						<?php $item = strtr($file, array($dir . DIRECTORY_SEPARATOR => ''))?>

						<div class="<?php echo $class?>">
						<?php echo CHtml::checkBox('remove[]', true, array('value'=>$item))?>
						<?php if(is_dir($file)):?>
						<?php echo CHtml::link($item, $this->createUrl('asset', array('base' => $item)))?>
						<?php ;else:?>
						<?php echo $item?>
						<?php endif;?>
						</div>
						<?php $class = $class=='even' ? 'odd' : 'even'?>
					<?php endforeach;?>
				</div>
			</td>
		</tr><!-- row -->

		</table>

		<?php
			$this->endWidget();
		?>
	</div><!-- form -->
  </div>
</div>