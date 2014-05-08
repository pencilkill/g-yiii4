<?php


class AdminController extends GxController {

	public function actionIndex() {
		$model = new Admin('search');
		$model->unsetAttributes();

		if (isset($_GET['Admin'])){
			$model->setAttributes($_GET['Admin']);
		}

		// except super ar
		$model->super = 0;

		Yii::app()->user->setState('admin-grid-url', Yii::app()->request->url);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Admin;

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'admin-form'
		);

		if (isset($_POST['Admin'])) {
			$model->setAttributes($_POST['Admin']);

			// 超級管理員只可手動設定
			$model->super = 0;

			$valid = $model->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

                try{
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

					$transaction->commit();

	                if (Yii::app()->getRequest()->getIsAjaxRequest()){
						echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));

                        Yii::app()->end();
                    }else{
                        $this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') : array('index'));
                    }
                }catch(CDbException $e){
                    $transaction->rollback();

                    Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
                }
            }else{
                Yii::app()->user->setFlash('warning', Yii::t('app', 'Validation Failure'));
            }
		}
		// authenticatedName as default
		if(empty($model->roles) && $role = Yii::app()->getModule('rights')->authenticatedName){
			$model->roles[$role] = $role;
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Admin');

		$model->roles = CHtml::listData(Rights::getAssignedRoles($model->admin_id, false), 'name', 'name');

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

			$valid = $model->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{

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

					$transaction->commit();

                    if (Yii::app()->getRequest()->getIsAjaxRequest()){
                        echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));

                        Yii::app()->end();
                    }else{
                        $this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') : array('index'));
                    }
                }catch(CDbException $e){
                    $transaction->rollback();

                    Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
                }
            }else{
                Yii::app()->user->setFlash('warning', Yii::t('app', 'Validation Failure'));
            }
		}

		$this->render('update', array(
			'model' => $model,
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

			$valid = $model->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{

					$model->save(false);

					$transaction->commit();

                    if (Yii::app()->getRequest()->getIsAjaxRequest()){
                        echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));

                        Yii::app()->end();
                    }else{
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Operation Success'));

                        $this->refresh();
                    }
                }catch(CDbException $e){
                    $transaction->rollback();

                    Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
                }
            }else{
                Yii::app()->user->setFlash('warning', Yii::t('app', 'Validation Failure'));
            }
		}

		$this->render('account', array(
			'model' => $model,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = $this->loadModel($id, 'Admin');

            if(!$model->delete()){
                Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure'));
            }

            if (Yii::app()->getRequest()->getIsAjaxRequest()){
                echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));

                Yii::app()->end();
            }else{
                $this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') :  $this->createUrl('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
	}


	public function actionGridviewdelete() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$selectedIds = Yii::app()->getRequest()->getPost('selected');

            $criteria= new CDbCriteria;
            $criteria->compare('admin_id', $selectedIds);

			// except super ar
			$criteria->compare('super', 0);

			$models = Admin::model()->findAll($criteria);

			$errorModel = null;

			$transaction = Yii::app()->db->beginTransaction();

			try{
				foreach ($models as $model){
					if(!$model->delete()) {
						$errorModel = $model;

						Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure'));

						break;
					}
				}

				$transaction->commit();

			}catch(CDbException $e){
				$transaction->rollback();

				Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
			}

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));

				Yii::app()->end();
			} else{
				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') : $this->createUrl('index'));
			}
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	public function actionGridviewupdate() {
		if (Yii::app()->getRequest()->getIsPostRequest()){

			$editPosts = Yii::app()->getRequest()->getPost('edit');
            $edittedIds = Yii::app()->getRequest()->getPost('editted');

			$errorModel = null;

			$model = new Admin;

			$criteria= new CDbCriteria;
			$criteria->compare('admin_id', $edittedIds);

			// except super ar
			$criteria->compare('super', 0);

			$models = Admin::model()->findAll($criteria);

			foreach ($models as $model){
				// unset password
				$model->unsetAttributes(array('password'));

				$model->setAttributes($editPosts[$model->admin_id]);

				if(!$model->validate()) {
					$errorModel = $model;

					break;
				}
			}

			if(!$errorModel){
				$transaction = Yii::app()->db->beginTransaction();

				try{
					foreach ($models as $model){
						$model->save(false);
					}

					$transaction->commit();

				}catch(CDbException $e){
					$transaction->rollback();

					Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
				}
			}else{
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure'));
			}

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));

				Yii::app()->end();
			} else{
				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') :  $this->create('index'));
			}
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

}