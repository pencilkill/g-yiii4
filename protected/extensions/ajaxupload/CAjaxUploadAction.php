<?php
Yii::import('frontend.extensions.ajaxupload.AjaxUploadWidget');
/**
 * CAjaxUploadAction class file.
 *
 * @author @author Sam <mail.song.de.qiang@gmail.com>
 */
class CAjaxUploadAction extends CAction
{
	/**
	 * Common instance name
	 */
	public $instanceName = AjaxUploadWidget::AJAX_FILE_NAME;
	/**
	 *
	 */
	public $model;
	/**
	 *
	 */
	public $attribute;
	/**
	 *
	 */
	public $scenario;
	/**
	 * $path, which is relative webroot, default as Yii::app()->getParams()->uploadDir.'/'.date('Y/m/d')
	 *
	 * It support to be a format like {model}.{attrbute1}.{attrbute2}
	 */
	public $path;
	/**
	 * $rename, default call uniqid() as basename(without extensionName)
	 *
	 * It support to be a format like {model}.{attrbute1}.{attrbute2}
	 */
	public $rename;

	/**
	 * Runs the action.
	 */
	public function run()
	{
		$severData = array();
		try{
			$model = $this->getModelInstance();

			$attribute = $this->attribute;

			$file = $this->getInstance($model);

			if(!$file){
				$severData['error'] = Yii::t('app', 'Upload Failure');
			}else{
				if($file->getHasError()){
					$severData['error'] = $file->getError();
				}
			}

			if(isset($severData['error'])){
				echo json_encode($severData);

				Yii::app()->end();
			}

			if($model && $model instanceof CActiveRecord && $attribute){
				$model->$attribute = $file;

				$model->validate(array($attribute));

				if($error = $model->getError($attribute)){
					$severData['error'] = $error;

					echo json_encode($severData);

					Yii::app()->end();
				}
			}

			$severData = $this->save($file, $model);

			echo json_encode($severData);
		}catch(Exception $e){
			$severData['error'] = $e->getMessage();

			echo json_encode($severData);
		}
		Yii::app()->end();
	}

	protected function getInstance($model = null){
		$file = null;

		if($this->instanceName){
			$instanceName = Yii::app()->getRequest()->getParam('instanceName', $this->instanceName);

			$file = CUploadedFile::getInstanceByName($instanceName);
		}elseif($model && $model instanceof CActiveRecord && $this->attribute && is_scalar($this->attribute)){
			$file = CUploadedFile::getInstance($model, $this->attribute);
		}

		return $file;
	}

	protected function getModelInstance(){
		$class = CHtml::modelName($this->model);

		$model = null;

		if($class){
			if($id = Yii::app()->getRequest()->getParam('id')){
				$model = $class::model()->findByPk($id);

				if($this->scenario){
					$model->seenario = $this->scenario;
				}
			}else{
				$model = new $class($this->scenario);
			}
		}

		return $model;
	}

	protected function save($file, $model = null){
		// path is relative webroot
		$path = $this->formatName($this->path, $model);

		$fullPath = Yii::getPathOfAlias('webroot').'/'.$path.'/';
		is_dir($fullPath) || CFileHelper::mkdir($fullPath);

		//wtf, cache outputs the same image sometimes when using function uniqid() to rename file ...
		$rename = $this->formatName($this->rename, $model) . $file->extensionName;

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

		return $severData;
	}
	/**
	 * format path regex \w
	 *
	 * @param $model
	 * @return string
	 */
	protected function formatPath($path, $model=null){
		$path = (string)$path;

		$replace = false;

		if(strlen($path)){
			$replace = true;

			$path = preg_replace('/[^\w\/\{\}]+/', '_', realPath($path));

			while($replace && preg_match('/\/\{(\w+)}\//i', $path, $matches)){
				unset($matches[0]);

				foreach($matches as $attribute){
					$value = '';

					if($model && $model instanceof CActiveRecord){
						$value = CHtml::value($model, $attribute);
					}

					if(!preg_match('/[^\w]+/', $value)){
						$path = strtr($path, array('{' . $attribute . '}' => $value));
					}else{
						$replace = false;

						break;
					}
				}
			}

		}

		if($replace === false){
			$path = date('Y/m/d');
		}else{
			$path = preg_replace('/(\\+|\/+)/', '/', $path);
		}

		// path should be under specified directory
		$path = Yii::app()->getParams()->uploadDir.'/'.trim($path, '/');

		return $path;
	}

	protected function formatName($name, $model = null){
		$name = (string)$name;

		$replace = false;

		if(strlen($name)){
			$replace = true;

			$name = preg_replace('/[^\w\{\}]+/', '_', $name);

			while($replace && preg_match('/\/\{(\w+)}\//i', $name, $matches)){
				unset($matches[0]);

				foreach($matches as $attribute){
					$value = '';

					if($model && $model instanceof CActiveRecord){
						$value = CHtml::value($model, $attribute);
					}

					if(!preg_match('/[^\w]+/', $value)){
						$name = strtr($name, array('{' . $attribute . '}' => $value));
					}else{
						$replace = false;

						break;
					}
				}
			}

		}

		if($replace === false){
			$name = uniqid();
		}

		return $name;
	}
}