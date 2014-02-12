<?php


class NewsController extends GxController {



	public function actionIndex() {
		$model = new News('search');
		$model->unsetAttributes();

		$model->filterInstance();

		if (isset($_GET['News'])){
			$model->setAttributes($_GET['News']);
		}

		if (isset($_GET['NewsI18n'])){
			$model->filter->newsI18ns->setAttributes($_GET['NewsI18n']);
		}

		Yii::app()->user->setState('news-grid-url', Yii::app()->request->url);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new News;

		$i18ns = $model->getNewRelatedData('newsI18ns');

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
				array(
					'model' => $i18ns,
					'many' => true,
				),
			),
			'news-form'
		);

		if (isset($_POST['News'])) {
			$model->setAttributes($_POST['News']);

			$valid = $model->validate();

			$i18ns = array();
			foreach($_POST['NewsI18n'] as $val){
				$va = new NewsI18n;
				$va->setAttributes($val);
				$va->news_id = 0;

				$valid = $va->validate() && $valid;

				$i18ns[$val['language_id']] = $va;
			}

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					foreach($i18ns as $va){
						$va->news_id = $model->news_id;
						$va->save(false);
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

		$this->render('create', array(
			'model' => $model,
			'i18ns' => $i18ns,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'News');

		$i18ns = $model->newsI18ns;

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
				array(
					'model' => $i18ns,
					'many' => true,
				),
			),
			'news-form'
		);

		if (isset($_POST['News'])) {
			$model->setAttributes($_POST['News']);

			$valid = $model->validate();

			$i18ns = array();
			foreach($_POST['NewsI18n'] as $val){
				$va = new NewsI18n;
				$va->setAttributes($val);
				$va->news_id = $model->news_id;

				$valid = $va->validate() && $valid;

				$i18ns[$val['language_id']] = $va;
			}

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					$criteria = new CDbCriteria;
					$criteria->compare('news_id', $model->news_id);

					NewsI18n::model()->deleteAll($criteria);
					foreach($i18ns as $va){
						$va->save(false);
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
			'i18ns' => $i18ns,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id, 'News');

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
			$criteria->compare('news_id', $selectedIds);

			$models = Category::model()->findAll($criteria);

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

			$model = new News;

			$criteria= new CDbCriteria;
			$criteria->compare('news_id', $edittedIds);

			$models = News::model()->findAll($criteria);

			foreach ($models as $model){
				$model->setAttributes($editPosts[$model->news_id]);
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