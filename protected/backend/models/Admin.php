<?php

Yii::import('backend.models._base.BaseAdmin');

class Admin extends BaseAdmin
{
	/**
	 * cause authManager->defaultRoles is relative to user login
	 * this can not get authManager->defaultRoles simply
	 *@var roles, type like authManager->defaultRoles;
	 */
	public $roles = array('Authenticated');

	public $confirm_password = '';


	public static function model($className=__CLASS__) {
		return parent::model($className);
	}


	public function rules(){
		$rules = array(
			array('email', 'email'),
			array('confirm_password, password, roles', 'required', 'on' => 'create'),
			array('confirm_password, password', 'length', 'min' => 6),
			array('confirm_password', 'compare', 'compareAttribute' => 'password'),
			array('username', 'unique', 'className' => 'Admin', 'attributeName' => 'username'),
			array('roles', 'validRoles', 'on' => 'create, update'),
			array('roles', 'safe', 'on'=>'search'),
		);

		return CMap::mergeArray(parent::rules(), $rules);
	}


	public function attributeLabels()
	{
		$appendAttributeLabels = array(
			'roles' => Yii::t('M/admin', 'Roles'),
			'confirm_password' => Yii::t('M/admin', 'Confirm Password'),
		);

		return CMap::mergeArray(parent::attributeLabels(), $appendAttributeLabels);
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
    /**
     * validRoles
     */
    public function validRoles()
    {
        $authorizer = Yii::app()->getModule("rights")->getAuthorizer();
		$roles = $authorizer->getRoles(false);

		$valid = true;
		foreach($this->roles as $role){
			$valid = array_key_exists($role, $roles) && $valid;
			if(! $valid){
				break;
			}
		}

		return $valid;
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