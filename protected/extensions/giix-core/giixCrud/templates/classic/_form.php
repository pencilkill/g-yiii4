<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="form">

<?php if(!$this->i18nRelation):?>

<?php $ajax = ($this->enable_ajax_validation) ? 'true' : 'false'; ?>

<?php echo '<?php '; ?>
$form = $this->beginWidget('GxActiveForm', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-form',
	'enableAjaxValidation' => <?php echo $ajax; ?>,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
<?php echo '?>'; ?>

<?php endif;?>

<?php $skipColumns = array('create_time', 'update_time', 'language_id');?>

<?php foreach ($this->tableSchema->columns as $column): ?>

<?php
	if ($column->autoIncrement || in_array($column->name, $skipColumns)){
		continue;
	}
?>

		<div class="row">
		<?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
		<?php echo "<?php " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
		</div><!-- row -->
<?php endforeach; ?>

<?php if(!$this->i18nRelation):?>

<?php echo "<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
\$this->endWidget();
?>\n"; ?>
<?php endif;?>

</div><!-- form -->