<?php

Yii::import('frontend.models._base.BaseContact');

class Contact extends BaseContact
{
	public $verifyCode;

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

	public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		));
	}

	public function attributeLabels()
	{
		return CMap::mergeArray(parent::attributeLabels(), array(
			'verifyCode'=>Yii::t('app', 'Verification Code'),
		));
	}
}