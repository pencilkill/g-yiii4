<?php


class PicController extends GxController {



	public function actionIndex() {
		$model = new Pic('search');
		$model->unsetAttributes();

		$i18n = new PicI18n('search');
		$i18n->unsetAttributes();

		$model->searchI18n = $i18n;

		if (isset($_GET['Pic'])){
			$model->setAttributes($_GET['Pic']);
		}

		if (isset($_GET['PicI18n'])){
			$i18n->setAttributes($_GET['PicI18n']);
		}

		$this->render('index', array(
			'model' => $model,
			'i18n' => $i18n,
		));
	}

	public function actionCreate() {
		$model = new Pic;

		$i18ns = array();

		foreach($this->languages as $val){
			$i18n = new PicI18n;
			$i18ns[$val['language_id']] = $i18n;
		}

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
				array(
					'model' => $i18ns,
					'many' => true,
				),
			),
			'pic-form'
		);

		if (isset($_POST['Pic'])) {
			$model->setAttributes($_POST['Pic']);

			$valid = true;

			foreach($this->languages as $val){
				$i18ns[$val['language_id']]->setAttributes($_POST['PicI18n'][$val['language_id']]);
				$i18ns[$val['language_id']]->language_id = $val['language_id'];
				$i18ns[$val['language_id']]->pic_id = 0;

				$valid = $i18ns[$val['language_id']]->validate() && $valid;
			}


			if ($valid && $model->validate()) {
				$model->save(false);

				foreach($this->languages as $val){
					$i18ns[$val['language_id']]->pic_id = $model->pic_id;
					$i18ns[$val['language_id']]->save();
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
			'i18ns' => $i18ns,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Pic');

		$i18ns = $model->picI18ns;

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
				array(
					'model' => $i18ns,
					'many' => true,
				),
			),
			'pic-form'
		);

		if (isset($_POST['Pic'])) {
			$model->setAttributes($_POST['Pic']);
			$valid = true;

			foreach($this->languages as $val){
				$i18ns[$val['language_id']]->setAttributes($_POST['PicI18n'][$val['language_id']]);
				$i18ns[$val['language_id']]->language_id = $val['language_id'];
				$i18ns[$val['language_id']]->pic_id = $model->pic_id;

				$valid = $i18ns[$val['language_id']]->validate() && $valid;
			}

			if ($valid && $model->validate()) {
				$model->save(false);

				foreach($this->languages as $val){
					$i18ns[$val['language_id']]->save();
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
			'i18ns' => $i18ns,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Pic')->delete();

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
			$criteria->compare('pic_id', $selected);

			$models = Pic::model()->findAll($criteria);

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

			$model = new Pic;

			$criteria= new CDbCriteria;
			$criteria->compare('pic_id', $editIds);

			$models = Pic::model()->findAll($criteria);

			foreach ($models as $model){
				$model->setAttributes($editPosts[$model->pic_id]);
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