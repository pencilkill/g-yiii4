<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="wide form buttons">

<?php echo "<?php \$form = \$this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl(\$this->route),
	'method' => 'get',
)); ?>\n"; ?>

<?php $skipColumns = array('password', 'create_time', 'update_time')?>

<?php foreach($this->tableSchema->columns as $column): ?>

<?php
	if ($column->autoIncrement || in_array($column->name, $skipColumns)){
		continue;
	}
?>

	<div class="row">
		<?php echo "<?php echo \$form->label(\$model, '{$column->name}'); ?>\n"; ?>
		<?php echo "<?php " . $this->generateSearchField($this->modelClass, $column)."; ?>\n"; ?>
	</div>

<?php endforeach; ?>
	<div class="row">
		<?php echo "<?php echo GxHtml::linkButton(Yii::t('app', 'Search'), array('class' => 'button')); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- search-form -->
