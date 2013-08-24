<?php

Yii::import('backend.models._base.BaseContact');

class Contact extends BaseContact
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static $genderList = array(
		'0'=>'男生',
		'1'=>'女生'
	);

	public static $statusList = array(
		'0'=>'已閱讀',
		'1'=>'未閱讀'
	);
}