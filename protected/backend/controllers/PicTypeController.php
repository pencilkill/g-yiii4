<?php

class PicTypeController extends GxController {



	public function actionIndex() {
		$model = new PicType('search');
		$model->unsetAttributes();

		if (isset($_GET['PicType']))
			$model->setAttributes($_GET['PicType']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new PicType;

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'pic-type-form'
		);

		if (isset($_POST['PicType'])) {
			$model->setAttributes($_POST['PicType']);


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
		$model = $this->loadModel($id, 'PicType');
		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'pic-type-form'
		);

		if (isset($_POST['PicType'])) {
			$model->setAttributes($_POST['PicType']);

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
			$this->loadModel($id, 'PicType')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}


	public function actionGridviewdelete() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$model = new PicType;

			$criteria= new CDbCriteria;
			$criteria->compare('pic_type_id', Yii::app()->getRequest()->getPost('selected'));

			PicType::model()->deleteAll($criteria);

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