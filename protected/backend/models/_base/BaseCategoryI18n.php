<?php

/**
 * This is the model base class for the table "category_i18n".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CategoryI18n".
 *
 * Columns in table "category_i18n" available as properties of the model,
 * followed by relations of table "category_i18n" available as properties of the model.
 *
 * @property integer $category_i18n_id
 * @property integer $category_id
 * @property integer $language_id
 * @property string $title
 * @property string $keywords
 * @property string $description
 *
 * @property Category $category
 * @property Language $language
 */
abstract class BaseCategoryI18n extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'category_i18n';
	}

	public static function label($n = 1) {
		return Yii::t('m/categoryi18n', 'CategoryI18n|CategoryI18ns', $n);
	}

	public static function representingColumn() {
		return 'title';
	}

	public function rules() {
		return array(
			array('category_id, language_id, title', 'required'),
			array('category_id, language_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>256),
			array('keywords, description', 'safe'),
			array('keywords, description', 'default', 'setOnEmpty' => true, 'value' => null),
			array('category_i18n_id, category_id, language_id, title, keywords, description', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'category_i18n_id' => Yii::t('m/categoryi18n', 'Category I18n'),
			'category_id' => null,
			'language_id' => null,
			'title' => Yii::t('m/categoryi18n', 'Title'),
			'keywords' => Yii::t('m/categoryi18n', 'Keywords'),
			'description' => Yii::t('m/categoryi18n', 'Description'),
			'category' => null,
			'language' => null,
		);
	}
}