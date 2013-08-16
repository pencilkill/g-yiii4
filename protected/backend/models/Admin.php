<?php

Yii::import('backend.models._base.BaseAdmin');

class Admin extends BaseAdmin
{
	public $confirm_password = '';

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules(){
		$appendRules = array(
			array('email', 'email'),
			array('confirm_password, password', 'required', 'on' => 'create'),
			array('confirm_password, password', 'length', 'min' => 6),
			array('confirm_password', 'compare', 'compareAttribute' => 'password'),
			array('username', 'unique', 'className' => 'Admin', 'attributeName' => 'username'),
		);

		return array_merge(parent::rules(), $appendRules);
	}


	public function attributeLabels()
	{
		$appendAttributeLabels = array(
			'confirm_password' => Yii::t('M/admin', 'Confirm Password'),
		);

		return array_merge(parent::attributeLabels(), $appendAttributeLabels);
	}

	/**
	 * validate password
	 * @param $password
	 */
	public function validatePassword($password)
    {
        return $this->hashPassword($password) === $this->password;
    }
    /**
     * sample crypt password
     * @param $password
     */
    public function hashPassword($password)
    {
        return md5($password);
    }

	public function beforeSave() {
		if( ! parent::beforeSave()) return false;

		if(trim($this->password)){
			$this->password = $this->hashPassword($this->password);
		}else{
			unset($this->password);
		}

		return true;
	}

	public function beforeDelete() {
		return $this->super ? false : true;
	}
}