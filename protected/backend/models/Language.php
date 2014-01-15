<?php

Yii::import('backend.models._base.BaseLanguage');

class Language extends BaseLanguage
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
				'updateAttribute' => null,
                'createAttribute' => null,
				'setUpdateOnCreate' => true,
			),
        ));
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
			array('code', 'unique', 'className' => 'Language', 'attributeName' => 'code'),
			array('code', 'match' , 'pattern'=>'/^[a-z][a-z_]+[a-z]$/', 'message'=>Yii::t('m/language', '{attribute} can be allowed a-z or \'_\' only, and \'_\' can not be first char and last char.')),
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'categoryI18ns' => null,
			'informationI18ns' => null,
			'newsI18ns' => null,
			'pictureI18ns' => null,
			'productI18ns' => null,
		));
	}

	public function beforeSave(){
		if(!parent::beforeSave()) return false;

		if(Language::model()->count() == 1){
			$this->status = 1;
		}

		return true;
	}

	public function beforeDelete(){
		if(!parent::beforeDelete()) return false;

		if(Language::model()->count() == 1){
			Yii::app()->user->setFlash('warning', Yii::t('app', 'Items Should Be At Least One'));

			return false;
		}

		return true;
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.language_id", $this->language_id);
		$criteria->compare("{$alias}.code", $this->code, true);
		$criteria->compare("{$alias}.title", $this->title, true);
		$criteria->compare("{$alias}.sort_order", $this->sort_order);
		$criteria->compare("{$alias}.status", $this->status);
		$criteria->group = "{$alias}.language_id";
		$criteria->together = true;


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.sort_order DESC, {$alias}.language_id ASC",
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