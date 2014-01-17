<?php
/**
 * @author Sam@ozchamp.net
 * @example
 * for multiple language model
 *
	1. AR read like this :

 	$model = $this->loadModel(1, 'Category');
	// Getting language i18n like this
	var_dump($model->categoryI18ns->title);
	// Getting language i18n specified like this
	var_dump($model->categoryI18ns(array('scopes' => array('t' => array(Yii::app()->params->languages['en_us']->language_id))))->title);

	2. ARS read like this :
	$model = new Category('search');
	$i18n = new CategoryI18n('search');
	$model->filterI18n = $i18n;
	$data = $model->search()->getData();
	$pagination = $model->search()->getPagination();
	// Widget actually output in view
	$this->widget('ELinkPager',array('pages' => $pagination));
	...
	// Getting language i18n like this
	var_dump($data[0]->categoryI18ns->title);
	// Getting language i18n specified like this
	var_dump($data[0]->categoryI18ns(array('scopes' => array('t' => array(Yii::app()->params->languages['en_us']->language_id))))->title);

	3. ARS specified pagesize read like this :
	$model = new Information('search');
	$i18n = new InformationI18n('search');
	$model->filterI18n = $i18n;
	$provider = $model->search();
	$provider->pagination->pageSize = 3;
	$data = $provider->getData();
	var_dump($data);
	$pagination = $provider->getPagination();
	// Widget actually output in view
	$this->widget('ELinkPager',array('pages' => $pagination));
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