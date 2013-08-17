<?php

$this->breadcrumbs = array(
	Yii::t('setting', 'Setting') => array('index'),
	Yii::t('setting', 'Update'),
);

$settingMenu = array(
	'meta' => Yii::t('setting', 'Meta'),
	'mail' => Yii::t('setting', 'Mail'),
	'analysis' => Yii::t('setting', 'Analysis'),
);

$this->menu = array(
	array('label' => Yii::t('setting', 'Meta'), 'url' => array('index', 'group' => 'meta')),
	array('label' => Yii::t('setting', 'Mail'), 'url' => array('index', 'group' => 'mail')),
	array('label' => Yii::t('setting', 'Analysis'), 'url' => array('index', 'group' => 'analysis')),
);

$this->renderPartial($group, array(
	//
));

?>