
<table class="form">

<?php $key = "meta_title_{$language_id}"; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', ucwords(strtr($key, array("_{$language_id}" => '', '_' => ' ')))); ?></label>
	</td>
	<td>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>3, 'cols'=>50)); ?>
	</td>
</tr><!-- row -->

<?php $key = "meta_keywords_{$language_id}"; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', ucwords(strtr($key, array("_{$language_id}" => '', '_' => ' ')))); ?></label>
	</td>
	<td>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>5, 'cols'=>50)); ?>
	</td>
</tr><!-- row -->

<?php $key = "meta_description_{$language_id}"; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', ucwords(strtr($key, array("_{$language_id}" => '', '_' => ' ')))); ?></label>
	</td>
	<td>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>10, 'cols'=>50)); ?>
	</td>
</tr><!-- row -->

</table>