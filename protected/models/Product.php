<?php

Yii::import('frontend.models._base.BaseProduct');

class Product extends BaseProduct
{

	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
			'with' => array(
				'productI18n',
			),
			'order' => "{$alias}.sort_order DESC, {$alias}.product_id DESC",
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

		$criteria->group = "{$alias}.product_id";
		$criteria->together = true;

		$criteria->with[] = 'productI18n';
		$criteria->compare('productI18n.status', $this->filter->productI18n->status);
		$criteria->compare('productI18n.pic', $this->filter->productI18n->pic, true);
		$criteria->compare('productI18n.title', $this->filter->productI18n->title, true);
		$criteria->compare('productI18n.keywords', $this->filter->productI18n->keywords, true);
		$criteria->compare('productI18n.description', $this->filter->productI18n->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.sort_order" => CSort::SORT_DESC,
					"{$alias}.product_id" => CSort::SORT_ASC,
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