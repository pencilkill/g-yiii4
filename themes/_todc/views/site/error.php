<?php

$this->breadcrumbs = array(
	Yii::t('error', 'Error Page'),
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

	<div class="box">
		<div class="content">
			<h2><?php echo $code?></h2>

			<div class="error">
				<?php echo CHtml::encode($message); ?>
			</div>

		</div>
	</div>
</div>
<style type="text/css">
.box {
	border: 1px solid #ccc;
}
.content {
	margin: 20px;
	border: 1px solid #ccc;
}
</style>