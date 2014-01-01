<?php

Yii::import('frontend.models._base.BaseNewsI18n');

class NewsI18n extends BaseNewsI18n
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
			'condition' => "{$alias}.status = '1'",
			'order' => "{$alias}.news_i18n_id DESC"
		));
	}

	public function i8($languageId=null){
		if(empty($languageId)){
			$languageId = Yii::app()->params->languageId;
		}

		$this->getDbCriteria()->mergeWith(array(
			'condition' => "{$this->tableAlias}.language_id=:language_id",
			'params' => array(':language_id' => $languageId),
 		));

		return $this;
	}
}