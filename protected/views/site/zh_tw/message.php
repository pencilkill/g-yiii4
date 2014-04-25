<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Message';
$this->breadcrumbs=array(
	'Message',
);
?>

<?php foreach(Yii::app()->user->getFlashes() as $key => $message){?>
<div class="<?php echo $key?>">
<?php echo $message; ?>
</div>
<?php }?>