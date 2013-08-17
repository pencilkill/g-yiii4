<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
);
?>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
	)
);
?>