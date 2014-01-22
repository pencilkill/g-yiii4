<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);
?>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
	)
);
?>