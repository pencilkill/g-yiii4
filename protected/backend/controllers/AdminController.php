<?php


class AdminController extends GxController {

	public function actionIndex() {
		$model = new Admin('search');
		$model->unsetAttributes();
		// except super ar
		$model->super = 0;

		if (isset($_GET['Admin'])){
			$model->setAttributes($_GET['Admin']);
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Admin;

		// RBAC, see modules rights components/rights to get more
		$authorizer = Yii::app()->getModule("rights")->getAuthorizer();
		$roles = $authorizer->getRoles(false);

		$rolesList = array();
		foreach ($roles as $name => $role){
			$rolesList[$name] = $name;
		}

		// leave it to be as default roles
		//$model->roles = array_keys(Rights::getAssignedRoles($model->admin_id, true));

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'admin-form'
		);

		if (isset($_POST['Admin'])) {
			$model->setAttributes($_POST['Admin']);

			if(isset($_POST['Admin']['roles'])){
				//$model->roles = $_POST['Admin']['roles'];
			}

			// 超級管理員只可手動設定
			$model->super = 0;


			if ($model->validate()) {
				$model->save(false);

				// RBAC revoke roles
				$assignedRoles = Rights::getAssignedRoles($model->admin_id, false); // sort false
				foreach ($assignedRoles as $roleName => $roleItem){
					Rights::revoke($roleName, $model->admin_id);
				}

				// RBAC assign roles, acctual rights recursive setting is already finished
				// here is just for compatibility
				foreach($model->roles as $role){
					Rights::assign($role, $model->admin_id);
				}

				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					Yii::app()->end();
				}else{
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('create', array(
			'model' => $model,
			'roles' => $roles,
			'rolesList' => $rolesList,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Admin');

		// RBAC
		$authorizer = Yii::app()->getModule("rights")->getAuthorizer();
		$roles = $authorizer->getRoles(false);

		$rolesList = array();
		foreach ($roles as $name => $role){
			$rolesList[$name] = $name;
		}

		$model->roles = array_keys(Rights::getAssignedRoles($model->admin_id, true));

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'admin-form'
		);

		if (isset($_POST['Admin'])) {
			// 超級管理員只可手動設定
			if(isset($_POST['Admin']['super'])) unset($_POST['Admin']['super']);

			$model->setAttributes($_POST['Admin']);

			if ($model->validate()) {
				$model->save(false);

				// RBAC revoke roles
				$assignedRoles = Rights::getAssignedRoles($model->admin_id, false); // sort false
				foreach ($assignedRoles as $roleName => $roleItem){
					Rights::revoke($roleName, $model->admin_id);
				}

				// RBAC assign roles, acctual rights recursive setting is already finished
				// here is just for compatibility
				foreach($model->roles as $role){
					Rights::assign($role, $model->admin_id);
				}

				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					Yii::app()->end();
				}else{
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('update', array(
			'model' => $model,
			'roles' => $roles,
			'rolesList' => $rolesList,
		));
	}

	public function actionAccount() {
		$id = Yii::app()->user->getId();

		$model = $this->loadModel($id, 'Admin');

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'admin-form'
		);

		if (isset($_POST['Admin'])) {
			$model->setAttributes($_POST['Admin']);

			if ($model->validate()) {
				$model->save(false);
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else{
					Yii::app()->user->setFlash('success', Yii::t('app', 'Operation Success'));
					$this->refresh();
					$this->redirect(array('account', array('id' => $id)));
				}
			}
		}

		$this->render('account', array(
			'model' => $model,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Admin')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest()){
				$this->redirect(array('index'));
			}
		} else {
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	}


	public function actionGridviewdelete() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$model = new Admin;

			$criteria= new CDbCriteria;
			$criteria->compare('admin_id', Yii::app()->getRequest()->getPost('selected'));
			// except super ar, event beforeDelete() has no effect on model()->deleteAll()
			$criteria->compare('super', 0);

			Admin::model()->deleteAll($criteria);

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(array('success' => true));
				Yii::app()->end();
			} else{
				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') : $this->createUrl('index'));
			}
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

}