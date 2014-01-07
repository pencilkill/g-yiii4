<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 * - $form: the active form object
 * - $language_id: the language_id
 */
?>
<?php
	/**
	 * check zii.behavior.CTimestampBehavior for create_time, update_time
	 */
	$skipColumns = array('create_time', 'update_time', GiixModelCode::I18N_LANGUAGE_COLUMN_NAME);
?>
		<table class="form">
<?php foreach ($this->tableSchema->columns as $column): ?>
<?php
	if ($column->autoIncrement || $column->isForeignKey || in_array($column->name, $skipColumns)){
		continue;
	}
?>
		<tr>
			<td>
				<?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
			</td>
			<td>
				<?php echo "<?php " . $this->generateActiveI18nField($this->modelClass, $column) . "; ?>\n"; ?>
				<?php echo "<?php echo \$form->error(\$model, \"[\$" . GiixModelCode::I18N_LANGUAGE_COLUMN_NAME . "]{$column->name}\"); ?>\n"; ?>
			</td>
		</tr><!-- row -->
		
<?php endforeach; ?>
		
		<tr style="display:none; visibility: hidden; height: 0px;">
			<td>
				<?php echo "<?php echo \$form->labelEx(\$model, \"[\$" . GiixModelCode::I18N_LANGUAGE_COLUMN_NAME . "]" . GiixModelCode::I18N_LANGUAGE_COLUMN_NAME . "\"); ?>\n"; ?>
			</td>
			<td>
				<?php echo "<?php echo \$form->hiddenField(\$model, \"[\$" . GiixModelCode::I18N_LANGUAGE_COLUMN_NAME . "]" . GiixModelCode::I18N_LANGUAGE_COLUMN_NAME . "\"); ?>\n"; ?>
				<?php echo "<?php echo \$form->error(\$model, \"[\$" . GiixModelCode::I18N_LANGUAGE_COLUMN_NAME . "]" . GiixModelCode::I18N_LANGUAGE_COLUMN_NAME . "\"); ?>\n"; ?>
			</td>
		</tr><!-- row -->
		
		</table>
