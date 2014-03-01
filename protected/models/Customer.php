<?php

Yii::import('frontend.models._base.BaseCustomer');

class Customer extends BaseCustomer
{

	public $confirm_password;
	public $verifyCode;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function group($customer_group_id)
	{
	    $t = $this->getTableAlias(false, false);

	    $this->getDbCriteria()->mergeWith(array(
	        'condition' => "{$t}.customer_group_id=:customer_group_id",
	        'params' => array(':customer_group_id'=>$customer_group_id),
	    ));

	    return $this;
	}

	public function status($status = 1)
	{
		$t = $this->getTableAlias(false, false);

	    $this->getDbCriteria()->mergeWith(array(
	        'condition' => "{$t}.status=:status",
	        'params' => array(':status'=>$status),
	    ));

	    return $this;
	}

	public function rules(){
		return CMap::mergeArray(parent::rules(), array(
			array('username', 'unique', 'className' => 'Admin', 'attributeName' => 'username', 'on' => 'insert, update'),
			array('username', 'email'),
			array('confirm_password, password', 'required', 'on' => 'insert'),
			array('confirm_password, password', 'length', 'min' => 6),
			array('confirm_password', 'compare', 'compareAttribute' => 'password'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		));
	}

	public function attributeLabels()
	{
		return CMap::mergeArray(parent::attributeLabels(), array(
			'confirm_password' => Yii::t('m/customer', 'Confirm Password'),
			'verifyCode'=>Yii::t('app', 'Verification Code'),
		));
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