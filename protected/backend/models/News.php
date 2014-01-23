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
			'CActiveRecordI18nBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordI18nBehavior',
				'relations' => array(
					'newsI18ns' => array(
						'indexes' => CHtml::listData(Language::model()->findAll(), 'language_id', 'language_id'),
					),
				)
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
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.news_id";
		$criteria->together = true;

		$criteria->with[] = 'newsI18ns';
		$criteria->compare('newsI18ns.status', $this->filter->newsI18ns->status);
		$criteria->compare('newsI18ns.pic', $this->filter->newsI18ns->pic, true);
		$criteria->compare('newsI18ns.title', $this->filter->newsI18ns->title, true);
		$criteria->compare('newsI18ns.keywords', $this->filter->newsI18ns->keywords, true);
		$criteria->compare('newsI18ns.description', $this->filter->newsI18ns->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.sort_order" => CSort::SORT_DESC,
					"{$alias}.news_id" => CSort::SORT_ASC,
				),
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