<?php

class PicController extends GxController {



	public function actionIndex() {
		$model = new Pic('search');
		$model->unsetAttributes();

		if (isset($_GET['Pic']))
			$model->setAttributes($_GET['Pic']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Pic;

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'pic-form'
		);

		if (isset($_POST['Pic'])) {
			$model->setAttributes($_POST['Pic']);

			if ($model->validate()) {
				$model->save(false);
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
		$model = $this->loadModel($id, 'Pic');
		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'pic-form'
		);

		if (isset($_POST['Pic'])) {
			$model->setAttributes($_POST['Pic']);

			if ($model->validate()) {
				$model->save(false);
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Pic')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}


	public function actionGridviewdelete() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$model = new Pic;

			$criteria= new CDbCriteria;
			$criteria->compare('pic_id', Yii::app()->getRequest()->getPost('selected'));

			Pic::model()->deleteAll($criteria);

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