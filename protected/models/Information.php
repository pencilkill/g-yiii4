<?php

Yii::import('frontend.models._base.BaseInformation');

class Information extends BaseInformation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
			'condition' => "{$alias}.status=:status",
			'params' => array(':status' => 1),
			'order' => "{$alias}.sort_id DESC, {$alias}.information_id DESC"
		));
	}
}