<?php


class AdminController extends GxController {

	public function actionIndex() {
		$model = new Admin('search');
		$model->unsetAttributes();
		// except super ar
		$model->super = 0;

		if (isset($_GET['Admin']))
			$model->setAttributes($_GET['Admin']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Admin;

		// RBAC
		$authorizer = Yii::app()->getModule("rights")->getAuthorizer();
		$roles = $authorizer->getRoles(false);

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


			if ($model->validate()) {
				$model->save(false);

				// RBAC
				if(array_key_exists($model->defaultRole, $roles)){
					$authorizer->authManager->assign($model->defaultRole, $model->admin_id);
				}

				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('create', array(
			'model' => $model,
			//'roles' => $roles,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Admin');

		// RBAC
		//$authorizer = Yii::app()->getModule("rights")->getAuthorizer();
		//$roles = $authorizer->getRoles();

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

				// RBAC
				/*
				if(array_key_exists($model->defaultRole, $roles)){
					$authorizer->authManager->assign($model->defaultRole, $model->admin_id);
				}
				*/

				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
			'model' => $model,
			//'roles' => $roles,
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

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
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