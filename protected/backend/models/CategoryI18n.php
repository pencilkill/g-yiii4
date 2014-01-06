<?php

Yii::import('backend.models._base.BaseCategoryI18n');

class CategoryI18n extends BaseCategoryI18n
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function t($language_id = null){
		$language_id = empty($language_id) ? Yii::app()->controller->language_id : $language_id;

		$this->getDbCriteria()->mergeWith(array(
			'condition' => "{$this->tableAlias}.language_id= '{$language_id}'",
		));

		return $this;
	}
}