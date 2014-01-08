<?php

Yii::import('backend.models._base.BaseContact');

class Contact extends BaseContact
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules(){
		return CMap::mergeArray(
			parent::rules(),
			array(
				array('contact_id, status, firstname, lastname, telephone, country, city, state, postcode, fax, email, company, job, address, message, note, create_time, update_time', 'safe', 'on'=>'update'),
			)
		);
	}
}