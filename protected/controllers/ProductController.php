<?php


class ProductController extends GxController {

	public function actionIndex() {
		$model = new Product('search');
		$model->unsetAttributes();

		$i18n = new ProductI18n('search');
		$i18n->unsetAttributes();

		$model->filterI18n = $i18n;

		if (isset($_GET['Product'])){
			$model->setAttributes($_GET['Product']);
		}

		if (isset($_GET['ProductI18n'])){
			$i18n->setAttributes($_GET['ProductI18n']);
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionView($id) {
		$model = $this->loadModel($id, 'Product');

		//Yii::app()->clientScript->registerMetaTag($model->productI18ns->keywords, 'keywords', null, null, 'keywords');
    	//Yii::app()->clientScript->registerMetaTag($model->productI18ns->description, 'description', null, null, 'description');

		$this->render('view', array(
			'model' => $model,
		));
	}

}