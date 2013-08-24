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
				$.fn.yiiGridView.update('contact-grid', {
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
				<a onclick="GridViewUpdate();" class="button"><?php echo Yii::t('app', 'Save')?></a>
				<a onclick="GridViewDelete();" class="button"><?php echo Yii::t('app', 'Delete')?></a>
			</div>
		</div>
		<div class="content">

		<form id="contact-grid-form" action="<?php echo $this->createUrl('gridviewupdate')?>" method="post">
		<?php echo CHtml::hiddenField('returnUrl', Yii::app()->getRequest()->url)?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'contact-grid',
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

		'name',
		'email',
		'telphone',
		array(
			'type' => 'raw',
			'name' => 'status',
			'value' => 'CHtml::dropDownList("edit[$data->contact_id][status]", $data->status, Contact::$statusList, array("class"=>"editable"))',
			'filter' => Contact::$statusList,
		),

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
		url : '<?php echo $this->createUrl('gridviewdelete'); ?>'
		, postData : {returnUrl : <?php echo '<?php'?> echo Yii::app()->getRequest()->url?>}
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
            	jQuery.fn.yiiGridView.update('contact-grid');
            }
		});
	}
}
/*
 * Grid View Update
 */
function GridViewUpdate(params){
	var params = jQuery.extend({},{
		id : 'contact-grid-form'
	}, params || {});
	confirm('<?php echo Yii::t('app', 'Confirm Grid View Update?')?>') && jQuery('#' + params.id).submit();
	return false;
}
</script>