<?php

$this->breadcrumbs = array(
	Yii::t('setting', 'Setting') => array('index'),
	Yii::t('setting', 'Update'),
);

$groups = array(
	'meta' => Yii::t('setting', 'Meta'),
	'mail' => Yii::t('setting', 'Mail'),
	'analysis' => Yii::t('setting', 'Analysis'),
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
      	<a onclick="$('#category-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      </div>
    </div>
    <div class="content">
		<div id="tabs" class="htabs">
		<?php foreach ($groups as $key => $val):?>
			<a href="#tab-<?php echo $key?>"><?php  echo $val?></a>
		<?php endforeach;?>
		</div>

		<?php
			$form = $this->beginWidget('GxActiveForm', array(
				'id' => 'category-form',
				'enableAjaxValidation' => true,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));
		?>

		<?php foreach ($groups as $key => $val):?>
		<div id="tab-<?php echo $key?>">
			<?php  echo $this->renderPartial($key, array('group' => $key))?>
		</div>
		<?php endforeach;?>

		<?php
			$this->endWidget();
		?>

	</div><!-- form -->
  </div>
</div>
<script type="text/javascript">
$('[id$="-languages"] a').tabs();
$('[id$="-htabs"] a').tabs();
</script>