<?php

Yii::import('frontend.models._base.BasePicture');

class Picture extends BasePicture
{

	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
			'with' => array(
				'pictureI18n',
			),
			'order' => "{$alias}.sort_order DESC, {$alias}.picture_id DESC",
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

		$criteria->group = "{$alias}.picture_id";
		$criteria->together = true;

		$criteria->with[] = 'pictureI18n';
		$criteria->compare('pictureI18n.status', $this->filter->pictureI18n->status);
		$criteria->compare('pictureI18n.url', $this->filter->pictureI18n->url, true);
		$criteria->compare('pictureI18n.title', $this->filter->pictureI18n->title, true);
		$criteria->compare('pictureI18n.keywords', $this->filter->pictureI18n->keywords, true);
		$criteria->compare('pictureI18n.description', $this->filter->pictureI18n->description, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.sort_order" => CSort::SORT_DESC,
					"{$alias}.picture_id" => CSort::SORT_ASC,
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