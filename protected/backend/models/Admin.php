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
			array('email', 'email'),
			array('confirm_password, password', 'required', 'on' => 'insert'),
			array('confirm_password, password', 'length', 'min' => 6),
			array('confirm_password', 'compare', 'compareAttribute' => 'password'),
			array('username', 'unique', 'className' => 'Admin', 'attributeName' => 'username'),
			array('roles', 'validRoles', 'on' => 'insert, update'),
			array('roles', 'safe', 'on'=>'search'),
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'roles' => Yii::t('m/admin', 'Roles'),
			'confirm_password' => Yii::t('m/admin', 'Confirm Password'),
		));
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

		$valid = (bool)sizeOf($this->roles);
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

	public function afterDelete(){
		$assignedRoles = Rights::getAssignedRoles($this->admin_id, false); // sort false
		foreach ($assignedRoles as $roleName => $roleItem){
			Rights::revoke($roleName, $this->admin_id);
		}
	}

	public function search() {
		$alias = $this->tableAlias;

		$criteria = new CDbCriteria;

		$criteria->compare("{$alias}.admin_id", $this->admin_id);
		$criteria->compare("{$alias}.name", $this->name, true);
		$criteria->compare("{$alias}.username", $this->username, true);
		$criteria->compare("{$alias}.email", $this->email, true);
		$criteria->compare("{$alias}.password", $this->password, true);
		$criteria->compare("{$alias}.status", $this->status);
		$criteria->compare("{$alias}.super", $this->super);
		$criteria->compare("{$alias}.create_time", $this->create_time, true);
		$criteria->compare("{$alias}.update_time", $this->update_time, true);
		$criteria->group = "{$alias}.admin_id";
		$criteria->together = true;


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => "{$alias}.admin_id ASC",
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