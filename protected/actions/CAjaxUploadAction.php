<?php

/**
 * CAjaxUploadAction class file.
 *
 * @author Sam, sam@ozchamp.net
 */
class CAjaxUploadAction extends CAction
{
	const INSTANCE_NAME = 'userfile';
	/**
	 * Common instance name
	 */
	public $instanceName = self::INSTANCE_NAME;
	/**
	 *
	 */
	public $model;
	/**
	 *
	 */
	public $attributes;
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
			$class = CHtml::modelName($model);

			$model = new $class($scenario);

			$files = $this->getInstance();

			if(!$files){
				$severData['error'] = 'Error: no file!';
			}else{
				foreach($files as $file){
					if($file->hasError()){
						$severData['error'] .= 'Error: ' . $file->getName() . ', ' . $file->getError() . "\n\n";
					}
				}
			}

			if(isset($severData['error'])){
				echo json_encode($severData);

				Yii::app()->end();
			}

			$model->$attributes = $files;

			$model->validate(array(array_keys($files)));

			foreach($files as $attribute => $file){
				if($error = $model->getError($attribute)){
					$severData['error'] .= 'Error: ' . $file->getName() . ', ' .  $error . "\n\n";
				}
			}

			if(isset($severData['error'])){
				echo json_encode($severData);

				Yii::app()->end();
			}

			if(isset($files[$this->instanceName])){
				$severData = $this->saves($model, $files, $files[$this->instanceName]);
				$severData['multiple'] = false;
			}else if(is_scalar($this->attributes) && isset($files[$this->attributes])){
				$severData = $this->saves($model, $files, $files[$this->attributes]);
				$severData['multiple'] = false;
			}else{
				$severData = $this->saves($model, $files);
				$severData['multiple'] = true;
			}

			echo json_encode($severData);
		}catch(Exception $e){
			$severData['error'] = $e->getMessage();

			echo json_encode($severData);
		}
		Yii::app()->end();
	}

	protected function getInstance($model){
		$files = array();

		$instances = is_array($this->attributes) ? $this->attributes : array($this->attributes);
		foreach($instances as $name){
			$file = CUploadedFile::getInstance($model, $name);

			if($file){
				$files[$name] = $file;
			}
		}

		if($this->instanceName){
			$instanceName = Yii::app()->getRequest()->getParam('instanceName', $this->instanceName);

			$file = CUploadedFile::getInstanceByName($instanceName);

			if($file){
				if(is_array($this->attributes)){
					$files[$instanceName] = $file;
				}else{
					$files[$this->attributes] = $file;
				}
			}
		}

		return $files;
	}

	protected function saves($model, $files, $name = null){
		if($name){
			$name = is_array($nam) ? $name : array($name);
		}

		$files = array_intersect_key($files, $name);

		$saves = array();
		foreach ($files as $name => $file){
			$saves[$name] = $this->save($model, $file);
		}

		return $saves;
	}

	protected function save($model, $file){
		// path is relative webroot
		$path = $this->formatName($model, $this->path);

		$fullPath = Yii::getPathOfAlias('webroot').'/'.$path.'/';
		is_dir($fullPath) || CFileHelper::mkdir($fullPath);

		//wtf, cache outputs the same image sometimes when using function uniqid() to rename file ...
		$rename = $this->formatName($model, $this->rename) . $file->extensionName;

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
	}
	/**
	 * format path regex \w
	 *
	 * @param $model
	 * @return string
	 */
	protected function formatPath($model, $path){
		$path = (string)$path;

		$replace = false;

		if(strlen($path)){
			$replace = true;

			$path = preg_replace('/[^\w\/\{\}]+/', '_', realPath($path));

			while($replace && preg_match('/\/\{(\w+)}\//i', $path, $matches)){
				unset($matches[0]);

				foreach($matches as $attribute){
					$value = CHtml::value($model, $attribute);

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
			$path = Yii::app()->getParams()->uploadDir.'/'.date('Y/m/d');
		}else{
			$path = preg_replace('/(\\+|\/+)/', '/', $path);
		}

		return trim($path, '/');
	}

	protected function formatName($model, $name){
		$name = (string)$name;

		$replace = false;

		if(strlen($name)){
			$replace = true;

			$name = preg_replace('/[^\w\{\}]+/', '_', $name);

			while($replace && preg_match('/\/\{(\w+)}\//i', $name, $matches)){
				unset($matches[0]);

				foreach($matches as $attribute){
					$value = CHtml::value($model, $attribute);

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