<?php


class ProductController extends GxController {



	public function actionIndex() {
		$model = new Product('search');
		$model->unsetAttributes();

		$model->filterInstance();

		if (isset($_GET['Product'])){
			$model->setAttributes($_GET['Product']);
		}

		if (isset($_GET['ProductI18n'])){
			$model->filter->productI18ns->setAttributes($_GET['ProductI18n']);
		}

		Yii::app()->user->setState('product-grid-url', Yii::app()->request->url);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new Product;

		$i18ns = array();

		foreach($this->languages as $val){
			$va = new ProductI18n;
			$i18ns[$val['language_id']] = $va;
		}

		$gallery = new ProductImage;
		$galleries = $model->productImages;

		$p2c = new Product2category;
		$p2cs = $model->product2categories;

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
				array(
					'model' => $i18ns,
					'many' => true,
				),
			),
			'product-form'
		);

		if (isset($_POST['Product'])) {
			$model->setAttributes($_POST['Product']);

			$valid = $model->validate();

			$i18ns = array();
			foreach($_POST['ProductI18n'] as $val){
				$va = new ProductI18n;
				$va->setAttributes($val);
				$va->product_id = 0;

				$valid = $va->validate() && $valid;

				$i18ns[$val['language_id']] = $va;
			}

			$galleries = array();
			if(isset($_POST['ProductImage']) && is_array($_POST['ProductImage'])){
				foreach($_POST['ProductImage'] as $val){
					$va = new ProductImage;
					$va->setAttributes($val);
					$va->product_id = 0;

					$valid = $va->validate() && $valid;

					$galleries[] = $va;
				}
			}

			$p2cs = array();
			if(isset($_POST['Product2category']) && is_array($_POST['Product2category'])){
				foreach($_POST['Product2category'] as $val){
					$va = new Product2category;
					$va->setAttributes($val);
					$va->product_id = 0;

					$valid = $va->validate() && $valid;

					$p2cs[] = $va;
				}
			}

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					foreach($i18ns as $va){
						$va->product_id = $model->product_id;
						$va->save(false);
					}

					foreach($galleries as $va){
						$va->product_id = $model->product_id;
						$va->save(false);
					}

					foreach($p2cs as $va){
						$va->product_id = $model->product_id;
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
			'gallery' => $gallery,
			'galleries' => $galleries,
			'p2c' => $p2c,
			'p2cs' => $p2cs,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Product');

		$i18ns = $model->productI18ns;

		$gallery = new ProductImage;
		$galleries = $model->productImages;

		$p2c = new Product2category;
		$p2cs = $model->product2categories;

		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
				array(
					'model' => $i18ns,
					'many' => true,
				),
			),
			'product-form'
		);

		if (isset($_POST['Product'])) {
			$model->setAttributes($_POST['Product']);

			$valid = $model->validate();

			$i18ns = array();
			foreach($_POST['ProductI18n'] as $val){
				$va = new ProductI18n;
				$va->setAttributes($val);
				$va->product_id = $model->product_id;

				$valid = $va->validate() && $valid;

				$i18ns[$val['language_id']] = $va;
			}

			$galleries = array();
			if(isset($_POST['ProductImage']) && is_array($_POST['ProductImage'])){
				foreach($_POST['ProductImage'] as $val){
					$va = new ProductImage;
					$va->setAttributes($val);
					$va->product_id = 0;

					$valid = $va->validate() && $valid;

					$galleries[] = $va;
				}
			}

			$p2cs = array();
			if(isset($_POST['Product2category']) && is_array($_POST['Product2category'])){
				foreach($_POST['Product2category'] as $val){
					$va = new Product2category;
					$va->setAttributes($val);
					$va->product_id = 0;

					$valid = $va->validate() && $valid;

					$p2cs[] = $va;
				}
			}

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					$criteria = new CDbCriteria;
					$criteria->compare('product_id', $model->product_id);

					ProductI18n::model()->deleteAll($criteria);
					foreach($i18ns as $va){
						$va->save(false);
					}

					ProductImage::model()->deleteAll($criteria);
					foreach($galleries as $va){
						$va->product_id = $model->product_id;
						$va->save(false);
					}

					Product2category::model()->deleteAll($criteria);
					foreach($p2cs as $va){
						$va->product_id = $model->product_id;
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
			'gallery' => $gallery,
			'galleries' => $galleries,
			'p2c' => $p2c,
			'p2cs' => $p2cs,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id, 'Product');

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
			$selected = Yii::app()->getRequest()->getPost('selected');

			$criteria= new CDbCriteria;
			$criteria->compare('product_id', $selected);

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
			$editIds = array_keys($editPosts);

			$errorModel = null;

			$model = new Product;

			$criteria= new CDbCriteria;
			$criteria->compare('product_id', $editIds);

			$models = Product::model()->findAll($criteria);

			foreach ($models as $model){
				$model->setAttributes($editPosts[$model->product_id]);
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