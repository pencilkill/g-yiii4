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
      	<?php if($returnUrl = Yii::app()->user->getState('category-grid-url')):?>
		<a onclick="location = '<?php  echo $returnUrl; ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php ;else:?>
		<a onclick="location = '<?php  echo $this->createUrl('index', array()); ?>';" class="button"><?php  echo Yii::t('app', 'Cancel'); ?></a>
		<?php endif;?>
      </div>
    </div>
    <div class="content">
		<div class="htabs">
			<a href="#tab-basic"><?php  echo Yii::t('app', 'Tabs Basic')?></a>
  			<?php  foreach($this->languages as $val):?>
			<a href="#tab-language-<?php  echo $val['language_id']?>"><?php  echo $val['title']?></a>
  			<?php  endforeach;?>
			<!--<a href="#tab-swfupload"><?php  echo Yii::t('app', 'Tabs Image')?></a>-->
		</div>

		<?php
			$form = $this->beginWidget('GxActiveForm', array(
				'id' => 'category-form',
				'enableAjaxValidation' => true,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));
		?>

		<?php
			if($returnUrl = Yii::app()->user->getState('category-grid-url')){
				echo CHtml::hiddenField('returnUrl', $returnUrl);
			}
		?>

		<div id="tab-basic">
			<?php
				echo $this->renderPartial(
					'_basic',
					array(
						'form' => $form,
						'model' => $model,
					),
					true
				);
			?>
		</div>

		<?php  foreach($this->languages as $val):?>
		<div id="tab-language-<?php  echo $val['language_id']?>">
			<?php
				echo $this->renderPartial(
					'//categoryI18n/_i18n',
					array(
						'form' => $form,
						'model' => $i18ns[$val['language_id']],
						'language_id' => $val['language_id'],
					),
					true
				);
			?>
		</div>
		<?php  endforeach;?>

		<!--<div id="tab-swfupload">
			<?php
				/*
				echo $this->renderPartial(
					'_swfupload',
					array(
						'photo' => $photo,
						'photos' => $photos,
					),
					true
				);
				*/
			?>
		</div>-->

		<?php
			$this->endWidget();
		?>

	</div><!-- form -->
  </div>
</div>