<?php

/**
 * This is the model base class for the table "category".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Category".
 *
 * Columns in table "category" available as properties of the model,
 * followed by relations of table "category" available as properties of the model.
 *
 * @property integer $category_id
 * @property integer $parent_id
 * @property integer $sort_id
 * @property string $create_time
 * @property string $update_time
 *
 * @property CategoryI18n[] $categoryI18ns
 * @property Product2category[] $product2categories
 */
abstract class BaseCategory extends GxActiveRecord {

	public $searchI18n;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'category';
	}

	public static function label($n = 1) {
		return Yii::t('M/category', 'Category|Categories', $n);
	}

	public static function representingColumn() {
		return 'create_time';
	}

	public function rules() {
		return array(
			array('parent_id', 'required'),
			array('parent_id, sort_id', 'numerical', 'integerOnly'=>true),
			array('create_time, update_time', 'safe'),
			array('sort_id, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('category_id, parent_id, sort_id, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'categoryI18ns' => array(self::HAS_ONE, 'CategoryI18n', 'category_id', 'scopes' => array('t' => array(Yii::app()->params->languageId))),
			'product2categories' => array(self::HAS_MANY, 'Product2category', 'category_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'category_id' => Yii::t('M/category', 'Category'),
			'parent_id' => Yii::t('M/category', 'Parent'),
			'sort_id' => Yii::t('M/category', 'Sort'),
			'create_time' => Yii::t('M/category', 'Create Time'),
			'update_time' => Yii::t('M/category', 'Update Time'),
			'categoryI18ns' => null,
			'product2categories' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('category_id', $this->category_id);
		$criteria->compare('parent_id', $this->parent_id);
		$criteria->compare('sort_id', $this->sort_id);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		//$criteria->with('categoryI18ns:t');
		$criteria->with = array(
			'categoryI18ns' => array(
				'scopes' => array(
					't' => array(Yii::app()->params->languageId),
				),
			),
		);
		$criteria->group = 't.category_id';
		$criteria->together = true;

		//$criteria->compare('categoryI18ns.language_id', Yii::app()->params->languageId);
		$criteria->compare('categoryI18ns.title', $this->searchI18n->title, true);
		$criteria->compare('categoryI18ns.keywords', $this->searchI18n->keywords, true);
		$criteria->compare('categoryI18ns.description', $this->searchI18n->description, true);

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
