<?php

Yii::import('backend.models._base.BaseProductImage');

class ProductImage extends BaseProductImage
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
			'product' => null,
		));
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.product_image_id", $this->product_image_id);
		$criteria->compare("{$alias}.product_id", $this->product_id);
		$criteria->compare("{$alias}.pic", $this->pic, true);
		$criteria->group = "{$alias}.product_image_id";
		$criteria->together = true;


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.product_image_id ASC",
				'multiSort'=>true,
				'attributes'=>array(
					'*',
				),
			),
			'pagination' => array(
				'pageSize' => Yii::app()->request->getParam('pageSize', 10),
				'pageVar' => 'page',
			),
		));
	}

}