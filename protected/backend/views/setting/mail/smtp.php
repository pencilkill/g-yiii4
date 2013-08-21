
<table class="form">

<?php $key = 'mail_smtp_host'; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', ucwords(strtr($key, array('_' => ' ')))); ?></label>
	</td>
	<td>
		<?php echo CHtml::textField("Setting[{$key}]", Yii::app()->config->get($key)); ?>
	</td>
</tr><!-- row -->

<?php $key = 'mail_smtp_user'; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', ucwords(strtr($key, array('_' => ' ')))); ?></label>
	</td>
	<td>
		<?php echo CHtml::textField("Setting[{$key}]", Yii::app()->config->get($key)); ?>
	</td>
</tr><!-- row -->

<?php $key = 'mail_smtp_password'; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', ucwords(strtr($key, array('_' => ' ')))); ?></label>
	</td>
	<td>
		<?php echo CHtml::textField("Setting[{$key}]", Yii::app()->config->get($key)); ?>
	</td>
</tr><!-- row -->

<?php $key = 'mail_smtp_port'; ?>
<tr>
	<td>
		<label><?php echo Yii::t('setting', ucwords(strtr($key, array('_' => ' ')))); ?></label>
	</td>
	<td>
		<?php echo CHtml::textField("Setting[{$key}]", Yii::app()->config->get($key)); ?>
	</td>
</tr><!-- row -->

</table>