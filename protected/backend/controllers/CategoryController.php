<?php


class CategoryController extends GxController {



	public function actionIndex() {
		$model = new Category('search');
		$model->unsetAttributes();

		$i18n = new CategoryI18n('search');
		$i18n->unsetAttributes();

		$model->filterI18n = $i18n;

		if (isset($_GET['Category'])){
			$model->setAttributes($_GET['Category']);
		}

		if (isset($_GET['CategoryI18n'])){
			$i18n->setAttributes($_GET['CategoryI18n']);
		}

		Yii::app()->user->setState('category-grid-url', Yii::app()->request->url);

		$this->render('index', array(
			'model' => $model,
			'i18n' => $i18n,
		));
	}

	public function actionCreate() {
		$model = new Category;

		$i18ns = array();

		foreach($this->languages as $val){
			$va = new CategoryI18n;
			$i18ns[$val['language_id']] = $va;
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
			'category-form'
		);

		if (isset($_POST['Category'])) {
			$model->setAttributes($_POST['Category']);

			$valid = $model->validate();

			$i18ns = array();
			foreach($_POST['CategoryI18n'] as $val){
				$va = new CategoryI18n;
				$va->setAttributes($val);
				$va->category_id = 0;

				$valid = $va->validate() && $valid;

				$i18ns[$val['language_id']] = $va;
			}

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					foreach($i18ns as $va){
						$va->category_id = $model->category_id;
						$va->save(false);
					}

					$transaction->commit();

					if (Yii::app()->getRequest()->getIsAjaxRequest()){
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
		$model = $this->loadModel($id, 'Category');

		$i18ns = $model->categoryI18ns;

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
				array(
					'model' => $i18ns,
					'many' => true,
				),
			),
			'category-form'
		);

		if (isset($_POST['Category'])) {
			$model->setAttributes($_POST['Category']);

			$valid = $model->validate();

			foreach($_POST['CategoryI18n'] as $val){
				$va = new CategoryI18n;
				$va->setAttributes($val);
				$va->category_id = $model->category_id;

				$valid = $va->validate() && $valid;

				$i18ns[$val['language_id']] = $va;
			}

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					foreach($i18ns as $val){
						$va->save(false);
					}

					$transaction->commit();

					if (Yii::app()->getRequest()->getIsAjaxRequest()){
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
			$model = $this->loadModel($id, 'Category');

			if(! $model->beforeDelete()){
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure.'));
			}else{
				$model->delete();
			}

			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				echo CJSON::encode(Yii::app()->user->getFlashes() ? Yii::app()->user->getFlashes() : array('success' => true));
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
			$selected = Yii::app()->getRequest()->getPost('selected');

			$criteria= new CDbCriteria;
			$criteria->compare('category_id', $selected);

			$models = Category::model()->findAll($criteria);

			$errorModel = null;

			foreach ($models as $model){
				if(! $model->beforeDelete()){
					$errorModel = $model;
					break;
				}
			}

			if(! $errorModel) {
				foreach ($models as $model){
					$model->delete();
				}
			}else{
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure.'));
			}

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(Yii::app()->user->getFlashes() ? Yii::app()->user->getFlashes() : array('success' => true));
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

			$model = new Category;

			$criteria= new CDbCriteria;
			$criteria->compare('category_id', $editIds);

			$models = Category::model()->findAll($criteria);

			foreach ($models as $model){
				$model->setAttributes($editPosts[$model->category_id]);
				if(! $model->validate()) {
					$errorModel = $model;
					break;
				}
			}

			if(! $errorModel){
				foreach ($models as $model){
					$model->save(false);
				}
			}else{
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure.'));
			}

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(Yii::app()->user->getFlashes() ? Yii::app()->user->getFlashes() : array('success' => true));
				Yii::app()->end();
			} else{
				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') :  $this->create('index'));
			}
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

}