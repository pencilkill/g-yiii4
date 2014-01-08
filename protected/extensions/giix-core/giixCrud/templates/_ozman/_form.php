<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
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

  <div class="box">
    <div class="heading">
      <div class="buttons">
      	<a onclick="$('#<?php echo $this->class2id($this->modelClass); ?>-form').submit();" class="button"><?php echo '<?php '; ?> echo Yii::t('app', 'Save'); ?></a>
      	<?php echo '<?php '; ?>if($returnUrl = Yii::app()->user->getState('<?php echo $this->class2id($this->modelClass)?>-grid-url')):?>
		<a onclick="location = '<?php echo '<?php '; ?> echo $returnUrl; ?>';" class="button"><?php echo '<?php '; ?> echo Yii::t('app', 'Cancel'); ?></a>
		<?php echo '<?php '; ?>;else:?>
		<a onclick="location = '<?php echo '<?php '; ?> echo $this->createUrl('index', array()); ?>';" class="button"><?php echo '<?php '; ?> echo Yii::t('app', 'Cancel'); ?></a>
		<?php echo '<?php '; ?>endif;?>
      </div>
    </div>
    <div class="content">

<?php $ajax = ($this->enable_ajax_validation) ? 'true' : 'false'; ?>
	<?php echo '<?php'; ?>

		$form = $this->beginWidget('GxActiveForm', array(
			'id' => '<?php echo $this->class2id($this->modelClass); ?>-form',
			'enableAjaxValidation' => <?php echo $ajax; ?>,
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
	<?php echo '?>'; ?>


	<?php echo '<?php '; ?>

		if($returnUrl = Yii::app()->user->getState('<?php echo $this->class2id($this->modelClass)?>-grid-url')){
			echo CHtml::hiddenField('returnUrl', $returnUrl);
		}
	<?php echo '?>'; ?>

<?php $skipColumns = array('create_time', 'update_time', GiixModelCode::I18N_LANGUAGE_COLUMN_NAME);?>

		<table class="form">
<?php foreach ($this->tableSchema->columns as $column): ?>
<?php
	if ($column->autoIncrement || in_array($column->name, $skipColumns)){
		continue;
	}
?>

		<tr>
			<td>
				<?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
			</td>
			<td>
				<?php echo "<?php " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
				<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
			</td>
		</tr><!-- row -->
<?php endforeach; ?>

		</table>

	<?php echo '<?php'?>

		$this->endWidget();
	?>
	</div><!-- form -->
  </div>
</div>