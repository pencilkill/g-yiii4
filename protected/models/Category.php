<?php

Yii::import('frontend.models._base.BaseCategory');

class Category extends BaseCategory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}