<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);
?>

<?php
$this->renderPartial(
	'_formI18n',
	array(
		'model' => $model,
		'i18ns' => $i18ns,
		'gallery' => $gallery,
		'galleries' => $galleries,
		'p2c' => $p2c,
		'p2cs' => $p2cs,
	)
);
?>