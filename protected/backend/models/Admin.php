<?php

Yii::import('backend.models._base.BaseAdmin');

class Admin extends BaseAdmin
{
	public $roles = array();

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
			array('username', 'unique', 'className' => 'Admin', 'attributeName' => 'username', 'on' => 'insert, update'),
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
        $authorizer = Yii::app()->getModule('rights')->getAuthorizer();
		$roles = $authorizer->getRoles(false);

		$valid = (bool)sizeof($this->roles);
		foreach($this->roles as $role){
			$valid = array_key_exists($role, $roles) && $valid;
			if(! $valid){
				break;
			}
		}

		return $valid;
    }

	protected function beforeSave() {
		if( ! parent::beforeSave()) return false;

		if(trim($this->password)){
			$this->password = $this->hashPassword($this->password);
		}else{
			unset($this->password);
		}

		return true;
	}

	protected function beforeDelete() {
		return $this->super ? false : true;
	}

	protected function afterDelete(){
		parent::afterDelete();

		$assignedRoles = Rights::getAssignedRoles($this->admin_id, false); // sort false
		foreach ($assignedRoles as $roleName => $roleItem){
			Rights::revoke($roleName, $this->admin_id);
		}
	}

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.admin_id";
		$criteria->together = true;

		$criteria->with = array('authassignment');
		$criteria->compare('authassignment.itemname', $this->roles);


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
					"{$alias}.admin_id" => CSort::SORT_ASC,
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

	public function rolesList($includeSuperuser=false, $sort=true){
		// RBAC
		$authorizer = Yii::app()->getModule('rights')->getAuthorizer();
		$roles = $authorizer->getRoles($includeSuperuser, $sort);

		return CHtml::listData($roles, 'name', 'name');
	}
}