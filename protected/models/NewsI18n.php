<?php

Yii::import('frontend.models._base.BaseNewsI18n');

class NewsI18n extends BaseNewsI18n
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