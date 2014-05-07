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
		// logout through action only
		if(! Yii::app()->user->isGuest){
			$this->redirect(Yii::app()->user->returnUrl);
		}

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
	 * @author Sam <mail.song.de.qiang@gmail.com>
	 * @see ext.swfupload.handler.js
	 */
	public function actionSwfUpload()
	{
		try{
			// remember the post params?
			$model = Yii::app()->getRequest()->getParam('model');

			$instanceName = Yii::app()->getRequest()->getParam('instanceName', CSwfUpload::FILE_POST_NAME);

			$file = CUploadedFile::getInstanceByName($instanceName);

			if(!$file){
				echo 'Error: ' .  Yii::t('app', 'Upload Failure');

				Yii::app()->end();
			}elseif($file instanceof CUploadedFile){
				if($file->getHasError()){
					echo 'Error: ' . $file->getError();

					Yii::app()->end();
				}
			}

			$serverData = array();

			// path is relative webroot
			$path = Yii::app()->getRequest()->getParam('path', date('Y/m/d'));
			// path should be under specified directory
			$path = Yii::app()->getParams()->uploadDir.'/'.trim($path, '/');

			$fullPath = Yii::getPathOfAlias('webroot').'/'.$path.'/';
			is_dir($fullPath) || CFileHelper::mkdir($fullPath);

			//wtf, cache outputs the same image sometimes when using function time() to rename file ...
			$rename = Yii::app()->getRequest()->getParam('rename', uniqid().'.'.$file->extensionName);

			// attributes
			$attributes = array();
			if(Yii::app()->getRequest()->getParam('attributes')){
				$attributes = CMap::mergeArray($attributes, Yii::app()->getRequest()->getParam('attributes'));
			}

			$default = array(
				'callback' => 'activeHiddenField',
				'attribute' => ''
			);
			$normalizeAttribute = null;

			$normalizeAttribute = function () use($attributes, $default){
				$results = array();

				foreach ($attributes as $_attribute){
					if(empty($_attribute['attribute'])) continue;

					$result = $default;

					// rebuild index
					foreach($result as $key => $value){
						$result[$key] = isset($_attribute[$key]) ? $_attribute[$key] : $value;
					}

					$results[] = $result;
				}

				return $results;
			};

			$attributes = $normalizeAttribute();

			$image = new $model;

			$validateAttributes = array();
			foreach($attributes as $attribute){
				if(empty($attribute['attribute'])) continue;

				$validateAttributes[] = $attribute['attribute'];

				if(isset($file->{$attribute['attribute']})){
					$image->setAttribute($attribute['attribute'], $file->{$attribute['attribute']});
				}
			}

			// attribute
			$attribute = Yii::app()->getRequest()->getParam('attribute');

			$image->{$attribute} = $file;

			//$image->validate($validateAttributes);
			$image->validate(array($attribute));

			if($error = $image->getError($attribute)){
				echo 'Error: ' . $error;

				Yii::app()->end();
			}

			$image->{$attribute} = $path.'/'.$rename;

			// Here should be checked if necessary
			$file->saveAs($fullPath.$rename);

			// thumb
			$thumb = array('width'=>120, 'height'=>120, 'master'=>Image::AUTO);
			if(Yii::app()->getRequest()->getParam('thumb')){
				$thumb = CMap::mergeArray($thumb, Yii::app()->getRequest()->getParam('thumb'));
			}

			// This will display the thumbnail of the uploaded file to the view
			// image wiget will check whether the file exists
			$src = Yii::app()->image->load($fullPath.$rename)
					->resize($thumb['width'], $thumb['height'], $thumb['master'])
					->cache();

			$serverData['src'] = $src;

			//
			$imageView = Yii::app()->getRequest()->getParam(CSwfUpload::IMAGE_VIEW);
			$imageViewFile=$this->getViewFile($imageView);
			if(empty($imageViewFile)){
				$viewFile = Yii::getPathOfAlias('frontend.extensions.swfupload.views').'/'.CSwfUpload::IMAGE_VIEW.'.php';
			}

			$data = array(
				'src'=>$src,
				'image'=>$image,
				'index'=>uniqid(),
				'thumb' => $thumb,
				'attributes' => $attributes,
			);

			$serverData['imageView'] = $this->renderFile($viewFile, $data, true);

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
	 * @author Sam <mail.song.de.qiang@gmail.com>
	 * @see ext.ajaxupload.handler.js
	 */
	public function actionAjaxUpload()
	{
		$severData = array();
		try{
			$params = array('model' => '', 'attribute' => '', 'id' => '', 'scenario' => '');

			if($_params = Yii::app()->getRequest()->getParam('params')){
				$params = CMap::mergeArray($params, (array)$_params);
			}

			$model = $attribute = $modelInstance = null;

			$modelInstance = function()use(&$model, &$attribute, $params){
				if($params['model'] && $params['attribute']){
					$model = $params['model'];

					$attribute = preg_replace('/\[[^]]*\]/', '', $params['attribute']);

					$scenario = $params['scenario'];

					if($id = $params['id']){
						$model = $model::model()->findByPk($id);

						if($scenario){
							$model->scenario = $scenario;
						}
					}else{
						$model = new $model($scenario);
					}
				}
			};

			$modelInstance();

			$instanceName = Yii::app()->getRequest()->getParam('instanceName', AjaxUploadWidget::AJAX_FILE_NAME);

			$file = CUploadedFile::getInstanceByName($instanceName);

			if(!$file){
				$severData['error'] = Yii::t('app', 'Upload Failure');
			}elseif($file instanceof CUploadedFile){
				if($file->getHasError()){
					$severData['error'] = $file->getError();
				}
			}

			if(isset($severData['error'])){
				echo json_encode($severData);

				Yii::app()->end();
			}

			if($model && $attribute){
				$model->{$attribute} = $file;

				$model->validate(array($attribute));

				if($error = $model->getError($attribute)){
					$severData['error'] = $error;

					echo json_encode($severData);

					Yii::app()->end();
				}
			}

			// path is relative webroot
			$path = Yii::app()->getRequest()->getParam('path', date('Y/m/d'));
			// path should be under specified directory
			$path = Yii::app()->getParams()->uploadDir.'/'.trim($path, '/');

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
	 * ajaxcrop
	 * @author Sam <mail.song.de.qiang@gmail.com>
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

			$src = HCUrl::trim($src);

			$imageFile = Yii::getPathOfAlias('webroot') . '/' . ltrim($src, '/');

			if(!is_file($imageFile)){
				$cropData['error'] = Yii::t('crop', 'Image File Is Not Found');
			}else if(empty($width) || empty($height) || $x1 < 0 || $y1 < 0){
				// actually, client validate only cause scale
				$cropData['error'] = Yii::t('crop', 'Image Parameters Is Incorrect');
			}

			list($srcWidth, $srcHeight, $srcType, $srcAttr)= getimagesize($imageFile);

			$cropData['srcWidth'] = $srcWidth;
			$cropData['srcHeight'] = $srcHeight;

			if(empty($srcWidth) || empty($srcHeight)){
				$cropData['error'] = Yii::t('crop', 'Image File Can Not Be Detected');
			}

			$cropData['scaleX'] = $scaleX = (float)$srcWidth / (float)$scale_width;
			$cropData['scaleY'] = $scaleY = (float)$srcHeight / (float)$scale_height;

			// Average, better than each dimension ???
			$cropData['scale'] = $scale = ($scaleX + $scaleY) / 2.0;

			if(($scale + 0.0) == 0.0){
				$cropData['error'] = Yii::t('crop', 'Image Scale Can Not Be Calculate');
			}

			if(!isset($cropData['error'])){
				// path is relative webroot
				$path = Yii::app()->getRequest()->getParam('path', date('Y/m/d'));
				// path should be under specified directory
				$path = Yii::app()->getParams()->uploadDir.'/'.trim($path, '/');

				$fullPath = Yii::getPathOfAlias('webroot').'/'.$path.'/';
				is_dir($fullPath) || CFileHelper::mkdir($fullPath);

				//wtf, cache outputs the same image sometimes when using function time() to rename file ...
				$rename = Yii::app()->getRequest()->getParam('rename', uniqid().'.'.CFileHelper::getExtension($imageFile));

				// real size
				$cropData['calcX1'] = $calcX1 = min($srcWidth, (int)($x1 * $scale));
				$cropData['calcY1'] = $calcY1 = min($srcHeight, (int)($y1 * $scale));

				$cropData['calcWidth'] = $calcWidth = max(min($srcWidth, $srcWidth-$calcX1, (int)($width * $scale)), 0);
				$cropData['calcHeight'] = $calcHeight = max(min($srcHeight, $srcHeight-$calcY1, (int)($height * $scale)), 0);

				$status = Yii::app()->image->load($imageFile)
											->crop($calcWidth, $calcHeight, $calcY1, $calcX1)
											->save($fullPath.$rename);

				if($status){
					$cropData['src'] = $src = $path . '/' . $rename;
				}else{
					$cropData['error'] = Yii::t('crop', 'Failed To Crop Image');
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