<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);

?>

<?php
$this->renderPartial('_formI18n', array(
		'model' => $model,
		'i18ns' => $i18ns,
		'categories' => $categories,
		'buttons' => 'create'
	)
);
?>