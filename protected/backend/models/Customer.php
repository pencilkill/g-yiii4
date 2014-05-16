<?php

Yii::import('backend.models._base.BaseCustomer');

class Customer extends BaseCustomer
{

	public $confirm_password = '';

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function behaviors() {
		return CMap::mergeArray(parent::behaviors(), array(
			'CTimestampBehavior'=> array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'updateAttribute' => 'update_time',
				'createAttribute' => 'create_time',
				'setUpdateOnCreate' => true,
			),
        ));
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
			array('username', 'unique', 'className' => 'Admin', 'attributeName' => 'username', 'on' => 'insert, update'),
			array('username', 'email'),
			array('username', 'unsafe', 'on' => 'update'),
			array('confirm_password, password', 'required', 'on' => 'insert'),
			array('confirm_password, password', 'length', 'min' => 6),
			array('confirm_password', 'compare', 'compareAttribute' => 'password'),
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'confirm_password' => Yii::t('m/customer', 'Confirm Password'),
			'customer_Type_id' => null,
			'customerType' => null,
		));
	}

    public function hashPassword($password)
    {
        return md5($password);
    }

	protected function beforeSave() {
		if( ! parent::beforeSave()) return false;
		//
		if(trim($this->password)){
			$this->password = $this->hashPassword($this->password);
		}else{
			unset($this->password);
		}

		return true;
	}

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.customer_id";
		$criteria->together = true;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.customer_id" => CSort::SORT_ASC,
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

}