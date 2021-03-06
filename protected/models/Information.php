<?php

Yii::import('frontend.models._base.BaseInformation');

class Information extends BaseInformation
{

	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
			'with' => array(
				'informationI18n',
			),
			'order' => "{$alias}.sort_order DESC, {$alias}.information_id DESC",
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

		$criteria->group = "{$alias}.information_id";
		$criteria->together = true;

		$criteria->with[] = 'informationI18n';
		$criteria->compare('informationI18n.status', $this->filter->informationI18n->status);
		$criteria->compare('informationI18n.title', $this->filter->informationI18n->title, true);
		$criteria->compare('informationI18n.keywords', $this->filter->informationI18n->keywords, true);
		$criteria->compare('informationI18n.description', $this->filter->informationI18n->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.sort_order" => CSort::SORT_DESC,
					"{$alias}.information_id" => CSort::SORT_ASC,
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