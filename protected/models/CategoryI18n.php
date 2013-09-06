<?php

Yii::import('frontend.models._base.BaseCategoryI18n');

class CategoryI18n extends BaseCategoryI18n
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function t($languageId=null){
		if(empty($languageId)){
			$languageId = Yii::app()->params->languageId;
		}

		$this->getDbCriteria()->mergeWith(array(
			'condition' => "{$this->tableAlias}.language_id = '{$languageId}'",
		));

		return $this;
	}
}