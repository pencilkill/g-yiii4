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

  <?php echo '<?php'?> foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
	<div class="<?php echo '<?php'?> echo $key?>"><?php echo '<?php'?> echo $message?></div>
  <?php echo '<?php'?> endforeach;?>

  <div class="box">
    <div class="heading">
      <div class="buttons">
      	<a onclick="$('#<?php echo $this->class2id($this->modelClass); ?>-form').submit();" class="button"><?php echo '<?php '; ?> echo Yii::t('app', 'Save'); ?></a>
      	<a onclick="location = '<?php echo '<?php '; ?> echo $this->createUrl('index', array()); ?>';" class="button"><?php echo '<?php '; ?> echo Yii::t('app', 'Cancel'); ?></a>
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

<?php $skipColumns = array('create_time', 'update_time', 'language_id');?>

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