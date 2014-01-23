<?php

Yii::import('frontend.models._base.BaseCategory');

class Category extends BaseCategory
{

	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
			'order' => "{$alias}.sort_order DESC, {$alias}.category_id DESC",
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

		$criteria->group = "{$alias}.category_id";
		$criteria->together = true;

		$criteria->with[] = 'categoryI18n';
		$criteria->compare('categoryI18n.title', $this->filter->categoryI18n->title, true);
		$criteria->compare('categoryI18n.keywords', $this->filter->categoryI18n->keywords, true);
		$criteria->compare('categoryI18n.description', $this->filter->categoryI18n->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.sort_order" => CSort::SORT_DESC,
					"{$alias}.category_id" => CSort::SORT_ASC,
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