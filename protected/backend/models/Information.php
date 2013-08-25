<?php

Yii::import('backend.models._base.BaseInformation') ;

class Information extends BaseInformation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}