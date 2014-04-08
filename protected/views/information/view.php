<?php
//$this->pageTitle = null;
/*
$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	$model->informationI18ns->title,
);
*/
?>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.</p>