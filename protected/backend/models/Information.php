<?php

Yii::import('backend.models._base.BaseInformation');

class Information extends BaseInformation
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
			'CActiveRecordNullBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordNullBehavior',
				'attributes' => array(
					'parent_id',
				),
			),
			'CTreeBehavior' => array(
				'class' => 'backend.behaviors.CTreeBehavior',
				'textAttribute' => 'informationI18n.title',
			),
			'CActiveRecordI18nBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordI18nBehavior',
				'relations' => array(
					'informationI18ns' => array(
						'indexes' => CHtml::listData(Language::model()->findAll(), 'language_id', 'language_id'),
					),
				)
			),
        ));
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
			array('parent_id', 'validParentId', 'on' => 'update'),
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'parent_id' => null,
			'parent' => null,
			'informations' => null,
			'informationI18ns' => null,
		));
	}

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.information_id";
		$criteria->together = true;

		$criteria->with[] = 'informationI18ns';
		$criteria->compare('informationI18ns.status', $this->filter->informationI18ns->status);
		$criteria->compare('informationI18ns.title', $this->filter->informationI18ns->title, true);
		$criteria->compare('informationI18ns.keywords', $this->filter->informationI18ns->keywords, true);
		$criteria->compare('informationI18ns.description', $this->filter->informationI18ns->description, true);

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


	public function validParentId(){
    	$categoryIds = $this->subNodes($this->information_id, true);

    	if(in_array($this->parent_id, $categoryIds)){
    		$this->addError('parent_id', Yii::t('app', 'Parent_id can not be self or children'));
    	}
    }


    protected function beforeDelete(){
    	// Raise event
    	if(!parent::beforeDelete()) return false;

    	if(sizeof($this->informations)){
    		Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure Including SubItems'));

    		return false;
    	}

    	return true;
    }
}