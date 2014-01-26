<?php

/**
 * This is the model base class for the table "picture_type".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "PictureType".
 *
 * Columns in table "picture_type" available as properties of the model,
 * followed by relations of table "picture_type" available as properties of the model.
 *
 * @property integer $picture_type_id
 * @property string $picture_type
 * @property string $create_time
 * @property string $update_time
 *
 * @property Picture[] $pictures
 */
abstract class BasePictureType extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'picture_type';
	}

	public static function label($n = 1) {
		return Yii::t('m/picturetype', 'PictureType|PictureTypes', $n);
	}

	public static function representingColumn() {
		return 'picture_type';
	}

	public function rules() {
		return array(
			array('picture_type', 'required'),
			array('picture_type', 'length', 'max'=>256),
			array('create_time, update_time', 'safe'),
			array('create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('picture_type_id, picture_type, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'pictures' => array(self::HAS_MANY, 'Picture', 'picture_type_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'picture_type_id' => Yii::t('m/picturetype', 'Picture Type'),
			'picture_type' => Yii::t('m/picturetype', 'Picture Type'),
			'create_time' => Yii::t('m/picturetype', 'Create Time'),
			'update_time' => Yii::t('m/picturetype', 'Update Time'),
			'pictures' => null,
		);
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.picture_type_id", $this->picture_type_id);
		$criteria->compare("{$alias}.picture_type", $this->picture_type, true);
		$criteria->compare("{$alias}.create_time", $this->create_time, true);
		$criteria->compare("{$alias}.update_time", $this->update_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

}