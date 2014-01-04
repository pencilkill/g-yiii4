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
				$.fn.yiiGridView.update('admin-grid', {
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
				<a onclick="GVDelete();" class="button"><?php echo Yii::t('app', 'Delete')?></a>
			</div>
		</div>
		<div class="content">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'admin-grid',
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
		'username',
		'email',
		array(
			'name' => 'status',
			'value' => '($data->status == 0) ? Yii::t(\'app\', \'No\') : Yii::t(\'app\', \'Yes\')',
			'filter' => array('0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')),
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
 function GVDelete(){
	 var params = {
			id : 'admin-grid'
			, url : '<?php echo $this->createUrl('gridviewdelete'); ?>'
			, checkBoxColumn : ':checkbox:not(:disabled)[name^="GridViewSelect"]:checked'
			, postData : {returnUrl : '<?php echo Yii::app()->getRequest()->url?>'}
			, deleteConfirmation : '<?php echo Yii::t('app', 'Confirm Grid View Delete?')?>'
			, selectNoneMessage : '<?php echo Yii::t('app', 'No results found.');?>'
			, warningMessage : '<?php echo Yii::t('app', 'Operation Failure Including Items.');?>'
		};
	 GridViewDelete(params);
 }
/*
 * Grid View Update
 */
 function GVUpdate(){
	var params = {
		id : 'admin-grid-form'
		, submitConfirmation : '<?php echo Yii::t('app', 'Confirm Grid View Update?')?>'
	};
	GridViewUpdate(params);
 }
</script>