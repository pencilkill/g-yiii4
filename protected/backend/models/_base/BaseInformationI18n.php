<?php

/**
 * This is the model base class for the table "information_i18n".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "InformationI18n".
 *
 * Columns in table "information_i18n" available as properties of the model,
 * followed by relations of table "information_i18n" available as properties of the model.
 *
 * @property integer $information_i18n_id
 * @property integer $information_id
 * @property integer $language_id
 * @property string $title
 * @property string $keywords
 * @property string $description
 *
 * @property Information $information
 * @property Language $language
 */
abstract class BaseInformationI18n extends GxActiveRecord {


	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'information_i18n';
	}

	public static function label($n = 1) {
		return Yii::t('M/informationi18n', 'InformationI18n|InformationI18ns', $n);
	}

	public static function representingColumn() {
		return 'title';
	}

	public function rules() {
		return array(
			array('information_id, language_id, title, keywords, description', 'required'),
			array('information_id, language_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>256),
			array('information_i18n_id, information_id, language_id, title, keywords, description', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'information' => array(self::BELONGS_TO, 'Information', 'information_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'information_i18n_id' => Yii::t('M/informationi18n', 'Information I18n'),
			'information_id' => null,
			'language_id' => null,
			'title' => Yii::t('M/informationi18n', 'Title'),
			'keywords' => Yii::t('M/informationi18n', 'Keywords'),
			'description' => Yii::t('M/informationi18n', 'Description'),
			'information' => null,
			'language' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('information_i18n_id', $this->information_i18n_id);
		$criteria->compare('information_id', $this->information_id);
		$criteria->compare('language_id', $this->language_id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('keywords', $this->keywords, true);
		$criteria->compare('description', $this->description, true);


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'attributes'=>array(
					'*',
				),
			),
		));
	}

	public function behaviors() {
		return array(
			'CTimestampBehavior'=>array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'updateAttribute' => null,
                'createAttribute' => null,
				'setUpdateOnCreate' => true,
			),
        );
	}
}