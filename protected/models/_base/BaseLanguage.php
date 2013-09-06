<?php

/**
 * This is the model base class for the table "language".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Language".
 *
 * Columns in table "language" available as properties of the model,
 * followed by relations of table "language" available as properties of the model.
 *
 * @property integer $language_id
 * @property string $code
 * @property string $title
 * @property string $image
 * @property integer $sort_id
 * @property integer $status
 *
 * @property CategoryI18n[] $categoryI18ns
 * @property InformationI18n[] $informationI18ns
 * @property NewsI18n[] $newsI18ns
 * @property PicI18n[] $picI18ns
 * @property ProductI18n[] $productI18ns
 */
abstract class BaseLanguage extends GxActiveRecord {


	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'language';
	}

	public static function label($n = 1) {
		return Yii::t('M/language', 'Language|Languages', $n);
	}

	public static function representingColumn() {
		return 'code';
	}

	public function rules() {
		return array(
			array('code, title', 'required'),
			array('sort_id, status', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>8),
			array('title', 'length', 'max'=>64),
			array('image', 'length', 'max'=>255),
			array('image, sort_id, status', 'default', 'setOnEmpty' => true, 'value' => null),
			array('language_id, code, title, image, sort_id, status', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'categoryI18ns' => array(self::HAS_MANY, 'CategoryI18n', 'language_id'),
			'informationI18ns' => array(self::HAS_MANY, 'InformationI18n', 'language_id'),
			'newsI18ns' => array(self::HAS_MANY, 'NewsI18n', 'language_id'),
			'picI18ns' => array(self::HAS_MANY, 'PicI18n', 'language_id'),
			'productI18ns' => array(self::HAS_MANY, 'ProductI18n', 'language_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'language_id' => Yii::t('M/language', 'Language'),
			'code' => Yii::t('M/language', 'Code'),
			'title' => Yii::t('M/language', 'Title'),
			'image' => Yii::t('M/language', 'Image'),
			'sort_id' => Yii::t('M/language', 'Sort'),
			'status' => Yii::t('M/language', 'Status'),
			'categoryI18ns' => null,
			'informationI18ns' => null,
			'newsI18ns' => null,
			'picI18ns' => null,
			'productI18ns' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('language_id', $this->language_id);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('image', $this->image, true);
		$criteria->compare('sort_id', $this->sort_id);
		$criteria->compare('status', $this->status);


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