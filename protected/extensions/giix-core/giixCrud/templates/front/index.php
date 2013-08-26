<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
	$updateColumns = array('top', 'sort_id', 'status');

	$skipColumns = array('create_time', 'update_time', 'password', 'lang');
?>
<?php
echo "<?php\n
\$this->breadcrumbs = array(
	\$model->label(2) => array('index'),
	Yii::t('app', 'List'),
);\n";
?>

?>
<div id="content">
	<div class="breadcrumb">
	<?php echo '<?php'?> if(isset($this->breadcrumbs)):?>
		<?php echo '<?php'?> $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php echo '<?php'?> endif?>
	</div>

	<?php echo '<?php'?> foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
	<div class="<?php echo '<?php'?> echo $key?>"><?php echo '<?php'?> echo $message?></div>
	<?php echo '<?php'?> endforeach;?>

	<?php echo "<?php\n"?>
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

	<div class="box">
		<div class="search-form" style="display:none;">
		<?php echo "<?php \$this->renderPartial('_search', array(
			'model' => \$model,
		)); ?>\n"; ?>
		</div><!-- search-form -->
		<div class="heading">
			<div class="buttons">
				<?php echo '<?php'?> echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button button', 'style' => 'display: none;')); ?>
				<a onclick="location='<?php echo '<?php'?> echo $this->createUrl('create')?>';" class="button"><?php echo '<?php'?> echo Yii::t('app', 'Create')?></a>
				<a onclick="GridViewUpdate();" class="button" <?php if(array_intersect($updateColumns, array_keys($this->tableSchema->columns))):?>style="display:none;"<?php endif;?>><?php echo '<?php'?> echo Yii::t('app', 'Save')?></a>
				<a onclick="GridViewDelete();" class="button"><?php echo '<?php'?> echo Yii::t('app', 'Delete')?></a>
			</div>
		</div>
		<div class="content">

		<form id="<?php echo $this->class2id($this->modelClass)?>-grid-form" action="<?php echo '<?php'?> echo $this->createUrl('<?php echo strtolower($this->gridViewEditAction)?>')?>" method="post">
		<?php echo '<?php' ?> echo CHtml::hiddenField('returnUrl', Yii::app()->getRequest()->url)?>
<?php echo '<?php'; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id' => '<?php echo $this->class2id($this->modelClass)?>-grid',
	'template' => "{items}\n<div class=\"pagination\">{summary}{pager}</div>",
	'itemsCssClass' => 'list',
	'filterCssClass' => 'filter',
	'summaryCssClass' => 'results',
	'pagerCssClass' => 'links',
	'htmlOptions' => array(
		'class' => ''
	),
	'cssFile' => false,
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array(
			'selectableRows' => 2,
			'class' => 'CCheckBoxColumn',
			'headerHtmlOptions' => array(
				'width' => 1,
			),
			'checkBoxHtmlOptions' => array(
				// The value is autofill
				'name' => 'GridViewSelect[]',
			),
		),

<?php if($this->i18nRelation){?>
		array(
        	'name' => '<?php echo $this->i18nRelation[0]?>.title',
			'value' => array($this, 'columnValue'),
			'filter' => CHtml::activeTextField($model->searchI18n, 'title'),
		),
<?php }?>
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
	if ($column->autoIncrement || in_array($column->name, $skipColumns)){
		continue;
	}
	if (++$count == 7){
		echo "\t\t/*\n";
	}
	echo "\t\t" . $this->generateGridViewColumn($this->modelClass, $column, in_array($column->name, $updateColumns)).",\n";
}
if ($count >= 7){
	echo "\t\t*/\n";
}
?>

		array(
			'header' => Yii::t('app', 'Grid Actions'),
			'class' => 'CButtonColumn',
			'template' => '{update}&nbsp;{delete}',
		),
	),
)); ?>

		</form>

		</div>
	</div>
</div>


<script type="text/javascript">
/*
 * Grid View Delete
 */
function GridViewDelete(params){
	var params = jQuery.extend({},{
		url : '<?php echo "<?php" ?> echo $this->createUrl('gridviewdelete'); ?>'
		, postData : {returnUrl : '<?php echo '<?php'?> echo Yii::app()->getRequest()->url?>'}
		, message : '<?php echo "<?php" ?> echo Yii::t('app', 'No results found.');?>'
	}, params || {});
	var models = new Array();
	jQuery.each(jQuery(':checkbox:not(:disabled)[name^="GridViewSelect"]:checked'), function(){
		models.push(jQuery(this).val());
	});
	if(models.length > 0){
		confirm('<?php echo "<?php" ?> echo Yii::t('app', 'Confirm Grid View Delete?')?>') && jQuery.post(params.url, jQuery.extend(params.postData || {}, {'selected[]' : models}), function(data){
			var ret = jQuery.parseJSON(data);
            if (ret != null && ret.success != null && ret.success) {
            	jQuery.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid');
            }
		});
	}
}
/*
 * Grid View Update
 */
function GridViewUpdate(params){
	var params = jQuery.extend({},{
		id : '<?php echo $this->class2id($this->modelClass)?>-grid-form'
	}, params || {});
	confirm('<?php echo "<?php" ?> echo Yii::t('app', 'Confirm Grid View Update?')?>') && jQuery('#' + params.id).submit();
	return false;
}
</script>