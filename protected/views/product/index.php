<?php
//$this->pageTitle = null;
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'List'),
);
?>

<?php if(isset($this->breadcrumbs)):?>
	<?php //$this->widget('zii.widgets.CBreadcrumbs', array('links'=>$this->breadcrumbs)); ?><!-- breadcrumbs -->
<?php endif?>

<?php foreach(Yii::app()->user->getFlashes() as $key => $message) :?>
<div class="<?php echo $key?>"><?php echo $message?></div>
<?php endforeach;?>


<?php $count = 0; ?>
<ul>
<?php foreach($model->getData() as $data) :?>

<!--<li><?php  ?></li>-->

<?php $count++?>
<?php endforeach;?>
</ul>

<?php $this->widget('CLinkPager', array('pages' => $model->getPagination()));?>