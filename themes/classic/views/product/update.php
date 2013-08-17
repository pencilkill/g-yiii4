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
$this->renderPartial('_formI18n', array(
		'model' => $model,
		'i18ns' => $i18ns,
		'gallery' => $gallery,
		'galleries' => $galleries,
		'categories' => $categories,
		'categoryIds' => $categoryIds,
	)
);
?>