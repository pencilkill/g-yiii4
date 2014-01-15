<?php

Yii::import('backend.models._base.BaseContact');

class Contact extends BaseContact
{

	public $filter;

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
			array('contact_id, status, firstname, lastname, sex, telephone, cellphone, fax, email, company, address, message, remark, create_time, update_time', 'safe', 'on'=>'update'),
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
		));
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.contact_id", $this->contact_id);
		$criteria->compare("{$alias}.status", $this->status);
		$criteria->compare("{$alias}.firstname", $this->firstname, true);
		$criteria->compare("{$alias}.lastname", $this->lastname, true);
		$criteria->compare("{$alias}.sex", $this->sex);
		$criteria->compare("{$alias}.telephone", $this->telephone, true);
		$criteria->compare("{$alias}.cellphone", $this->cellphone, true);
		$criteria->compare("{$alias}.fax", $this->fax, true);
		$criteria->compare("{$alias}.email", $this->email, true);
		$criteria->compare("{$alias}.company", $this->company, true);
		$criteria->compare("{$alias}.address", $this->address, true);
		$criteria->compare("{$alias}.message", $this->message, true);
		$criteria->compare("{$alias}.remark", $this->remark, true);
		$criteria->compare("{$alias}.create_time", $this->create_time, true);
		$criteria->compare("{$alias}.update_time", $this->update_time, true);
		$criteria->group = "{$alias}.contact_id";
		$criteria->together = true;


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.contact_id ASC",
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