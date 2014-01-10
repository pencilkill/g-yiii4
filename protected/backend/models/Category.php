<?php

Yii::import('backend.models._base.BaseCategory');

class Category extends BaseCategory
{
	/**
	 * @var object
	 * an helper object to filter data
	 * checking search(), CActiveRecordFilterBehavior
	 */
	public $filter;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function behaviors() {
        return CMap::mergeArray(parent::behaviors(), array(
			'CActiveRecordFilterBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordFilterBehavior',
			),
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'updateAttribute' => 'update_time',
				'createAttribute' => 'create_time',
				'setUpdateOnCreate' => true,
			),
			'CActiveRecordNullBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordNullBehavior',
				'attributes' => array(
					'parent_id',
				),
			),
			'CTreeBehavior' => array(
				'class' => 'backend.behaviors.CTreeBehavior',
				'textAttribute' => 'categoryI18n.title',
			),
        ));
	}

	/**
	 * customer null label
	 * notice that if label value is null, yii will get the value from the relation model label
	 */

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'parent' => null,
			'categories' => null,
			'categoryI18ns' => null,
			'product2categories' => null,
		));
	}

	/**
	 * Customer rules
	 */

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
			array('parent_id', 'validParentId', 'on' => 'update'),
		));
	}

	/**
	 * Validate parent_id
	 */

	public function validParentId(){
    	$categoryIds = self::getCategoryIds(__CLASS__, $this->category_id, true);

    	if(in_array($this->parent_id, $categoryIds)){
    		$this->addError('parent_id', Yii::t('m/category', 'Parent_id can not be self or children'));
    	}
    }

    /**
     * Checking relations before the DB fk constraint
     *
     * @return boolean
     */

    public function beforeDelete(){
    	if(!parent::beforeDelete()) return false;

    	if(sizeOf($this->categories) || sizeOf($this->product2categories)){
    		Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure Including SubItems'));

    		return false;
    	}

    	return true;
    }
}