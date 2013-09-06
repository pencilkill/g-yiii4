<?php

Yii::import('frontend.models._base.BaseNews');

class News extends BaseNews
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		return CMap::mergeArray(parent::defaultScope(), array(
			'condition' => "{$this->getTableAlias(false, false)}.status = '1'",
		));
	}
}