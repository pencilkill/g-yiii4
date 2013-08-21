<?php

/**
 * This is the model base class for the table "pic".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Pic".
 *
 * Columns in table "pic" available as properties of the model,
 * followed by relations of table "pic" available as properties of the model.
 *
 * @property integer $pic_id
 * @property integer $sort_id
 * @property string $pic
 * @property integer $pic_type_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 *
 * @property PicType $picType
 * @property PicI18n[] $picI18ns
 */
abstract class BasePic extends GxActiveRecord {

	public $searchI18n;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'pic';
	}

	public static function label($n = 1) {
		return Yii::t('M/pic', 'Pic|Pics', $n);
	}

	public static function representingColumn() {
		return 'pic';
	}

	public function rules() {
		return array(
			array('pic, pic_type_id', 'required'),
			array('sort_id, pic_type_id, status', 'numerical', 'integerOnly'=>true),
			array('pic', 'length', 'max'=>256),
			array('create_time, update_time', 'safe'),
			array('sort_id, status, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('pic_id, sort_id, pic, pic_type_id, status, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'picType' => array(self::BELONGS_TO, 'PicType', 'pic_type_id'),
			'picI18ns' => array(self::HAS_MANY, 'PicI18n', 'pic_id', 'index' => 'language_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'pic_id' => Yii::t('M/pic', 'Pic'),
			'sort_id' => Yii::t('M/pic', 'Sort'),
			'pic' => Yii::t('M/pic', 'Pic'),
			'pic_type_id' => null,
			'status' => Yii::t('M/pic', 'Status'),
			'create_time' => Yii::t('M/pic', 'Create Time'),
			'update_time' => Yii::t('M/pic', 'Update Time'),
			'picType' => null,
			'picI18ns' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('pic_id', $this->pic_id);
		$criteria->compare('sort_id', $this->sort_id);
		$criteria->compare('pic', $this->pic, true);
		$criteria->compare('pic_type_id', $this->pic_type_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		$criteria->with = array('picI18ns');
		$criteria->group = 't.pic_id';
		$criteria->together = true;

		$criteria->compare('picI18ns.url', $this->searchI18n->url, true);
		$criteria->compare('picI18ns.title', $this->searchI18n->title, true);
		$criteria->compare('picI18ns.keywords', $this->searchI18n->keywords, true);
		$criteria->compare('picI18ns.description', $this->searchI18n->description, true);

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