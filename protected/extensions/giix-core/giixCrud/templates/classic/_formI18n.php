<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="form">

<?php $ajax = ($this->enable_ajax_validation) ? 'true' : 'false'; ?>

<?php echo '<?php '; ?>
$form = $this->beginWidget('GxActiveForm', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-form',
	'enableAjaxValidation' => <?php echo $ajax; ?>,
));
<?php echo '?>'; ?>

<?php echo "<?php\n"; ?>
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>array(
		Yii::t('app', 'Tabs Basic') => $this->renderPartial('_form', array('form' => $form, 'model' => $model), true),
<?php foreach($this->languages as $val):?>
		'<?php echo $val['title']?>' => $this->renderPartial('//<?php echo lcfirst($this->i18nRelation[3])?>/_i18n', array('form' => $form, 'model' => $i18ns[<?php echo $val['language_id']?>], 'language_id' => <?php echo $val['language_id']?>), true),
<?php endforeach;?>
	),
));
<?php echo '?>'; ?>

<?php echo "<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
\$this->endWidget();
?>\n"; ?>
</div><!-- form -->