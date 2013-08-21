<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>


<?php $skipColumns = array('create_time', 'update_time', 'language_id');?>

		<table class="form">
<?php foreach ($this->tableSchema->columns as $column): ?>
<?php
	if ($column->autoIncrement || in_array($column->name, $skipColumns)){
		continue;
	}
?>

		<tr>
			<td>
				<?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
			</td>
			<td>
				<?php echo "<?php " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
				<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
			</td>
		</tr><!-- row -->

<?php endforeach; ?>
		</table>
