<?php

/**
 * This is the model base class for the table "authassignment".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Authassignment".
 *
 * Columns in table "authassignment" available as properties of the model,
 * followed by relations of table "authassignment" available as properties of the model.
 *
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 *
 * @property Authitem $authitem
 */
abstract class BaseAuthassignment extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'authassignment';
	}

	public static function label($n = 1) {
		return Yii::t('m/authassignment', 'Authassignment|Authassignments', $n);
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
			'authitem' => array(self::BELONGS_TO, 'Authitem', 'itemname'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'itemname' => null,
			'userid' => Yii::t('m/authassignment', 'Userid'),
			'bizrule' => Yii::t('m/authassignment', 'Bizrule'),
			'data' => Yii::t('m/authassignment', 'Data'),
			'authitem' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('itemname', $this->itemname);
		$criteria->compare('userid', $this->userid, true);
		$criteria->compare('bizrule', $this->bizrule, true);
		$criteria->compare('data', $this->data, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}