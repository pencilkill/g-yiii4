<?php

Yii::import('backend.models._base.BaseNews');

class News extends BaseNews
{

	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function behaviors() {
		return CMap::mergeArray(parent::behaviors(), array(
			'CActiveRecordFilterBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordFilterBehavior',
			),
			'CTimestampBehavior'=> array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'updateAttribute' => 'update_time',
				'createAttribute' => 'create_time',
				'setUpdateOnCreate' => true,
			),
        ));
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'newsI18ns' => null,
		));
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.news_id", $this->news_id);
		$criteria->compare("{$alias}.top", $this->top);
		$criteria->compare("{$alias}.sort_order", $this->sort_order);
		$criteria->compare("{$alias}.date_added", $this->date_added, true);
		$criteria->compare("{$alias}.create_time", $this->create_time, true);
		$criteria->compare("{$alias}.update_time", $this->update_time, true);
		$criteria->group = "{$alias}.news_id";
		$criteria->together = true;

		$criteria->with = array('newsI18ns');

		$criteria->compare('newsI18ns.status', $this->filter->newsI18ns->status);
		$criteria->compare('newsI18ns.pic', $this->filter->newsI18ns->pic, true);
		$criteria->compare('newsI18ns.title', $this->filter->newsI18ns->title, true);
		$criteria->compare('newsI18ns.keywords', $this->filter->newsI18ns->keywords, true);
		$criteria->compare('newsI18ns.description', $this->filter->newsI18ns->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.sort_order DESC, {$alias}.news_id ASC",
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

}