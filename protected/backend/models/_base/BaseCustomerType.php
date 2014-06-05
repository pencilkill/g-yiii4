<?php

/**
 * This is the model base class for the table "customer_type".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CustomerType".
 *
 * Columns in table "customer_type" available as properties of the model,
 * followed by relations of table "customer_type" available as properties of the model.
 *
 * @property integer $customer_type_id
 * @property string $name
 * @property integer $default
 *
 * @property Customer[] $customers
 */
abstract class BaseCustomerType extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'customer_type';
	}

	public static function label($n = 1) {
		return Yii::t('m/customertype', 'CustomerType|CustomerTypes', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('default', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			array('default', 'default', 'setOnEmpty' => true, 'value' => null),
			array('customer_type_id, name, default', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'customers' => array(self::HAS_MANY, 'Customer', 'customer_type_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'customer_type_id' => Yii::t('m/customerType', 'Customer Type'),
			'name' => Yii::t('m/customerType', 'Name'),
			'default' => Yii::t('m/customerType', 'Default'),
			'customers' => null,
		);
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.customer_type_id", $this->customer_type_id);
		$criteria->compare("{$alias}.name", $this->name, true);
		$criteria->compare("{$alias}.default", $this->default);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}