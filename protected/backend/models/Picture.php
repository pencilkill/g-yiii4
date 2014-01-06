<?php

Yii::import('backend.models._base.BasePicture');

class Picture extends BasePicture
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}