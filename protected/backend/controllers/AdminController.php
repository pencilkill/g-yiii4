<?php

class AdminController extends GxController {



	public function actionIndex() {
		$model = new Admin('search');
		$model->unsetAttributes();

		if (isset($_GET['Admin']))
			$model->setAttributes($_GET['Admin']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Admin('create');

		$this->performAjaxValidation($model, 'admin-form');

		if (isset($_POST['Admin'])) {
			$model->setAttributes($_POST['Admin']);

			if ($model->save(true)) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('create', array(
			'model' => $model
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Admin');

		$this->performAjaxValidation($model, 'admin-form');

		if (isset($_POST['Admin'])) {
			$model->setAttributes($_POST['Admin']);

			if ($model->save(true)) {
				$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
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
			$criteria->addInCondition('admin_id', Yii::app()->getRequest()->getPost('selected'));
			// except super ar
			$criteria->addCondition('super = 0');

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