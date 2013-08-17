<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n
\$this->breadcrumbs = array(
	\$model->label(2) => array('index'),
	Yii::t('app', 'List'),
);\n";
?>

$this->menu = array(
		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo "<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>"; ?>

<div class="search-form" style="display:none;">
<?php echo "<?php \$this->renderPartial('_search', array(
	'model' => \$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo '<?php'; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array(
			'selectableRows' => 2,
			'footer' => CHtml::button(Yii::t('app', 'Grid View Delete'), array(
				'onclick' => 'GridViewDelete();',
			)),
			'class' => 'CCheckBoxColumn',
			'checkBoxHtmlOptions' => array(
				// The value is autofill
				'name' => 'GridViewSelect[]',
			),
			'htmlOptions' => array(
				'style' => 'text-align:center;',
			),
		),

<?php

$skipColumns = array('create_time', 'update_time', 'password', 'lang');

$count = 0;
foreach ($this->tableSchema->columns as $column) {
	if ($column->autoIncrement || in_array($column->name, $skipColumns)){
		continue;
	}
	if (++$count == 7)
		echo "\t\t/*\n";
	echo "\t\t" . $this->generateGridViewColumn($this->modelClass, $column).",\n";
}
if ($count >= 7)
	echo "\t\t*/\n";
?>
		array(
			'header' => Yii::t('app', 'Grid Actions'),
			'class' => 'CButtonColumn',
			'template' => '{update}{delete}',
		),
	),
)); ?>

<script type="text/javascript">
/*
 * Grid View Delete
 */
function GridViewDelete(params){
	var params = jQuery.extend({},{
		url : '<?php echo "<?php" ?> echo $this->createUrl('gridviewdelete'); ?>'
		, message : '<?php echo "<?php" ?> echo Yii::t('app', 'No results found.');?>'
	}, params);
	var models = new Array();
	jQuery.each(jQuery(':checkbox:not(:disabled)[name^="GridViewSelect"]:checked'), function(){
		models.push(jQuery(this).val());
	});
	if(models.length > 0){
		confirm('<?php echo "<?php" ?> echo Yii::t('app', 'Confirm Grid View Delete?')?>') && jQuery.post(params.url, {'selected[]' : models}, function(data){
			var ret = $.parseJSON(data);
            if (ret != null && ret.success != null && ret.success) {
            	jQuery.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid');
            }
		});
	}
}
</script>