<?php

Yii::import('backend.models._base.BaseNewsI18n');

class NewsI18n extends BaseNewsI18n
{

	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function behaviors() {
		return CMap::mergeArray(parent::behaviors(), array(
        ));
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'news_id' => null,
			'language_id' => null,
			'news' => null,
			'language' => null,
		));
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.news_i18n_id", $this->news_i18n_id);
		$criteria->compare("{$alias}.news_id", $this->news_id);
		$criteria->compare("{$alias}.language_id", $this->language_id);
		$criteria->compare("{$alias}.status", $this->status);
		$criteria->compare("{$alias}.pic", $this->pic, true);
		$criteria->compare("{$alias}.title", $this->title, true);
		$criteria->compare("{$alias}.keywords", $this->keywords, true);
		$criteria->compare("{$alias}.description", $this->description, true);
		$criteria->group = "{$alias}.news_i18n_id";
		$criteria->together = true;


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.news_i18n_id ASC",
				'multiSort'=>true,
				'attributes'=>array(
					'*',
				),
			),
			'pagination' => false,
		));
	}


	public function t($language_id = null){
		$language_id = empty($language_id) ? Yii::app()->controller->language_id : $language_id;

		$this->getDbCriteria()->mergeWith(array(
			'condition' => "{$this->tableAlias}.language_id= '{$language_id}'",
		));

		return $this;
	}
}