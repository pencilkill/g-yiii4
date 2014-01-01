<?php

Yii::import('frontend.models._base.BaseCategory');

class Category extends BaseCategory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
			'order' => "{$alias}.sort_id DESC, {$alias}.category_id DESC"
		));
	}
}