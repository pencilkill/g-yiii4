<?php


class CustomerController extends GxController {

	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				//'backend'=>'',
				//'fontFile'=>'',
				//'foreColor'=>'',
				'offset'=>0,
				'transparent'=>false,
				'padding'=>2,
				'height'=>50,
				'width'=>120,
				'minLength'=>5,
				'maxLength'=>5,
				'testLimit'=>1,
			),
		);
	}

	public function filters() {
		return array(
			'accessControl',
		);
	}

	public function accessRules() {
		return array(
			array('allow',
				'actions'=>array('register', 'activate', 'login'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('edit'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionRegister(){
		$model=new Customer;

		$this->performAjaxValidation($model);

		// collect user input data
		if(isset($_POST['Customer']))
		{
			$model->setAttributes($_POST['Customer']);

			// status
			$model->status = 0;
			// token
			$token = md5(uniqid());
			$model->token = $token;

			if($model->validate()){
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);

					$transaction->commit();

					// send check mail
					// TODO

					Yii::app()->user->setFlash('success', Yii::t('app', 'Please check your email: {email} to activate your account before login'));

					$this->redirect(array('site/success'));
				}catch(CDbException $e){
                    $transaction->rollback();

                    Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
                }
			}
		}

		$this->render('register',array('model'=>$model));
	}

	public function actionActivate(){
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLogin(){
		$model=new LoginForm;

		$this->performAjaxValidation($model, 'login-form');

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionEdit(){
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout(){
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

}