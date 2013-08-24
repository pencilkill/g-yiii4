<?php

/**
 * This is the model base class for the table "news_i18n".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "NewsI18n".
 *
 * Columns in table "news_i18n" available as properties of the model,
 * followed by relations of table "news_i18n" available as properties of the model.
 *
 * @property integer $news_i18n_id
 * @property integer $news_id
 * @property integer $language_id
 * @property string $pic
 * @property string $title
 * @property string $keywords
 * @property string $description
 *
 * @property News $news
 * @property Language $language
 */
abstract class BaseNewsI18n extends GxActiveRecord {


	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'news_i18n';
	}

	public static function label($n = 1) {
		return Yii::t('M/newsi18n', 'NewsI18n|NewsI18ns', $n);
	}

	public static function representingColumn() {
		return 'title';
	}

	public function rules() {
		return array(
			array('news_id, language_id, title', 'required'),
			array('news_id, language_id', 'numerical', 'integerOnly'=>true),
			array('pic, title', 'length', 'max'=>256),
			array('keywords, description', 'safe'),
			array('pic, keywords, description', 'default', 'setOnEmpty' => true, 'value' => null),
			array('news_i18n_id, news_id, language_id, pic, title, keywords, description', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'news' => array(self::BELONGS_TO, 'News', 'news_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'news_i18n_id' => Yii::t('M/newsi18n', 'News I18n'),
			'news_id' => null,
			'language_id' => null,
			'pic' => Yii::t('M/newsi18n', 'Pic'),
			'title' => Yii::t('M/newsi18n', 'Title'),
			'keywords' => Yii::t('M/newsi18n', 'Keywords'),
			'description' => Yii::t('M/newsi18n', 'Description'),
			'news' => null,
			'language' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('news_i18n_id', $this->news_i18n_id);
		$criteria->compare('news_id', $this->news_id);
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