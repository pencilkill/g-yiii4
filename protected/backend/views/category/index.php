<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'List'),
);

?>
<div id="content">
	<div class="breadcrumb">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	</div>
	<div class="box">
		<div class="heading">
			<div class="buttons">
				<a onclick="location='<?php echo $this->createUrl('create')?>';" class="button"><?php echo Yii::t('app', 'Create')?></a>
				<a onclick="GridViewDelete();" class="button"><?php echo Yii::t('app', 'Delete')?></a>
			</div>
		</div>
		<div class="content">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'category-grid',
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
			'checkBoxHtmlOptions' => array(
				// The value is autofill
				'name' => 'GridViewSelect[]',
			),
			'htmlOptions' => array(
				'width' => 1,
			),
		),
		array(
        	'name' => 'categoryI18ns.title',
			'value' => array($this, 'columnValue'),
			'filter' => CHtml::activeTextField($model->searchI18n, 'title'),
		),
		array(
			'name' => 'top',
			'value' => '($data->top == 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
			'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
		),
		'sort_id',
		array(
	        'class'=>'CLinkColumn',
	        'header'=>Yii::t('app', 'Sub Categories'),
	        'label'=>Yii::t('app', 'View'),
	        'urlExpression'=>'"backend.php?r=category/index&parent_id=".$data->category_id',
		),
		array(
			'header' => Yii::t('app', 'Grid Actions'),
			'class' => 'CButtonColumn',
			'template' => '{update}&nbsp;{delete}',
		),
	),
)); ?>


		</div>
	</div>
</div>


<script type="text/javascript">
/*
 * Grid View Delete
 */
function GridViewDelete(params){
	var params = jQuery.extend({},{
		url : '<?php echo $this->createUrl('gridviewdelete'); ?>'
		, message : '<?php echo Yii::t('app', 'No results found.');?>'
	}, params);
	var models = new Array();
	jQuery.each(jQuery(':checkbox:not(:disabled)[name^="GridViewSelect"]:checked'), function(){
		models.push(jQuery(this).val());
	});
	if(models.length > 0){
		confirm('<?php echo Yii::t('app', 'Confirm Grid View Delete?')?>') && jQuery.post(params.url, {'selected[]' : models}, function(data){
			var ret = $.parseJSON(data);
            if (ret != null && ret.success != null && ret.success) {
            	jQuery.fn.yiiGridView.update('category-grid');
            }
		});
	}
}
</script>