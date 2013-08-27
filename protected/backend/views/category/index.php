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

	<div id="messageBox">
	<?php foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
		<div class="<?php echo $key?>"><?php echo $message?></div>
	<?php endforeach;?>
	</div>

	<?php
		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
			});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('category-grid', {
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
				<a onclick="GridViewUpdate();" class="button"><?php echo Yii::t('app', 'Save')?></a>
				<a onclick="GridViewDelete();" class="button"><?php echo Yii::t('app', 'Delete')?></a>
			</div>
		</div>
		<div class="content">

		<form id="category-grid-form" action="<?php echo $this->createUrl('gridviewupdate')?>" method="post">
		<?php echo CHtml::hiddenField('returnUrl', Yii::app()->getRequest()->url)?>
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
			'headerHtmlOptions' => array(
				'width' => 1,
			),
			'checkBoxHtmlOptions' => array(
				// The value is autofill
				'name' => 'GridViewSelect[]',
			),
		),
		array(
        	'name' => 'categoryI18ns.title',
			'value' => array($this, 'columnValue'),
			'filter' => CHtml::activeTextField($model->searchI18n, 'title'),
		),
		array(
			'type' => 'raw',
			'name' => 'sort_id',
			'value' => 'CHtml::textField("edit[$data->category_id][sort_id]", $data->sort_id, array("class"=>"editable"))',
		),

		array(
			'header' => Yii::t('app', 'Grid Actions'),
			'class' => 'CButtonColumn',
			'afterDelete' => 'function(link,success,data){var r=jQuery.parseJSON(data); if(!r || !r.success){jQuery.each(r, function(t, m){GridViewFlash(t, m); return false;});}}',
			'template' => '{up}&emsp;{down}&emsp;&emsp;{update}&nbsp;{delete}',
			'buttons' => array(
				'up' => array(
					'label'=>Yii::t('app', 'Level Up'),
					'imageUrl'=>'_ozman/image/up.gif',
					'visible'=>'isset($data->parent->parent_id)',
            		'url'=>'isset($data->parent->parent_id) ? Yii::app()->createUrl("category/index", array("parent_id"=>$data->parent->parent_id)) : ""',
				),
				'down' => array(
					'label'=>Yii::t('app', 'Level Down'),
					'imageUrl'=>'_ozman/image/down.gif',
					'visible'=>'sizeOf($data->children) || sizeOf($data->product2categories)',
            		'url'=>'sizeOf($data->children) ? Yii::app()->createUrl("category/index", array("parent_id"=>$data->category_id)) : (sizeOf($data->product2categories) ? Yii::app()->createUrl("product/index", array("category_id"=>$data->category_id)) : "")',
				),
			),
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
		url : '<?php echo $this->createUrl('gridviewdelete'); ?>'
		, postData : {returnUrl : '<?php echo Yii::app()->getRequest()->url?>'}
		, message : '<?php echo Yii::t('app', 'No results found.');?>'
	}, params || {});
	var models = new Array();
	jQuery.each(jQuery(':checkbox:not(:disabled)[name^="GridViewSelect"]:checked'), function(){
		models.push(jQuery(this).val());
	});
	if(models.length > 0){
		confirm('<?php echo Yii::t('app', 'Confirm Grid View Delete?')?>') && jQuery.post(params.url, jQuery.extend(params.postData || {}, {'selected[]' : models}), function(data){
			var ret = jQuery.parseJSON(data);
            if (ret != null && ret.success != null && ret.success) {
            	jQuery.fn.yiiGridView.update('category-grid');
            }
		});
	}
}
/*
 * Grid View Update
 */
function GridViewUpdate(params){
	var params = jQuery.extend({},{
		id : 'category-grid-form'
	}, params || {});
	confirm('<?php echo Yii::t('app', 'Confirm Grid View Update?')?>') && jQuery('#' + params.id).submit();
	return false;
}
/**
 * Grid View Flash
 */
function GridViewFlash(type, message){
	if(!(type || message)) return false;

	var box = jQuery('#messageBox');
	var em = box.find('.' + type);
	var html = '<div class="' + type + '">' + message + '</div>';
	(em.length == 0 ? box.append(html) : box.children('.' + type).replaceWith(html));
	box.on('click', '.' + type, function(){jQuery(this).remove()});
	return true;
}
</script>