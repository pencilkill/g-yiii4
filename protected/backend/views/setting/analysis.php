
<table class="form">

<?php $key = 'analysis_google'; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', 'Analysis Google'); ?></label>
	</td>
	<td>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>5, 'cols'=>50)); ?>
	</td>
</tr><!-- row -->

</table>