<?php

/**
 * This is the model base class for the table "admin_authassignment".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AdminAuthassignment".
 *
 * Columns in table "admin_authassignment" available as properties of the model,
 * followed by relations of table "admin_authassignment" available as properties of the model.
 *
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 *
 * @property AdminAuthitem $adminAuthitem
 */
abstract class BaseAdminAuthassignment extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'admin_authassignment';
	}

	public static function label($n = 1) {
		return Yii::t('m/adminAuthassignment', 'AdminAuthassignment|AdminAuthassignments', $n);
	}

	public static function representingColumn() {
		return 'userid';
	}

	public function rules() {
		return array(
			array('itemname, userid', 'required'),
			array('itemname, userid', 'length', 'max'=>64),
			array('bizrule, data', 'safe'),
			array('bizrule, data', 'default', 'setOnEmpty' => true, 'value' => null),
			array('itemname, userid, bizrule, data', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'adminAuthitem' => array(self::BELONGS_TO, 'AdminAuthitem', 'itemname'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'itemname' => null,
			'userid' => Yii::t('m/adminAuthassignment', 'Userid'),
			'bizrule' => Yii::t('m/adminAuthassignment', 'Bizrule'),
			'data' => Yii::t('m/adminAuthassignment', 'Data'),
			'authitem' => null,
		);
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.itemname", $this->itemname);
		$criteria->compare("{$alias}.userid", $this->userid, true);
		$criteria->compare("{$alias}.bizrule", $this->bizrule, true);
		$criteria->compare("{$alias}.data", $this->data, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}