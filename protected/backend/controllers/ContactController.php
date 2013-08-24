<?php


class ContactController extends GxController {



	public function actionIndex() {
		$model = new Contact('search');
		$model->unsetAttributes();

		if (isset($_GET['Contact'])){
			$model->setAttributes($_GET['Contact']);
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Contact');

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'contact-form'
		);

		if (isset($_POST['Contact'])) {
			$model->setAttributes($_POST['Contact']);

			if ($model->validate()) {
				$model->save(false);
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					Yii::app()->end();
				}else{
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Contact')->delete();

			if (! Yii::app()->getRequest()->getIsAjaxRequest()){
				$this->redirect(array('index'));
			}
		} else {
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	}


	public function actionGridviewdelete() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$model = new Contact;

			$criteria= new CDbCriteria;
			$criteria->compare('contact_id', Yii::app()->getRequest()->getPost('selected'));

			Contact::model()->deleteAll($criteria);

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


	public function actionGridviewupdate() {
		if (Yii::app()->getRequest()->getIsPostRequest()){

			$editPosts = Yii::app()->getRequest()->getPost('edit');
			$editIds = array_keys($editPosts);

			$errorModel = null;

			$model = new Contact;

			$criteria= new CDbCriteria;
			$criteria->compare('contact_id', $editIds);

			$models = Contact::model()->findAll($criteria);

			foreach ($models as $model){
				$model->setAttributes($editPosts[$model->contact_id]);
				if(! $model->validate()) {
					$errorModel = $model;
					break;
				}
			}

			if(! $errorModel){
				foreach ($models as $model){
					$model->save(false);
				}
			}

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(array('success' => true));
				Yii::app()->end();
			} else{
				$errorModel && Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure'));

				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') :  $this->create('index'));
			}
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

}