<?php

/**
 * This is the model base class for the table "news".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "News".
 *
 * Columns in table "news" available as properties of the model,
 * followed by relations of table "news" available as properties of the model.
 *
 * @property integer $news_id
 * @property integer $top
 * @property integer $sort_id
 * @property integer $status
 * @property string $date_added
 * @property string $create_time
 * @property string $update_time
 *
 * @property NewsI18n[] $newsI18ns
 */
abstract class BaseNews extends GxActiveRecord {

	public $filterI18n;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'news';
	}

	public static function label($n = 1) {
		return Yii::t('M/news', 'News|News', $n);
	}

	public static function representingColumn() {
		return 'date_added';
	}

	public function rules() {
		return array(
			array('top, sort_id, status', 'numerical', 'integerOnly'=>true),
			array('date_added, create_time, update_time', 'safe'),
			array('top, sort_id, status, date_added, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('news_id, top, sort_id, status, date_added, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'newsI18ns' => array(self::HAS_MANY, 'NewsI18n', 'news_id', 'index' => 'language_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'news_id' => Yii::t('M/news', 'News'),
			'top' => Yii::t('M/news', 'Top'),
			'sort_id' => Yii::t('M/news', 'Sort'),
			'status' => Yii::t('M/news', 'Status'),
			'date_added' => Yii::t('M/news', 'Date Added'),
			'create_time' => Yii::t('M/news', 'Create Time'),
			'update_time' => Yii::t('M/news', 'Update Time'),
			'newsI18ns' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('news_id', $this->news_id);
		$criteria->compare('top', $this->top);
		$criteria->compare('sort_id', $this->sort_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('date_added', $this->date_added, true);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		$criteria->with = array('newsI18ns');
		$criteria->group = 't.news_id';
		$criteria->together = true;

		$criteria->compare('newsI18ns.pic', $this->filterI18n->pic, true);
		$criteria->compare('newsI18ns.title', $this->filterI18n->title, true);
		$criteria->compare('newsI18ns.keywords', $this->filterI18n->keywords, true);
		$criteria->compare('newsI18ns.description', $this->filterI18n->description, true);

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