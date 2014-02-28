<?php

Yii::import('backend.models._base.BaseCustomerGroup');

class CustomerGroup extends BaseCustomerGroup
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
        ));
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'customers' => null,
		));
	}

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.customer_group_id";
		$criteria->together = true;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.customer_group_id" => CSort::SORT_ASC,
				),
				'multiSort'=>true,
				'attributes'=>array(
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

    	if(sizeof($this->customers)){
    		Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure Including SubItems'));

    		return false;
    	}

    	return true;
    }
}