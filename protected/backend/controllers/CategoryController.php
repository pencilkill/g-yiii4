<?php


class CategoryController extends GxController {



	public function actionIndex($parent_id = 0) {
		$model = new Category('search');
		$model->unsetAttributes();
		$model->parent_id = $parent_id;

		$i18n = new CategoryI18n('search');
		$i18n->unsetAttributes();

		$model->searchI18n = $i18n;

		if (isset($_GET['Category'])){
			$model->setAttributes($_GET['Category']);
		}

		if (isset($_GET['CategoryI18n'])){
			$i18n->setAttributes($_GET['CategoryI18n']);
		}

		$this->render('index', array(
			'model' => $model,
			'i18n' => $i18n,
		));
	}

	public function actionCreate() {
		$model = new Category;

		$i18ns = array();

		foreach($this->languages as $val){
			$i18n = new CategoryI18n;
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
			'category-form'
		);

		$categories = Category::getCategories();

		if (isset($_POST['Category'])) {
			$model->setAttributes($_POST['Category']);

			$valid = true;

			foreach($this->languages as $val){
				$i18ns[$val['language_id']]->setAttributes($_POST['CategoryI18n'][$val['language_id']]);
				$i18ns[$val['language_id']]->language_id = $val['language_id'];
				$i18ns[$val['language_id']]->category_id = 0;

				$valid = $i18ns[$val['language_id']]->validate() && $valid;
			}


			if ($valid && $model->validate()) {
				$model->save(false);

				foreach($this->languages as $val){
					$i18ns[$val['language_id']]->category_id = $model->category_id;
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
			'categories' => $categories,
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

		$categories = Category::getCategories();

		if (isset($_POST['Category'])) {
			$model->setAttributes($_POST['Category']);
			$valid = true;

			foreach($this->languages as $val){
				$i18ns[$val['language_id']]->setAttributes($_POST['CategoryI18n'][$val['language_id']]);
				$i18ns[$val['language_id']]->language_id = $val['language_id'];
				$i18ns[$val['language_id']]->category_id = $model->category_id;

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
			'categories' => $categories,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Category')->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				echo CJSON::encode(($flashes=Yii::app()->user->getFlashes()) ? $flashes : array('success' => true));
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