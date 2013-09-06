<?php

/**
 * This is the model base class for the table "product2category".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Product2category".
 *
 * Columns in table "product2category" available as properties of the model,
 * followed by relations of table "product2category" available as properties of the model.
 *
 * @property integer $product2category_id
 * @property integer $product_id
 * @property integer $category_id
 *
 * @property Product $product
 * @property Category $category
 */
abstract class BaseProduct2category extends GxActiveRecord {


	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'product2category';
	}

	public static function label($n = 1) {
		return Yii::t('M/product2category', 'Product2category|Product2categories', $n);
	}

	public static function representingColumn() {
		return 'product2category_id';
	}

	public function rules() {
		return array(
			array('product_id, category_id', 'required'),
			array('product_id, category_id', 'numerical', 'integerOnly'=>true),
			array('product2category_id, product_id, category_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'product2category_id' => Yii::t('M/product2category', 'Product2category'),
			'product_id' => null,
			'category_id' => null,
			'product' => null,
			'category' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('product2category_id', $this->product2category_id);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('category_id', $this->category_id);


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'attributes'=>array(
					'*',
				),
			),
		));
	}

}