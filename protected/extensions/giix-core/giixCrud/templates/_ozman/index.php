<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
	$updateColumns = array('top', 'sort_order', 'status');

	$skipColumns = array('create_time', 'update_time', 'password', GiixModelCode::I18N_LANGUAGE_COLUMN_NAME);
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

	<div id="messageBox">
	<?php echo '<?php'?> foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
		<div class="<?php echo '<?php'?> echo $key?>"><?php echo '<?php'?> echo $message?></div>
	<?php echo '<?php'?> endforeach;?>
	</div>

	<?php echo "<?php\n"?>
		/*
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
		*/
	?>

	<div class="box">
		<div class="search-form" style="display:none;">

		<?php echo "<?php\n"?>
			/*
			$this->renderPartial(
				'_search',
				array(
					'model' => $model,
				)
			);
			*/
		?>

		</div><!-- search-form -->

		<div class="heading">
			<div class="buttons">
				<?php echo '<?php'?> echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button button', 'style' => 'display: none;')); ?>
				<a onclick="location='<?php echo '<?php'?> echo $this->createUrl('create')?>';" class="button"><?php echo '<?php'?> echo Yii::t('app', 'Create')?></a>
				<a onclick="GVUpdate();" class="button"><?php echo '<?php'?> echo Yii::t('app', 'Save')?></a>
				<a onclick="GVDelete();" class="button"><?php echo '<?php'?> echo Yii::t('app', 'Delete')?></a>
			</div>
		</div>

		<div class="content">

			<form id="<?php echo $this->class2id($this->modelClass)?>-grid-form" action="<?php echo '<?php'?> echo $this->createUrl('<?php echo strtolower($this->gridViewEditAction)?>')?>" method="post">
				<?php echo '<?php ' ?> echo CHtml::hiddenField('returnUrl', Yii::app()->getRequest()->url)?>

				<?php echo '<?php '; ?>

					$this->widget('zii.widgets.grid.CGridView', array(
						'id' => '<?php echo $this->class2id($this->modelClass)?>-grid',
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
					<?php if($this->i18n){?>

							array(
					        	'name' => '<?php echo $this->i18n->relationName?>.title',
								'filter' => CHtml::activeTextField($model->filter-><?php echo $this->i18n->relationNamePluralized?>, 'title'),
							),
					<?php }?>
					<?php $count = 0;?>
					<?php foreach ($this->tableSchema->columns as $column) {?>
						<?php
							if ($column->autoIncrement || in_array($column->name, $skipColumns)){
								continue;
							}
						?>
							<?php if (++$count == 7){ ?>

							<?php echo "/**\n";?>
							<?php }?>

							<?php echo $this->generateGridViewColumn($this->modelClass, $column, in_array($column->name, $updateColumns)).",\n";?>
					<?php }?>
							<?php if ($count >= 7){ ?>

							<?php echo "*/\n";?>
							<?php }?>

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
			id : '<?php echo $this->class2id($this->modelClass)?>-grid'
			, url : '<?php echo '<?php'; ?> echo $this->createUrl('gridviewdelete'); ?>'
			, checkBoxColumn : ':checkbox:not(:disabled)[name^="GridViewSelect"]:checked'
			, postData : {returnUrl : '<?php echo '<?php'; ?> echo Yii::app()->getRequest()->url?>'}
			, deleteConfirmation : '<?php echo '<?php'; ?> echo Yii::t('app', 'Confirm Grid View Delete?')?>'
			, selectNoneMessage : '<?php echo '<?php'; ?> echo Yii::t('app', 'No Results Found');?>'
			, warningMessage : '<?php echo '<?php'; ?> echo Yii::t('app', 'Operation Failure');?>'
		};
	 GridViewDelete(params);
 }
/*
 * Grid View Update
 */
 function GVUpdate(){
	var params = {
		id : '<?php echo $this->class2id($this->modelClass)?>-grid-form'
		, submitConfirmation : '<?php echo '<?php'; ?> echo Yii::t('app', 'Confirm Grid View Update?')?>'
	};
	GridViewUpdate(params);
 }
</script>