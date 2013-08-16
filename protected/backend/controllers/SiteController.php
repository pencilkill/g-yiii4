<?php

class SiteController extends Controller
{

	public function allowedActions()
	{
		return 'error, login, logout, captcha';
	}

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
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
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

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = '//layouts/login';

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

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * swfuplod
	 * @author sam@ozchamp.net
	 * @see ext.swfupload.handler.js
	 */
	public function actionSwfUpload()
	{
		try{
			$file = CUploadedFile::getInstanceByName('Filedata');
			if(!$file || $file->getHasError()){
				echo 'Error: Documento Invalido';
				Yii::app()->end();
			}

			$serverData = array();

			// remember the post params?
			$modelClass = Yii::app()->getRequest()->getParam('modelClass');

			// check modelClass though model file
			if(empty($modelClass) || !is_file(Yii::getPathOfAlias('backend.models').'/'.$modelClass.'.php')){
				echo 'Error: Model Invalido';
				Yii::app()->end();
			}

			// path is relative webroot
			$path = Yii::app()->getRequest()->getParam('path', Yii::app()->getParams()->uploadDir.'/'.date('Y/m/d'));

			$fullPath = Yii::getPathOfAlias('webroot').'/'.$path.'/';
			is_dir($fullPath) || mkdir($fullPath, true, 0777);

			//wtf, cache outputs the same image sometimes when using function time() to rename file ...
			$rename = Yii::app()->getRequest()->getParam('rename', uniqid().'.'.$file->extensionName);

			// Here should be checked if necessary
			$file->saveAs($fullPath.$rename);

			// thumb
			$resize = array('width'=>120, 'height'=>120, 'master'=>2);
			if(Yii::app()->getRequest()->getParam('resize')){
				$resize = array_merge_recursive($resize, Yii::app()->getRequest()->getParam('resize'));
			}
			// This will display the thumbnail of the uploaded file to the view
			// image wiget will check whether the file exists
			$thumbSrc = Yii::app()->image->load($fullPath.$rename)
					->resize($resize['width'], $resize['height'], $resize['master'])
					->cache();
			
			$serverData['attributes']['name'] = $file->name;
			$serverData['attributes']['type'] = $file->type;
			$serverData['attributes']['pic'] = $path.'/'.$rename;
		
			$serverData['thumbSrc'] = $thumbSrc;
			
			$image = new $modelClass;
			$image->setAttributes($serverData['attributes']);
			
			$imageView = Yii::app()->getRequest()->getParam('imageView');
			$imageViewFile=$this->getViewFile($imageView);
			if(empty($imageViewFile)){
				$viewFile = Yii::getPathOfAlias('frontend.extensions.swfupload.views').'/imageView.php';
			}
			$serverData['imageView'] = $this->renderFile($viewFile, array('image'=>$image, 'src'=>$thumbSrc, 'index'=>uniqid()), true);
			
//			$serverData['modelClass'] = $modelClass;
//			$serverData['attributes'] = $gallery->getAttributes();
//			$serverData['languages'] = Yii::app()->getRequest()->getParam('languages') ? $this->languages : null;

			// Return the file id to the script
			$serverData['fileid'] = $path.$rename;

			echo "FILEID:".json_encode($serverData);
		}catch(Exception $e){
			echo 'Error: ' . $e->getMessage();
		}
		Yii::app()->end();
	}
	
	/**
	 * ajaxupload
	 * @author sam@ozchamp.net
	 * @see ext.ajaxupload.handler.js
	 */
	public function actionAjaxUpload()
	{
		$severData = array();
		try{
			$file = CUploadedFile::getInstanceByName('userfile');
			if(!$file || $file->getHasError()){
				$severData['error'] = 'Documento Invalido';
				echo json_encode($severData);
				Yii::app()->end();
			}

			// path is relative webroot
			$path = Yii::app()->getRequest()->getParam('path', Yii::app()->getParams()->uploadDir.'/'.date('Y/m/d'));

			$fullPath = Yii::getPathOfAlias('webroot').'/'.$path.'/';
			is_dir($fullPath) || mkdir($fullPath, true, 0777);

			//wtf, cache outputs the same image sometimes when using function time() to rename file ...
			$rename = Yii::app()->getRequest()->getParam('rename', uniqid().'.'.$file->extensionName);

			// Here should be checked if necessary
			$file->saveAs($fullPath.$rename);
			
			$src = '';

			if(strtolower(strchr($file->type, '/', true))=='image'){
				// thumb
				$resize = array('width'=>120, 'height'=>120, 'master'=>2);
				if(Yii::app()->getRequest()->getParam('resize')){
					$resize = array_merge($resize, Yii::app()->getRequest()->getParam('resize'));
				}
				// This will display the thumbnail of the uploaded file to the view
				// image wiget will check whether the file exists
				$src = Yii::app()->image->load($fullPath.$rename)
						->resize($resize['width'], $resize['height'], $resize['master'])
						->cache();
			}
			
			$severData['file'] = $path.'/'.$rename;
			$severData['src'] = $src;
			$severData['success'] = Yii::t('app', 'Upload Successfully');
			
			echo json_encode($severData);
		}catch(Exception $e){
			$severData['error'] = $e->getMessage();
			echo json_encode($severData);
		}
		Yii::app()->end();
	}
}