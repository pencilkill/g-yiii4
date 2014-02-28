<?php


class CustomerController extends GxController {


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
		$model = new Customer('search');
		$model->unsetAttributes();

		if (isset($_GET['Customer'])){
			$model->setAttributes($_GET['Customer']);
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionView($id) {
		$model = $this->loadModel($id, 'Customer');


		$this->render('view', array(
			'model' => $model,
		));
	}

}