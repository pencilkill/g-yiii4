<?php

/**
 * This is the model base class for the table "pic_type".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "PicType".
 *
 * Columns in table "pic_type" available as properties of the model,
 * followed by relations of table "pic_type" available as properties of the model.
 *
 * @property integer $pic_type_id
 * @property string $pic_type
 * @property string $create_time
 * @property string $update_time
 *
 * @property Pic[] $pics
 */
abstract class BasePicType extends GxActiveRecord {


	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'pic_type';
	}

	public static function label($n = 1) {
		return Yii::t('M/pictype', 'PicType|PicTypes', $n);
	}

	public static function representingColumn() {
		return 'pic_type';
	}

	public function rules() {
		return array(
			array('pic_type', 'required'),
			array('pic_type', 'length', 'max'=>256),
			array('create_time, update_time', 'safe'),
			array('create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('pic_type_id, pic_type, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'pics' => array(self::HAS_MANY, 'Pic', 'pic_type_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'pic_type_id' => Yii::t('M/pictype', 'Pic Type'),
			'pic_type' => Yii::t('M/pictype', 'Pic Type'),
			'create_time' => Yii::t('M/pictype', 'Create Time'),
			'update_time' => Yii::t('M/pictype', 'Update Time'),
			'pics' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('pic_type_id', $this->pic_type_id);
		$criteria->compare('pic_type', $this->pic_type, true);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
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

	public function behaviors() {
		return array(
			'CTimestampBehavior'=>array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'updateAttribute' => 'update_time',
				'createAttribute' => 'create_time',
				'setUpdateOnCreate' => true,
			),
        );
	}
}