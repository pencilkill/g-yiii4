<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Create'),
);

?>

<?php
$this->renderPartial(
	'_form',
	array(
		'model' => $model,
	)
);
?>