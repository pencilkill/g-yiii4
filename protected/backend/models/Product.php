<?php

Yii::import('backend.models._base.BaseProduct');

class Product extends BaseProduct
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return CMap::mergeArray(
			parent::rules(),
			array(
				array('product2categories', 'validParentId'),
			)
		);
	}

	// parent_id valid
    public function validParentId(){
    	if(sizeOf(array_filter($this->product2categories, function($v){ return (int)$v['category_id'];}))==0){
    		$this->addError('product2categories', Yii::t('M/product', 'Parent_id should be at least one which has no sub categories'));
    	}
    }
}