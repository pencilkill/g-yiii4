<?php

/**
 * This is the model base class for the table "picture".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Picture".
 *
 * Columns in table "picture" available as properties of the model,
 * followed by relations of table "picture" available as properties of the model.
 *
 * @property integer $picture_id
 * @property integer $sort_order
 * @property string $pic
 * @property integer $picture_type_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 *
 * @property PictureType $pictureType
 * @property PictureI18n $pictureI18n
 * @property PictureI18n[] $pictureI18ns
 */
abstract class BasePicture extends GxActiveRecord {

	public $filterI18n;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'picture';
	}

	public static function label($n = 1) {
		return Yii::t('m/picture', 'Picture|Pictures', $n);
	}

	public static function representingColumn() {
		return 'pic';
	}

	public function rules() {
		return array(
			array('pic, picture_type_id', 'required'),
			array('sort_order, picture_type_id, status', 'numerical', 'integerOnly'=>true),
			array('pic', 'length', 'max'=>256),
			array('create_time, update_time', 'safe'),
			array('sort_order, status, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('picture_id, sort_order, pic, picture_type_id, status, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'pictureType' => array(self::BELONGS_TO, 'PictureType', 'picture_type_id'),
			'pictureI18n' => array(self::HAS_ONE, 'PictureI18n', 'picture_id', 'scopes' => array('t' => array())),
			'pictureI18ns' => array(self::HAS_MANY, 'PictureI18n', 'picture_id', 'index' => 'language_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'picture_id' => Yii::t('m/picture', 'Picture'),
			'sort_order' => Yii::t('m/picture', 'Sort Order'),
			'pic' => Yii::t('m/picture', 'Pic'),
			'picture_type_id' => null,
			'status' => Yii::t('m/picture', 'Status'),
			'create_time' => Yii::t('m/picture', 'Create Time'),
			'update_time' => Yii::t('m/picture', 'Update Time'),
			'pictureType' => null,
			'pictureI18ns' => null,
		);
	}

	public function search() {
		$alias = $this->tableAlias;
	
		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.picture_id", $this->picture_id);
		$criteria->compare("{$alias}.sort_order", $this->sort_order);
		$criteria->compare("{$alias}.pic", $this->pic, true);
		$criteria->compare("{$alias}.picture_type_id", $this->picture_type_id);
		$criteria->compare("{$alias}.status", $this->status);
		$criteria->compare("{$alias}.create_time", $this->create_time, true);
		$criteria->compare("{$alias}.update_time", $this->update_time, true);

		$criteria->with = array('pictureI18ns');
		$criteria->group = "{$alias}.picture_id";
		$criteria->together = true;

		$criteria->compare('pictureI18ns.url', $this->filterI18n->url, true);
		$criteria->compare('pictureI18ns.title', $this->filterI18n->title, true);
		$criteria->compare('pictureI18ns.keywords', $this->filterI18n->keywords, true);
		$criteria->compare('pictureI18ns.description', $this->filterI18n->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.sort_order DESC, {$alias}.picture_id ASC",
				'multiSort'=>true,
				'attributes'=>array(
					'sort_order'=>array(
						'desc'=>"{$alias}.sort_order DESC",
						'asc'=>"{$alias}.sort_order ASC",
					),
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