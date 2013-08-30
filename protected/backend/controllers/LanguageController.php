<?php


class LanguageController extends GxController {



	public function actionIndex() {
		$model = new Language('search');
		$model->unsetAttributes();

		if (isset($_GET['Language'])){
			$model->setAttributes($_GET['Language']);
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Language;

		$imagesRaw = CFileHelper::findFiles(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '_ozman/image/flags', array('fileTypes' => array('png')));

		$images = array();
		array_walk($imagesRaw, function($v) use(&$images){
			$images[] = array(
				'value' => strtr($v, array(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR => '')),
				'data-image' => strtr($v, array(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR => '')),
				'text' => strtoupper(pathinfo($v, PATHINFO_FILENAME)),
			);
		});

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'language-form'
		);

		if (isset($_POST['Language'])) {
			$model->setAttributes($_POST['Language']);


			if ($model->validate()) {
				$model->save(false);
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					Yii::app()->end();
				}else{
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('create', array(
			'model' => $model,
			'images' => $images,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Language');

		$imagesRaw = CFileHelper::findFiles(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '_ozman/image/flags', array('fileTypes' => array('png')));

		$images = array();
		array_walk($imagesRaw, function($v) use(&$images){
			$images[] = array(
				'value' => strtr($v, array(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR => '')),
				'data-image' => strtr($v, array(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR => '')),
				'text' => strtoupper(pathinfo($v, PATHINFO_FILENAME)),
			);
		});

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
			),
			'language-form'
		);

		if (isset($_POST['Language'])) {
			$model->setAttributes($_POST['Language']);

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
			'images' => $images,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Language')->delete();

			if (! Yii::app()->getRequest()->getIsAjaxRequest()){
				$this->redirect(array('index'));
			}
		} else {
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	}


	public function actionGridviewdelete() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$selected = Yii::app()->getRequest()->getPost('selected');

			$criteria= new CDbCriteria;
			$criteria->compare('language_id', $selected);

			$models = Language::model()->findAll($criteria);

			$valid = true;

			foreach ($models as $model){
				$valid = $valid && $model->beforeDelete();
				if(! $valid){
					break;
				}
			}

			if($valid) {
				foreach ($models as $model){
					$model->delete();
				}
			}


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

			$model = new Language;

			$criteria= new CDbCriteria;
			$criteria->compare('language_id', $editIds);

			$models = Language::model()->findAll($criteria);

			foreach ($models as $model){
				$model->setAttributes($editPosts[$model->language_id]);
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