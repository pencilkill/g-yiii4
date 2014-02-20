<?php
/**
 * @author Sam@ozchamp.net
 *
 */
class SiteController extends GxController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		Yii::app()->shoppingCart->clear();

		$p = Product::model()->findByPk(4);

		Yii::app()->shoppingCart->put($p, 5);

		$p = Product::model()->findByPk(5);

		Yii::app()->shoppingCart->put($p);

		echo Yii::app()->shoppingCart->getCount();
		echo '<br/>';
		echo Yii::app()->shoppingCart->getItemsCount();
		echo '<br/>';
		echo Yii::app()->shoppingCart->getCost();
		//
		$this->render('//site/index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
			echo $error['message'];
			else
			$this->render('error', $error);
		}
	}

	public function actionLogin()
	{
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


	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Notice: the parameters url and name should be type of HCUrl::encode separator from each other
	 * @param $url, fileurl
	 * @param $name, download name
	 */
	public function actionDownload($url, $name){
		return HCOutput::file($url, $name);
	}
}