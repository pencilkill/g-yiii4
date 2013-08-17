<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 * - $form: the active form object
 * - $language_id: the language_id
 */
?>
<div class="form">

<?php $skipColumns = array('create_time', 'update_time', 'language_id');?>

<?php foreach ($this->tableSchema->columns as $column): ?>

<?php
	if ($column->autoIncrement || $column->isForeignKey || in_array($column->name, $skipColumns)){
		continue;
	}
?>
		<div class="row">
		<?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
		<?php echo "<?php " . $this->generateActiveFieldI18n($this->modelClass, $column) . "; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model, \"[\$language_id]{$column->name}\"); ?>\n"; ?>
		</div><!-- row -->

<?php endforeach; ?>


</div><!-- form -->