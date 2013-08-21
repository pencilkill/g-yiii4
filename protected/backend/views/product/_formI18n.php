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
      	<a onclick="$('#product-form').submit();" class="button"><?php  echo Yii::t('app', 'Save'); ?></a>
      	<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
      </div>
    </div>
    <div class="content">
		<div id="tabs" class="htabs">
			<a href="#tab-basic"><?php  echo Yii::t('app', 'Tabs Basic')?></a>
  			<?php  foreach($this->languages as $val):?>
			<a href="#tab-language-<?php  echo $val['language_id']?>"><?php  echo $val['title']?></a>
  			<?php  endforeach;?>
			<a href="#tab-swfupload"><?php  echo Yii::t('app', 'Product Images')?></a>
		</div>

		<?php
			$form = $this->beginWidget('GxActiveForm', array(
				'id' => 'product-form',
				'enableAjaxValidation' => true,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));
		?>
		<div id="tab-basic">
			<?php  echo $this->renderPartial('_basic', array('form' => $form, 'model' => $model, 'categoryIds' => $categoryIds, 'categories' => $categories), true)?>
		</div>

		<?php  foreach($this->languages as $val):?>
		<div id="tab-language-<?php  echo $val['language_id']?>">
			<?php  echo $this->renderPartial('//productI18n/_i18n', array('form' => $form, 'model' => $i18ns[$val['language_id']], 'language_id' => $val['language_id']), true)?>
		</div>
		<?php  endforeach;?>

		<div id="tab-swfupload">
			<?php  echo $this->renderPartial('_swfupload', array('gallery' => $gallery, 'galleries' => $galleries,), true)?>
		</div>

		<?php
			$this->endWidget();
		?>

	</div><!-- form -->
  </div>
</div>