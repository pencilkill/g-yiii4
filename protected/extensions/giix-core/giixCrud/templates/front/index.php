<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"?>
//$this->pageTitle = null;
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'List'),
);
?>

<?php echo '<?php'?> if(isset($this->breadcrumbs)):?>
	<?php echo '<?php'?> //$this->widget('zii.widgets.CBreadcrumbs', array('links'=>$this->breadcrumbs)); ?><!-- breadcrumbs -->
<?php echo '<?php'?> endif?>

<?php echo '<?php'?> foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
<div class="<?php echo '<?php'?> echo $key?>"><?php echo '<?php'?> echo $message?></div>
<?php echo '<?php'?> endforeach;?>


<?php echo '<?php'?> $count = 0; ?>
<ul>
<?php echo '<?php'?> foreach($model->getData() as $data) :?>

<!--<li><?php echo '<?php'?>  ?></li>-->

<?php echo '<?php'?> $count++?>
<?php echo '<?php'?> endforeach;?>
</ul>

<?php echo '<?php'?> $this->widget('ELinkPager', array('pages' => $model->getPagination()));?>