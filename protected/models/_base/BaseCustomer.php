<?php

/**
 * This is the model base class for the table "customer".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Customer".
 *
 * Columns in table "customer" available as properties of the model,
 * followed by relations of table "customer" available as properties of the model.
 *
 * @property integer $customer_id
 * @property integer $customer_type_id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $token
 * @property integer $activated
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 *
 * @property CustomerType $customerType
 */
abstract class BaseCustomer extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'customer';
	}

	public static function label($n = 1) {
		return Yii::t('m/customer', 'Customer|Customers', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('customer_type_id, name, username', 'required'),
			array('customer_type_id, activated, status', 'numerical', 'integerOnly'=>true),
			array('name, username, password, token', 'length', 'max'=>32),
			array('create_time, update_time', 'safe'),
			array('token, activated, status, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('customer_id, customer_type_id, name, username, password, token, activated, status, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'customerType' => array(self::BELONGS_TO, 'CustomerType', 'customer_type_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'customer_id' => Yii::t('m/customer', 'Customer'),
			'customer_type_id' => null,
			'name' => Yii::t('m/customer', 'Name'),
			'username' => Yii::t('m/customer', 'Username'),
			'password' => Yii::t('m/customer', 'Password'),
			'token' => Yii::t('m/customer', 'Token'),
			'activated' => Yii::t('m/customer', 'Activated'),
			'status' => Yii::t('m/customer', 'Status'),
			'create_time' => Yii::t('m/customer', 'Create Time'),
			'update_time' => Yii::t('m/customer', 'Update Time'),
			'customerType' => null,
		);
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.customer_id", $this->customer_id);
		$criteria->compare("{$alias}.customer_type_id", $this->customer_type_id);
		$criteria->compare("{$alias}.name", $this->name, true);
		$criteria->compare("{$alias}.username", $this->username, true);
		$criteria->compare("{$alias}.password", $this->password, true);
		$criteria->compare("{$alias}.token", $this->token, true);
		$criteria->compare("{$alias}.activated", $this->activated);
		$criteria->compare("{$alias}.status", $this->status);
		$criteria->compare("{$alias}.create_time", $this->create_time, true);
		$criteria->compare("{$alias}.update_time", $this->update_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

}