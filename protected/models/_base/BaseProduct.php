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
 * @property integer $top
 * @property integer $sort_id
 * @property integer $status
 * @property string $date_added
 * @property string $create_time
 * @property string $update_time
 *
 * @property Product2category[] $product2categories
 * @property Product2image[] $product2images
 * @property ProductI18n[] $productI18ns
 */
abstract class BaseProduct extends GxActiveRecord {

	public $searchI18n;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'product';
	}

	public static function label($n = 1) {
		return Yii::t('M/product', 'Product|Products', $n);
	}

	public static function representingColumn() {
		return 'date_added';
	}

	public function rules() {
		return array(
			array('top, sort_id, status', 'numerical', 'integerOnly'=>true),
			array('date_added, create_time, update_time', 'safe'),
			array('top, sort_id, status, date_added, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('product_id, top, sort_id, status, date_added, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'product2categories' => array(self::HAS_MANY, 'Product2category', 'product_id'),
			'product2images' => array(self::HAS_MANY, 'Product2image', 'product_id'),
			'productI18ns' => array(self::HAS_ONE, 'ProductI18n', 'product_id', 'scopes' => array('t' => array(Yii::app()->params->languageId))),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'product_id' => Yii::t('M/product', 'Product'),
			'top' => Yii::t('M/product', 'Top'),
			'sort_id' => Yii::t('M/product', 'Sort'),
			'status' => Yii::t('M/product', 'Status'),
			'date_added' => Yii::t('M/product', 'Date Added'),
			'create_time' => Yii::t('M/product', 'Create Time'),
			'update_time' => Yii::t('M/product', 'Update Time'),
			'product2categories' => null,
			'product2images' => null,
			'productI18ns' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('top', $this->top);
		$criteria->compare('sort_id', $this->sort_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('date_added', $this->date_added, true);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		$criteria->with = array(
			'productI18ns' => array(
				'scopes' => array(
					't' => array(Yii::app()->params->languageId),
				),
			),
		);
		$criteria->group = 't.product_id';
		$criteria->together = true;

		$criteria->compare('productI18ns.pic', $this->searchI18n->pic, true);
		$criteria->compare('productI18ns.title', $this->searchI18n->title, true);
		$criteria->compare('productI18ns.keywords', $this->searchI18n->keywords, true);
		$criteria->compare('productI18ns.description', $this->searchI18n->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'attributes'=>array(
					'sort_id'=>array(
						'desc'=>'sort_id DESC',
						'asc'=>'sort_id',
					),
					'*',
				),
			),
		));
	}

}