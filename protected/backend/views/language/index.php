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
				$.fn.yiiGridView.update('language-grid', {
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
				<a onclick="GridViewUpdate();" class="button" style="display:none;"><?php echo Yii::t('app', 'Save')?></a>
				<a onclick="GridViewDelete();" class="button"><?php echo Yii::t('app', 'Delete')?></a>
			</div>
		</div>
		<div class="content">

		<form id="language-grid-form" action="<?php echo $this->createUrl('gridviewupdate')?>" method="post">
		<?php echo CHtml::hiddenField('returnUrl', Yii::app()->getRequest()->url)?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'language-grid',
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

		'title',
		'code',
		array(
			'type' => 'raw',
			'name' => 'image',
			'value' => 'CHtml::image($data->image, $data->title, array("width"=>"20"))',
		),
		array(
			'type' => 'raw',
			'name' => 'sort_id',
			'value' => 'CHtml::textField("edit[$data->language_id][sort_id]", $data->sort_id, array("class"=>"editable"))',
		),
		array(
			'type' => 'raw',
			'name' => 'status',
			'value' => 'CHtml::dropDownList("edit[$data->language_id][status]", $data->status, array("0"=>Yii::t("app", "No"), "1"=>Yii::t("app", "Yes")), array("class"=>"editable"))',
			'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
		),

		array(
			'header' => Yii::t('app', 'Grid Actions'),
			'class' => 'CButtonColumn',
			'deleteConfirmation' => Yii::t('app', 'Confirm Delete Language?'),
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
		url : '<?php echo $this->createUrl('gridviewdelete'); ?>'
		, postData : {returnUrl : '<?php echo Yii::app()->getRequest()->url?>'}
		, message : '<?php echo Yii::t('app', 'No results found.');?>'
	}, params || {});
	var models = new Array();
	jQuery.each(jQuery(':checkbox:not(:disabled)[name^="GridViewSelect"]:checked'), function(){
		models.push(jQuery(this).val());
	});
	if(models.length > 0){
		confirm('<?php echo Yii::t('app', 'Confirm Delete Language?')?>') && jQuery.post(params.url, jQuery.extend(params.postData || {}, {'selected[]' : models}), function(data){
			var ret = jQuery.parseJSON(data);
            if (ret != null && ret.success != null && ret.success) {
            	jQuery.fn.yiiGridView.update('language-grid');
            }
		});
	}
}
/*
 * Grid View Update
 */
function GridViewUpdate(params){
	var params = jQuery.extend({},{
		id : 'language-grid-form'
	}, params || {});
	confirm('<?php echo Yii::t('app', 'Confirm Grid View Update?')?>') && jQuery('#' + params.id).submit();
	return false;
}
</script>