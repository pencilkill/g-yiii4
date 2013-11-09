<?php


class CategoryController extends GxController {


	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			/*
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'testLimit'=>1,
			),
			*/
		);
	}

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

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionView($id) {
		$model = $this->loadModel($id, 'Category');

		//Yii::app()->clientScript->registerMetaTag($model->categoryI18ns->keywords, 'keywords', null, null, 'keywords');
    	//Yii::app()->clientScript->registerMetaTag($model->categoryI18ns->description, 'description', null, null, 'description');

		$this->render('view', array(
			'model' => $model,
		));
	}

}