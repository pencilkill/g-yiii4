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

	<?php foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
	<div class="<?php echo $key?>"><?php echo $message?></div>
	<?php endforeach;?>

	<?php
		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
			});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('news-grid', {
					data: $(this).serialize()
				});
				return false;
			});
		");
	?>

	<div class="box">
		<div class="search-form" style="display:none;">
		<?php $this->renderPartial('_search', array(
			'model' => $model,
		)); ?>
		</div><!-- search-form -->
		<div class="heading">
			<div class="buttons">
				<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button button', 'style' => 'display: none;')); ?>
				<a onclick="location='<?php echo $this->createUrl('create')?>';" class="button"><?php echo Yii::t('app', 'Create')?></a>
				<a onclick="GridViewDelete();" class="button"><?php echo Yii::t('app', 'Delete')?></a>
			</div>
		</div>
		<div class="content">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'news-grid',
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
		array(
			'name' => 'newsI18ns.title',
			'value' => array($this, 'columnValue'),
			'filter' => CHtml::activeTextField($model->searchI18n, 'title'),
		),
		'sort_id',
		array(
			'name' => 'top',
			'value' => '($data->top == 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
			'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
		),
		'sort_id',
		array(
			'name' => 'status',
			'value' => '($data->status == 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
			'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
		),
		'date_added',
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
            	jQuery.fn.yiiGridView.update('news-grid');
            }
		});
	}
}
</script>