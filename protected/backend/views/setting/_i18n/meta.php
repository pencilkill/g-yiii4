
		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Meta Title'); ?>
		</label>
		<?php $key = "meta_title_{$language_id}"; ?>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>3, 'cols'=>50)); ?>
		</div><!-- row -->


		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Meta Keywords'); ?>
		</label>
		<?php $key = "meta_keywords_{$language_id}"; ?>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>5, 'cols'=>50)); ?>
		</div><!-- row -->


		<div class="row">
		<label>
		<?php echo Yii::t('setting', 'Meta Description'); ?>
		</label>
		<?php $key = "meta_description_{$language_id}"; ?>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>10, 'cols'=>50)); ?>
		</div><!-- row -->

