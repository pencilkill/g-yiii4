<?php
/**
 * update by Sam@ozchamp.net
 * @todo multi instance, more example : https://code.google.com/p/swfupload/
 * @author yii extension
 */
class CSwfUpload extends CWidget
{
	const SWF_SCENARIO = __CLASS__;

	const FILE_POST_NAME = 'Filedata';

	const LIST_VIEW = 'listView';
	const IMAGE_VIEW = 'imageView';

	/**
	 *
	 */
	public $jsHandlerUrl;
	/**
	 *
	 */
	public $config=array();
	/*
	 * $photos, can be image models list, or the image relation name
	 */
	public $photos;
	/*
	 * $model, the image model, cause the photos can be empty array,
	 */
	public $model;
	/*
	 * $attribute, the image attribute to show
	 */
	public $attribute = 'pic';
	/*
	 * $attributes,
	 * it should be a two dimension array,
	 *
	 * the first element of each configuration element should be set as a CHtml callback, e.g. activeHiddenField,
	 * model will be unshift for each configuration element to compatiable after shift the CHtml callback(the first element)
	 *
	 * @example
	 * array(
	 * 		array(
	 * 			'callback' => 'activeHiddenField',
	 * 			'attribute' => 'imagetype',
	 * 			'htmlOptions' => array(),
	 * 		),
	 * 		...
	 * )
	 */
	public $attributes = array();
	/**
	 *
	 */
	public $listView = self::LIST_VIEW;
	/**
	 *
	 */
	public $imageView = self::IMAGE_VIEW;
	/**
	 * image resize cinfiguration
	 */
	public $thumb = array(
		'width'=>120,
		'height'=>120,
		'master'=>Image::AUTO
	);

	public function init(){
		parent::init();

		if(empty($this->model)){
			throw new CHttpException(500,'"model" have to be set!');
		}

		if(empty($this->attribute)){
			throw new CHttpException(500,'"attribute" have to be set!');
		}

		// thumb
		$this->thumb = CMap::mergeArray(array('width'=>120, 'height'=>120, 'master'=>Image::AUTO), $this->thumb);
		// attribute
		$this->attributes = $this->normalizeAttribute($this->attributes);
		// photos
		$this->photos = $this->photos();

		if(empty($this->listView)){
			$this->listView = self::LIST_VIEW;
		}
		if(empty($this->imageView)){
			$this->imageView = self::IMAGE_VIEW;
		}
	}

    public function run()
    {
		$assets = dirname(__FILE__).'/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        // use jqery helper
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerScriptFile($baseUrl . '/swfupload.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerCssFile($baseUrl . '/default.css');
		if(isset($this->jsHandlerUrl))
		{
			Yii::app()->clientScript->registerScriptFile($this->jsHandlerUrl);
		}else{
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/swfuploadHandlers.js', CClientScript::POS_HEAD);
		}

		$id = __CLASS__.$this->getId();

		$config = array(
            'upload_url' => CHtml::normalizeUrl(array('site/swfUpload')),
			'flash_url' => $baseUrl. '/swfupload.swf',
            'post_params' => array(
            	'PHPSESSID' => session_id(),
            	'model' => CHtml::modelName($this->model),
            	'attribute' => $this->attribute,
            	'attributes' => $this->attributes,
            	'thumb' => $this->thumb,
            	//'languages' => CHtml::listData(Yii::app()->controller->languages, 'language_id', 'code'),
            ),
            'custom_settings' => array(
            	'assets'=>$baseUrl,
            	'filesContainer' => 'thumbnails'.$id,
            	'upload_target'=>'divFileProgressContainer'.$id,
            	'yiiLoginRequired' => "js:function(){
					var _yiiLoginRequired = false;

					jQuery.ajax({
						url:'".CHtml::normalizeUrl(array('site/index'))."',
						async: false
					}).done(function(data, status, xhr){
						_yiiLoginRequired = (xhr.responseText === '".Yii::app()->user->loginRequiredAjaxResponse."');
					});

					return _yiiLoginRequired;
            	}",
            ),
		   	'button_placeholder_id'=>'swfupload'.$id,
            'file_post_name' => self::FILE_POST_NAME,
            'file_size_limit' => '2 MB',
			'use_query_string'=>false,
			'file_types'=>'*.jpeg;*.jpg;*.png;*.gif',
		   	'file_types_description'=>'Imagenes',
		   	'file_upload_limit'=>0,
		   	'file_queue_error_handler'=>'js:fileQueueError',
		   	'file_dialog_complete_handler'=>'js:fileDialogComplete',
		   	'upload_progress_handler'=>'js:uploadProgress',
		   	'upload_error_handler'=>'js:uploadError',
		   	'upload_success_handler'=>'js:uploadSuccess',
		   	'upload_complete_handler'=>'js:uploadComplete',
		   	'button_width'=>200,
		   	'button_height'=>25,
		   	'button_text'=>'<span class="button">'.Yii::t('app', 'Select A Image').'(2 MB Max)</span>',
		   	'button_text_style'=>'.button { font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif; font-size: 15pt; text-align: center; }',
		   	'button_text_top_padding'=>0,
		   	'button_text_left_padding'=>0,
		   	'button_window_mode'=>'js:SWFUpload.WINDOW_MODE.TRANSPARENT',
		   	'button_cursor'=>'js:SWFUpload.CURSOR.HAND',
			'debug'=>false,
		);

		$config = CMap::mergeArray($config, $this->config);
		$config = CJavaScript::encode($config);
		//
		Yii::app()->getClientScript()->registerScript($id, "var {$id}; {$id} = new SWFUpload($config);");

		$items= $this->items();

		$this->render($this->listView,array(
			'id' => $id,
			'items' => $items,
		));

    }

    protected function photos(){
    	$photos = array();

    	$modelName = CHtml::modelName($this->model);

    	if(is_array($this->photos)){
    		// check instanceof ???
    		$photos = $this->photos;
    	}elseif(is_object($this->photos)){
    		if($this->photos instanceof $modelName){
    			$photos = array($this->photos);
    		}elseif($this->photos instanceof CDbCriteria){
    			$criteria = $this->photos;

    			$photos = $modelName::model()->findAll($criteria);
    		}
    	}elseif(is_string($this->photos) && strpos($this->photos, '.')){
    		// As relation
    		list($class, $pk, $relationName) = explode('.', $this->photos);

    		if($class && $pk && $relationName && class_exists($class) && $class instanceof CActiveRecord && ($model = $class::model()->findByPk($pk))){
    			$relations = $model->relations();

    			if(array_key_exists($relationName, $relations)){
    				$relation = $relations[$relationName];

    				if(isset($relation[0], $relation[1])){
	    				$relationModelName = isset($relation[1]) ? $relation[1] : '';

	    				if($relationModelName === $modelName){
		    				if($relation[0] === CActiveRecord::HAS_ONE || $relation[0] === CActiveRecord::BELONGS_TO){
		    					$photos = array($model->{$relationName});
		    				}elseif($relation[0] === CActiveRecord::HAS_MANY || $relation[0] === CActiveRecord::MANY_MANY){
		    					$photos = $model->{$relationName};
		    				}
	    				}
    				}
    			}
    		}
    	}

    	return $photos;
    }

    protected function items($fullPath = null){
    	$items = array();

    	if(empty($fullPath)){
    		$fullPath = Yii::getPathOfAlias('webroot').'/';
    	}

    	if($photos = $this->photos){
    		$thumb = $this->thumb;
    		$attributes = $this->attributes;
    		$imageView = $this->imageView;

	    	foreach ($photos as $image) {
	    		$file =$fullPath . $image->{$this->attribute};;

	    		if(!is_file($file)) continue;

	    		// thumb
	    		$src = Yii::app()->image->load($file)
	    				->resize($thumb['width'], $thumb['height'], $thumb['master'])
	    				->cache();

	    		$index = uniqid();

	    		$data = array(
	    			'src'=>$src,
	    			'image'=>$image,
	    			'index'=>$index,
	    			'thumb' => $thumb,
	    			'attributes' => $attributes,
	    		);

	    		$items[CHtml::modelName($image) . '_item_' . $index] = $this->render($imageView, $data, true);
	    	}
    	}

    	return $items;
    }

    protected function normalizeAttribute($attributes, $default = array('callback' => 'activeHiddenField', 'attribute' => '')){
    	$results = array();

    	$push = true;

    	foreach ($attributes as $attribute){
    		if(empty($attribute['attribute'])) continue;

    		if($attribute['attribute'] == $this->attribute && $push) $push = false;

    		$result = $default;

    		// rebuild index
    		foreach($result as $key => $value){
    			$result[$key] = isset($attribute[$key]) ? $attribute[$key] : $value;
    		}

    		$results[] = $result;
    	}

    	if($push){
    		$result = $default;

    		$result['attribute'] = $this->attribute;

    		$results[] = $result;
    	}

    	return $results;
    }
}