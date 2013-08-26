<?php

/**
 * This is the model base class for the table "information".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Information".
 *
 * Columns in table "information" available as properties of the model,
 * followed by relations of table "information" available as properties of the model.
 *
 * @property integer $information_id
 * @property integer $sort_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 *
 * @property InformationI18n[] $informationI18ns
 */
abstract class BaseInformation extends GxActiveRecord {

	public $searchI18n;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'information';
	}

	public static function label($n = 1) {
		return Yii::t('M/information', 'Information|Informations', $n);
	}

	public static function representingColumn() {
		return 'create_time';
	}

	public function rules() {
		return array(
			array('sort_id, status', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time', 'safe'),
			array('sort_id, status, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('information_id, sort_id, status, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'informationI18ns' => array(self::HAS_ONE, 'InformationI18n', 'information_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'information_id' => Yii::t('M/information', 'Information'),
			'sort_id' => Yii::t('M/information', 'Sort'),
			'status' => Yii::t('M/information', 'Status'),
			'create_time' => Yii::t('M/information', 'Create Time'),
			'update_time' => Yii::t('M/information', 'Update Time'),
			'informationI18ns' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('information_id', $this->information_id);
		$criteria->compare('sort_id', $this->sort_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		$criteria->with = array('informationI18ns');
		$criteria->group = 't.information_id';
		$criteria->together = true;

		$criteria->compare('informationI18ns.language_id', Yii::app()->params->languageId);
		$criteria->compare('informationI18ns.title', $this->searchI18n->title, true);
		$criteria->compare('informationI18ns.keywords', $this->searchI18n->keywords, true);
		$criteria->compare('informationI18ns.description', $this->searchI18n->description, true);

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