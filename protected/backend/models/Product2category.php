<?php

Yii::import('backend.models._base.BaseProduct2category');

class Product2category extends BaseProduct2category
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
			'product_id' => null,
			'category_id' => null,
			'product' => null,
			'category' => null,
		));
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.product2category_id", $this->product2category_id);
		$criteria->compare("{$alias}.product_id", $this->product_id);
		$criteria->compare("{$alias}.category_id", $this->category_id);
		$criteria->group = "{$alias}.product2category_id";
		$criteria->together = true;


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.product2category_id ASC",
				'multiSort'=>true,
				'attributes'=>array(
					'*',
				),
			),
			'pagination' => false,
		));
	}

}