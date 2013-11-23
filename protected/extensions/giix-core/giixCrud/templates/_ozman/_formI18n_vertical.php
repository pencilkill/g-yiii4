<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div id="content">
  <div class="breadcrumb">
	<?php echo '<?php'?> if(isset($this->breadcrumbs)):?>
		<?php echo '<?php'?> $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php echo '<?php'?> endif?>
  </div>

  <?php echo '<?php'?> foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
	<div class="<?php echo '<?php'?> echo $key?>"><?php echo '<?php'?> echo $message?></div>
  <?php echo '<?php'?> endforeach;?>

  <div class="box">
    <div class="heading">
      <div class="buttons">
      	<a onclick="$('#<?php echo $this->class2id($this->modelClass); ?>-form').submit();" class="button"><?php echo '<?php '; ?> echo Yii::t('app', 'Save'); ?></a>
      	<a onclick="location = '<?php echo '<?php '; ?> echo $this->createUrl('index', array()); ?>';" class="button"><?php echo '<?php '; ?> echo Yii::t('app', 'Cancel'); ?></a>
      </div>
    </div>
    <div class="content">
		<div class="htabs">
			<a href="#tab-basic"><?php echo '<?php '; ?> echo Yii::t('app', 'Tabs Basic')?></a>
			<a href="#tab-lanugage"><?php echo '<?php '; ?> echo Yii::t('app', 'Tabs Language')?></a>
			<!--<a href="#tab-swfupload"><?php echo '<?php '; ?> echo Yii::t('app', 'Product Images')?></a>-->
		</div>
<?php $ajax = ($this->enable_ajax_validation) ? 'true' : 'false'; ?>

		<?php echo '<?php '; ?>

			$form = $this->beginWidget('GxActiveForm', array(
				'id' => '<?php echo $this->class2id($this->modelClass); ?>-form',
				'enableAjaxValidation' => <?php echo $ajax; ?>,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));
		<?php echo '?>'; ?>

		<div id="tab-basic">
			<?php echo '<?php '; ?> echo $this->renderPartial('_basic', array('form' => $form, 'model' => $model), true)?>
		</div>

		<div id="tab-language">
			<div class="vtabs">
				<?php echo '<?php '; ?> foreach($this->languages as $val):?>
					<a href="#tab-language-<?php echo '<?php '; ?> echo $val['language_id']?>"><?php echo '<?php '; ?> echo $val['title']?></a>
	  			<?php echo '<?php '; ?> endforeach;?>
			</div>
			<?php echo '<?php '; ?> foreach($this->languages as $val):?>
			<div id="tab-language-<?php echo '<?php '; ?> echo $val['language_id']?>" class="vtabs-content">
				<?php echo '<?php '; ?> echo $this->renderPartial('//<?php echo lcfirst($this->i18nRelation[3])?>/_i18n', array('form' => $form, 'model' => $i18ns[$val['language_id']], 'language_id' => $val['language_id']), true)?>
			</div>
			<?php echo '<?php '; ?> endforeach;?>
		</div>

		<!--<div id="tab-swfupload">
			<?php echo '<?php '; ?> //echo $this->renderPartial('_swfupload', array('gallery' => $gallery, 'galleries' => $galleries,), true)?>
		</div>-->

		<?php echo '<?php'?>

			$this->endWidget();
		?>

	</div><!-- form -->
  </div>
</div>