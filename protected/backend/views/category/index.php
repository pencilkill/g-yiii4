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
		/*
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
		*/
	?>

	<div class="box">

		<div class="heading">
			<div class="buttons">
				<?php //echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button button', 'style' => 'display: none;')); ?>
				<a onclick="location='<?php echo $this->createUrl('create')?>';" class="button"><?php echo Yii::t('app', 'Create')?></a>
				<a onclick="GVUpdate();" class="button"><?php echo Yii::t('app', 'Save')?></a>
				<a onclick="GVDelete();" class="button"><?php echo Yii::t('app', 'Delete')?></a>
			</div>
			<div class="search-form">

			<?php

				$this->renderPartial(
					'_search',
					array(
						'model' => $model,
					)
				);

			?>

			</div><!-- search-form -->
		</div>

		<div class="content">

			<form id="category-grid-form" action="<?php echo $this->createUrl('gridviewupdate')?>" method="post">
				<?php  echo CHtml::hiddenField('returnUrl', Yii::app()->getRequest()->url)?>

				<?php
					$this->widget('zii.widgets.grid.CGridView', array(
						'id' => 'category-grid',
						'ajaxUpdate' => true,
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
					        	'name' => 'categoryI18n.title',
								'filter' => CHtml::activeTextField($model->filter->categoryI18ns, 'title'),
							),

							array(
								'name' => 'parent_id',
								'value' => 'CHtml::value($data, "parent", Yii::t("app", "None"))',
								'filter' => CHtml::activeDropDownList($model, 'parent_id', Category::model()->dropList(), array('prompt' => '')),
							),

							array(
								'type' => 'raw',
								'name' => 'sort_order',
								'value' => 'CHtml::textField("edit[$data->category_id][sort_order]", $data->sort_order, array("class"=>"editable"))',
							),

							array(
								'header' => Yii::t('app', 'Grid Actions'),
								'class' => 'CButtonColumn',
								'afterDelete' => 'function(link,success,data){var r=jQuery.parseJSON(data); if(!r || !r.success){jQuery.each(r, function(t, m){GridViewFlash(t, m); return false;});}}',
								'template' => '[ {update} ] [ {delete} ]',
								'updateButtonLabel' => Yii::t('app', 'Update'),
								'updateButtonImageUrl' => false,
								'deleteButtonLabel' => Yii::t('app', 'Delete'),
								'deleteButtonImageUrl' => false,
								'headerHtmlOptions' => array(
									'class' => 'right',
								),
								'htmlOptions' => array(
									'class' => 'right',
								),
							),
						),
					));
				?>

			</form>

		</div>
	</div>
</div>


<script type="text/javascript">
/*
 * Grid View Delete
 */
 function GVDelete(){
	 var params = {
			id : 'category-grid'
			, url : '<?php echo $this->createUrl('gridviewdelete'); ?>'
			, checkBoxColumn : ':checkbox:not(:disabled)[name^="GridViewSelect"]:checked'
			, postData : {returnUrl : '<?php echo Yii::app()->getRequest()->url?>'}
			, deleteConfirmation : '<?php echo Yii::t('app', 'Confirm Grid View Delete?')?>'
			, selectNoneMessage : '<?php echo Yii::t('app', 'No Results Found');?>'
			, warningMessage : '<?php echo Yii::t('app', 'Operation Failure');?>'
		};
	 GridViewDelete(params);
 }
/*
 * Grid View Update
 */
 function GVUpdate(){
	var params = {
		id : 'category-grid-form'
		, submitConfirmation : '<?php echo Yii::t('app', 'Confirm Grid View Update?')?>'
	};
	GridViewUpdate(params);
 }
</script>