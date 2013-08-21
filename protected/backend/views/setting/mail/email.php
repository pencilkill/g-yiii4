
<table class="form">

<?php $key = 'mail_email_contact'; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', ucwords(strtr($key, array('_' => ' ')))); ?></label>
	</td>
	<td>
		<?php echo CHtml::textArea("Setting[{$key}]", Yii::app()->config->get($key), array('rows'=>5, 'cols'=>50)); ?>
	</td>
</tr><!-- row -->

</table>