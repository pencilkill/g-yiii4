<?php

Yii::import('backend.models._base.BaseProduct');

class Product extends BaseProduct
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
					'productI18ns' => array(
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
			'product2categories' => null,
			'productI18ns' => null,
			'productImages' => null,
		));
	}

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.product_id";
		$criteria->together = true;

		$criteria->with[] = 'productI18ns';
		$criteria->compare('productI18ns.status', $this->filter->productI18ns->status);
		$criteria->compare('productI18ns.pic', $this->filter->productI18ns->pic, true);
		$criteria->compare('productI18ns.title', $this->filter->productI18ns->title, true);
		$criteria->compare('productI18ns.keywords', $this->filter->productI18ns->keywords, true);
		$criteria->compare('productI18ns.description', $this->filter->productI18ns->description, true);

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


    protected function beforeDelete(){
    	// Raise event
    	if(!parent::beforeDelete()) return false;

    	if(sizeOf($this->product2categories) || sizeOf($this->productImages)){
    		Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure Including SubItems'));

    		return false;
    	}

    	return true;
    }
}