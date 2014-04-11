<?php

class SiteController extends Controller
{

	/**
	 * Cause the RBAC module rights can not get actions returned from controller->actions() well
	 * Allowedactions() authorize for guest role here and
	 * RBAC rights will authorize nothing for guest role
	 */
	public function allowedActions(){
		return 'error, login, logout, captcha';
	}
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'minLength'=>6,
				'maxLength'=>6,
				'testLimit'=>1,
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
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = '//layouts/login';

		$model=new LoginForm;

		// if it is ajax validation request
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		*/

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				$this->redirect(Yii::app()->user->returnUrl);
			}else{
				$this->refresh();
			}
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
			$instanceName = Yii::app()->getRequest()->getParam('instanceName', 'Filedata');

			$file = CUploadedFile::getInstanceByName($instanceName);
			if(!$file || $file->getHasError()){
				echo 'Error: ' . $file->getError();

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
			is_dir($fullPath) || CFileHelper::mkdir($fullPath);

			//wtf, cache outputs the same image sometimes when using function time() to rename file ...
			$rename = Yii::app()->getRequest()->getParam('rename', uniqid().'.'.$file->extensionName);

			// Here should be checked if necessary
			$file->saveAs($fullPath.$rename);

			// thumb
			$resize = array('width'=>120, 'height'=>120, 'master'=>2);
			if(Yii::app()->getRequest()->getParam('resize')){
				$resize = CMap::mergeArray($resize, Yii::app()->getRequest()->getParam('resize'));
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
			$serverData['imageView'] = $this->renderFile($viewFile, array('image'=>$image, 'src'=>$thumbSrc, 'index'=>uniqid(), 'resize' => $resize), true);

//			$serverData['modelClass'] = $modelClass;
//			$serverData['attributes'] = $gallery->getAttributes();
//			$serverData['languages'] = Yii::app()->getRequest()->getParam('languages') ? $this->languages : null;

			// Return the file id to the script
			$serverData['fileid'] = $path.$rename;

			echo 'FILEID:' . json_encode($serverData);
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
			$instanceName = Yii::app()->getRequest()->getParam('instanceName', 'userfile');

			$file = CUploadedFile::getInstanceByName($instanceName);
			if(!$file || $file->getHasError()){
				$severData['error'] = 'Error: ' . $file->getError();

				echo json_encode($severData);

				Yii::app()->end();
			}

			// path is relative webroot
			$path = Yii::app()->getRequest()->getParam('path', Yii::app()->getParams()->uploadDir.'/'.date('Y/m/d'));

			$fullPath = Yii::getPathOfAlias('webroot').'/'.$path.'/';
			is_dir($fullPath) || CFileHelper::mkdir($fullPath);

			//wtf, cache outputs the same image sometimes when using function time() to rename file ...
			$rename = Yii::app()->getRequest()->getParam('rename', uniqid().'.'.$file->extensionName);

			// Here should be checked if necessary
			$file->saveAs($fullPath.$rename);

			$src = '';

			if(strtolower(strchr($file->type, '/', true))=='image'){
				// thumb
				$resize = array('width'=>120, 'height'=>120, 'master'=>2);
				if(Yii::app()->getRequest()->getParam('resize')){
					$resize = CMap::mergeArray($resize, Yii::app()->getRequest()->getParam('resize'));
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

	/**
	 * ajaxupload
	 * @author sam@ozchamp.net
	 * @see ext.imageselect
	 */
	public function actionAjaxCrop(){
		$cropData = array();
		try{
			$instanceName = Yii::app()->getRequest()->getParam('instanceName', 'source');

			$cropData['src'] = $src = trim(Yii::app()->request->getParam($instanceName, NULL));
			$cropData['scale_width'] = $scale_width = (int)Yii::app()->request->getParam('scale_width', NULL);
			$cropData['scale_height'] = $scale_height = (int)Yii::app()->request->getParam('scale_height', NULL);
			$cropData['x1'] = $x1 = (int)Yii::app()->request->getParam('x1', NULL);
			$cropData['y1'] = $y1 = (int)Yii::app()->request->getParam('y1', NULL);
			$cropData['x2'] = $x2 = (int)Yii::app()->request->getParam('x2', NULL);
			$cropData['y2'] = $y2 = (int)Yii::app()->request->getParam('y2', NULL);
			$cropData['width'] = $width = (int)Yii::app()->request->getParam('width', NULL);
			$cropData['height'] = $height = (int)Yii::app()->request->getParam('height', NULL);

			if(($baseUrl = Yii::app()->getBaseUrl(true)) && strpos($src, Yii::app()->getBaseUrl(true)) === 0){
				$src = substr($src, strlen($baseUrl));
			}else if(($baseUrl = Yii::app()->getBaseUrl(false)) && strpos($src, Yii::app()->getBaseUrl(true)) === 0){
				$src = substr($src, strlen($baseUrl));
			}

			$imageFile = Yii::getPathOfAlias('webroot') . '/' . ltrim($src, '/');

			if(!is_file($imageFile)){
				$cropData['error'] = 'Image file is not found!';
			}else if(empty($width) || empty($height) || $x1 < 0 || $y1 < 0){
				// actually, client validate only cause scale
				$cropData['error'] = 'Image parameters is incorrect!';
			}

			list($srcWidth, $srcHeight, $srcType, $srcAttr)= getimagesize($imageFile);

			$cropData['srcWidth'] = $srcWidth;
			$cropData['srcHeight'] = $srcHeight;

			if(empty($srcWidth) || empty($srcHeight)){
				$cropData['error'] = 'Image file can not be detected!';
			}

			$cropData['scaleWidth'] = $scaleWidth = (float)$srcWidth / (float)$scale_width;
			$cropData['scaleHeight'] = $scaleHeight = (float)$srcHeight / (float)$scale_height;

			// Average, better than each dimension ???
			$cropData['scale'] = $scale = ($scaleWidth + $scaleHeight) / 2.0;

			if(($scale + 0.0) == 0.0){
				$cropData['error'] = 'Image scale can not be calculate!';
			}

			if(!isset($cropData['error'])){
				// path is relative webroot
				$path = Yii::app()->getRequest()->getParam('path', Yii::app()->getParams()->uploadDir.'/'.date('Y/m/d'));

				$fullPath = Yii::getPathOfAlias('webroot').'/'.$path.'/';
				is_dir($fullPath) || CFileHelper::mkdir($fullPath);

				//wtf, cache outputs the same image sometimes when using function time() to rename file ...
				$rename = Yii::app()->getRequest()->getParam('rename', uniqid().'.'.CFileHelper::getExtension($imageFile));

				// real size
				$cropData['realX1'] = $realX1 = min($srcWidth, (int)($x1 * $scale));
				$cropData['realY1'] = $realY1 = min($srcHeight, (int)($y1 * $scale));

				$cropData['realWidth'] = $realWidth = max(min($srcWidth, $srcWidth-$realX1, (int)($width * $scale)), 0);
				$cropData['realHeight'] = $realHeight = max(min($srcHeight, $srcHeight-$realY1, (int)($height * $scale)), 0);

				$status = Yii::app()->image->load($imageFile)
											->crop($realWidth, $realHeight, $realY1, $realX1)
											->save($fullPath.$rename);

				if($status){
					$cropData['src'] = $src = $path . '/' . $rename;
				}else{
					$cropData['error'] = 'Failed to crop image!';
				}

				if(!isset($cropData['error'])){
					// thumb
					$resize = array('width'=>120, 'height'=>120, 'master'=>2);
					if(Yii::app()->getRequest()->getParam('resize')){
						$resize = CMap::mergeArray($resize, Yii::app()->getRequest()->getParam('resize'));
					}

					// This will display the thumbnail of the uploaded file to the view
					// image wiget will check whether the file exists
					$cropData['thumb'] = $thumb = Yii::app()->image->load($fullPath.$rename)
													->resize($resize['width'], $resize['height'], $resize['master'])
													->cache();
				}

				echo json_encode($cropData);
			}else{
				echo json_encode($cropData);
			}
		}catch(Exception $e){
			$cropData['error'] = $e->getMessage();

			echo json_encode($cropData);
		}
		Yii::app()->end();
	}

	/**
	 * Notice: the parameters url and name should be type of HCUrl::encode separator from each other
	 * @param $url, fileurl
	 * @param $name, download name
	 */
	public function actionDownload($url, $name){
		return HCOuput::download($url, $name);
	}
}