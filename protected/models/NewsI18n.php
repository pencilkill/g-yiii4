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
			'condition' => "{$alias}.status=:status",
			'params' => array(':status' => '1'),
			'order' => "{$alias}.news_i18n_id DESC",
		));
	}

	public function t($languageId=null){
		if(empty($languageId)){
			$languageId = Yii::app()->params->languageId;
		}

		$this->getDbCriteria()->mergeWith(array(
			'condition' => "{$this->tableAlias}.language_id=:language_id",
			'params' => array(':language_id' => $languageId),
 		));

		return $this;
	}

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.news_i18n_id";
		$criteria->together = true;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.news_i18n_id" => CSort::SORT_ASC,
				),
				'multiSort'=>true,
				'attributes'=>array(
					'*',
				),
			),
			'pagination' => false,
		));
	}
}