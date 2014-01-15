<?php

/**
 * This is the model base class for the table "admin".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Admin".
 *
 * Columns in table "admin" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $admin_id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property integer $status
 * @property integer $super
 * @property string $create_time
 * @property string $update_time
 *
 */
abstract class BaseAdmin extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'admin';
	}

	public static function label($n = 1) {
		return Yii::t('m/admin', 'Admin|Admins', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, username, email', 'required'),
			array('status, super', 'numerical', 'integerOnly'=>true),
			array('name, username, email, password', 'length', 'max'=>32),
			array('create_time, update_time', 'safe'),
			array('status, super, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('admin_id, name, username, email, password, status, super, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'admin_id' => Yii::t('m/admin', 'Admin'),
			'name' => Yii::t('m/admin', 'Name'),
			'username' => Yii::t('m/admin', 'Username'),
			'email' => Yii::t('m/admin', 'Email'),
			'password' => Yii::t('m/admin', 'Password'),
			'status' => Yii::t('m/admin', 'Status'),
			'super' => Yii::t('m/admin', 'Super'),
			'create_time' => Yii::t('m/admin', 'Create Time'),
			'update_time' => Yii::t('m/admin', 'Update Time'),
		);
	}
}