<?php


class ProductController extends GxController {



	public function actionIndex() {
		$model = new Product('search');
		$model->unsetAttributes();

		$i18n = new ProductI18n('search');
		$i18n->unsetAttributes();

		$model->searchI18n = $i18n;

		if (isset($_GET['Product'])){
			$model->setAttributes($_GET['Product']);
		}

		if (isset($_GET['ProductI18n'])){
			$i18n->setAttributes($_GET['ProductI18n']);
		}

		$this->render('index', array(
			'model' => $model,
			'i18n' => $i18n,
		));
	}

	public function actionCreate() {
		$model = new Product;

		$gallery = new Product2image;
		$galleries = $model->product2images;

		$categoryIds = CHtml::listData($model->product2categories, 'category_id', 'product_id');

		$categories = Category::getCategories(0);

		$i18ns = array();

		foreach($this->languages as $val){
			$i18n = new ProductI18n;
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
			'product-form'
		);

		if (isset($_POST['Product'])) {
			$model->setAttributes($_POST['Product']);

			$valid = true;

			foreach($this->languages as $val){
				$i18ns[$val['language_id']]->setAttributes($_POST['ProductI18n'][$val['language_id']]);
				$i18ns[$val['language_id']]->language_id = $val['language_id'];
				$i18ns[$val['language_id']]->product_id = 0;

				$valid = $i18ns[$val['language_id']]->validate() && $valid;
			}


			if ($valid && $model->validate()) {
				$model->save(false);

				// i18n
				foreach($this->languages as $val){
					$i18ns[$val['language_id']]->product_id = $model->product_id;
					$i18ns[$val['language_id']]->save();
				}

				// images
				if(isset($_POST['Product2image']) && is_array($_POST['Product2image'])){
					foreach ($_POST['Product2image'] as $val) {
						$image = new Product2image;
						$image->setAttributes($val);
						$image->product_id = $model->product_id;
						$image->save();
					}
				}

				// product2categories
				if(isset($_POST['Product']['product2categories']) && is_array($_POST['Product']['product2categories'])){
					foreach ($_POST['Product']['product2categories'] as $val) {
						$product2category = new Product2category;
						$product2category->setAttributes($val);
						$product2category->product_id = $model->product_id;
						$product2category->save();
					}
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
			'gallery' => $gallery,
			'galleries' => $galleries,
			'categories' => $categories,
			'categoryIds' => $categoryIds,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Product');

		$gallery = new Product2image;
		$galleries = $model->product2images;

		$i18ns = $model->productI18ns;

		$categoryIds = CHtml::listData($model->product2categories, 'category_id', 'product_id');

		$categories = Category::getCategories(0);

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
			$valid = true;

			foreach($this->languages as $val){
				$i18ns[$val['language_id']]->setAttributes($_POST['ProductI18n'][$val['language_id']]);
				$i18ns[$val['language_id']]->language_id = $val['language_id'];
				$i18ns[$val['language_id']]->product_id = $model->product_id;

				$valid = $i18ns[$val['language_id']]->validate() && $valid;
			}

			if ($valid && $model->validate()) {
				$model->save(false);

				// I18n
				foreach($this->languages as $val){
					$i18ns[$val['language_id']]->save();
				}

				// images
				Product2image::model()->deleteAllByAttributes(array('product_id'=>$model->product_id));
				if(isset($_POST['Product2image']) && is_array($_POST['Product2image'])){
					foreach ($_POST['Product2image'] as $val) {
						$image = new Product2image;
						$image->setAttributes($val);
						$image->product_id = $model->product_id;
						$image->save();
					}
				}

				// product2categories
				Product2category::model()->deleteAllByAttributes(array('product_id'=>$model->product_id));
				if(isset($_POST['Product']['product2categories']) && is_array($_POST['Product']['product2categories'])){
					foreach ($_POST['Product']['product2categories'] as $val) {
						$product2category = new Product2category;
						$product2category->setAttributes($val);
						$product2category->product_id = $model->product_id;
						$product2category->save();
					}
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
			'gallery' => $gallery,
			'galleries' => $galleries,
			'categories' => $categories,
			'categoryIds' => $categoryIds,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Product')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest()){
				$this->redirect(array('index'));
			}
		} else{
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	}


	public function actionGridviewdelete() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$model = new Product;

			$criteria= new CDbCriteria;
			$criteria->compare('product_id', Yii::app()->getRequest()->getPost('selected'));

			Product::model()->deleteAll($criteria);

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

            $model = new Product;

            $criteria= new CDbCriteria;
            $criteria->compare('product_id', $editIds);

            $models = Product::model()->findAll($criteria);

            foreach ($models as $model){
                $model->setAttributes($editPosts[$model->product_id]);
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