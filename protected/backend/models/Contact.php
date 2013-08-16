<?php

Yii::import('backend.models._base.BaseContact');

class Contact extends BaseContact
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}