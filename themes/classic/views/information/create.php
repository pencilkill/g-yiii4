<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
);
?>

<?php
$this->renderPartial('_formi18n', array(
		'model' => $model,
		'i18ns' => $i18ns,
		'buttons' => 'create'));
?>