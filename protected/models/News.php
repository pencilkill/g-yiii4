<?php

Yii::import('frontend.models._base.BaseNews');

class News extends BaseNews
{

	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
			'with' => array(
				'newsI18n',
			),
			'order' => "{$alias}.sort_order DESC, {$alias}.news_id DESC",
		));
	}

	public function behaviors() {
		return CMap::mergeArray(parent::behaviors(), array(
			'CActiveRecordFilterBehavior' => array(
				'class' => 'frontend.behaviors.CActiveRecordFilterBehavior',
			),
        ));
	}

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.news_id";
		$criteria->together = true;

		$criteria->with[] = 'newsI18n';
		$criteria->compare('newsI18n.status', $this->filter->newsI18n->status);
		$criteria->compare('newsI18n.pic', $this->filter->newsI18n->pic, true);
		$criteria->compare('newsI18n.title', $this->filter->newsI18n->title, true);
		$criteria->compare('newsI18n.keywords', $this->filter->newsI18n->keywords, true);
		$criteria->compare('newsI18n.description', $this->filter->newsI18n->description, true);

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