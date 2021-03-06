<?php

/**
 * This is the model base class for the table "product".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Product".
 *
 * Columns in table "product" available as properties of the model,
 * followed by relations of table "product" available as properties of the model.
 *
 * @property integer $product_id
 * @property integer $sort_order
 * @property string $price
 * @property string $create_time
 * @property string $update_time
 *
 * @property Product2category[] $product2categories
 * @property ProductI18n $productI18n
 * @property ProductI18n[] $productI18ns
 * @property ProductImage[] $productImages
 */
abstract class BaseProduct extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'product';
	}

	public static function label($n = 1) {
		return Yii::t('m/product', 'Product|Products', $n);
	}

	public static function representingColumn() {
		return 'price';
	}

	public function rules() {
		return array(
			array('sort_order', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			array('create_time, update_time', 'safe'),
			array('sort_order, price, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('product_id, sort_order, price, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'product2categories' => array(self::HAS_MANY, 'Product2category', 'product_id'),
			'productI18n' => array(self::HAS_ONE, 'ProductI18n', 'product_id', 'scopes' => array('t' => array())),
			'productI18ns' => array(self::HAS_MANY, 'ProductI18n', 'product_id', 'index' => 'language_id'),
			'productImages' => array(self::HAS_MANY, 'ProductImage', 'product_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'product_id' => Yii::t('m/product', 'Product'),
			'sort_order' => Yii::t('m/product', 'Sort Order'),
			'price' => Yii::t('m/product', 'Price'),
			'create_time' => Yii::t('m/product', 'Create Time'),
			'update_time' => Yii::t('m/product', 'Update Time'),
			'product2categories' => null,
			'productI18ns' => null,
			'productImages' => null,
		);
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.product_id", $this->product_id);
		$criteria->compare("{$alias}.sort_order", $this->sort_order);
		$criteria->compare("{$alias}.price", $this->price);
		$criteria->compare("{$alias}.create_time", $this->create_time, true);
		$criteria->compare("{$alias}.update_time", $this->update_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}