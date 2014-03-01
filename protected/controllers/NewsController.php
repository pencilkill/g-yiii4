<?php


class NewsController extends GxController {

	public function actionIndex() {
		$model = new News('search');
		$model->unsetAttributes();

		$i18n = new NewsI18n('search');
		$i18n->unsetAttributes();

		$model->filterI18n = $i18n;

		if (isset($_GET['News'])){
			$model->setAttributes($_GET['News']);
		}

		if (isset($_GET['NewsI18n'])){
			$i18n->setAttributes($_GET['NewsI18n']);
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionView($id) {
		$model = $this->loadModel($id, 'News');

		//Yii::app()->clientScript->registerMetaTag($model->newsI18ns->keywords, 'keywords', null, null, 'keywords');
    	//Yii::app()->clientScript->registerMetaTag($model->newsI18ns->description, 'description', null, null, 'description');

		$this->render('view', array(
			'model' => $model,
		));
	}

}