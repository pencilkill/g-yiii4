<?php

/**
 * This is the model base class for the table "product_i18n".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProductI18n".
 *
 * Columns in table "product_i18n" available as properties of the model,
 * followed by relations of table "product_i18n" available as properties of the model.
 *
 * @property integer $product_i18n_id
 * @property integer $product_id
 * @property integer $language_id
 * @property string $pic
 * @property string $title
 * @property string $keywords
 * @property string $description
 *
 * @property Product $product
 * @property Language $language
 */
abstract class BaseProductI18n extends GxActiveRecord {


	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'product_i18n';
	}

	public static function label($n = 1) {
		return Yii::t('M/producti18n', 'ProductI18n|ProductI18ns', $n);
	}

	public static function representingColumn() {
		return 'pic';
	}

	public function rules() {
		return array(
			array('product_id, language_id, pic, title', 'required'),
			array('product_id, language_id', 'numerical', 'integerOnly'=>true),
			array('pic, title', 'length', 'max'=>256),
			array('keywords, description', 'safe'),
			array('keywords, description', 'default', 'setOnEmpty' => true, 'value' => null),
			array('product_i18n_id, product_id, language_id, pic, title, keywords, description', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'product_i18n_id' => Yii::t('M/producti18n', 'Product I18n'),
			'product_id' => null,
			'language_id' => null,
			'pic' => Yii::t('M/producti18n', 'Pic'),
			'title' => Yii::t('M/producti18n', 'Title'),
			'keywords' => Yii::t('M/producti18n', 'Keywords'),
			'description' => Yii::t('M/producti18n', 'Description'),
			'product' => null,
			'language' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('product_i18n_id', $this->product_i18n_id);
		$criteria->compare('product_id', $this->product_id);
		$criteria->compare('language_id', $this->language_id);
		$criteria->compare('pic', $this->pic, true);
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