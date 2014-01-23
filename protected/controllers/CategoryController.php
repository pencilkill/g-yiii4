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

		$model->filterInstance();

		$model->filter->categoryI18n = new CategoryI18n('search');
		$model->filter->categoryI18n->unsetAttributes();

		if (isset($_GET['Category'])){
			$model->setAttributes($_GET['Category']);
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionView($id) {
		$model = $this->loadModel($id, 'Category');

		//Yii::app()->clientScript->registerMetaTag($model->categoryI18n->keywords, 'keywords', null, null, 'keywords');
    	//Yii::app()->clientScript->registerMetaTag($model->categoryI18n->description, 'description', null, null, 'description');

		$this->render('view', array(
			'model' => $model,
		));
	}

}