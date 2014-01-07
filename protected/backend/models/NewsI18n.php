<?php

Yii::import('backend.models._base.BaseNewsI18n');

class NewsI18n extends BaseNewsI18n
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