<?php

Yii::import('backend.models._base.BaseSetting');

class Setting extends BaseSetting
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}