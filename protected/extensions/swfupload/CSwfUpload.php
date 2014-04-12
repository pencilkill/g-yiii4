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
	 * $pic, the image attribute to show
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

    public function run()
    {
		$assets = dirname(__FILE__).'/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
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
            	'attribute' => $this->attribute,
            	//'languages' => CHtml::listData($this->controller->languages, 'language_id', 'code'),
            ),
            'custom_settings' => array(
            	'assets'=>$baseUrl,
            	'loginRequiredAjaxResponse' => Yii::app()->user->loginRequiredAjaxResponse,
            	'loginRequiredReturnUrl' => CHtml::normalizeUrl(array('site/index')),
            ),
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
		   	'custom_settings'=>array('upload_target'=>'divFileProgressContainer'.$id),
		   	'button_placeholder_id'=>'swfupload'.$id,
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

		// thumb
		$thumb = CMap::mergeArray(array('width'=>120, 'height'=>120, 'master'=>Image::AUTO), $this->thumb);
		$config['post_params']['thumb'] = $thumb;
		// attribute
		$attributes = $this->normalizeAttribute($this->attributes);
		$config['post_params']['attributes'] = $attributes;


		$config = CMap::mergeArray($config, $this->config);
		$config = CJavaScript::encode($config);

		Yii::app()->getClientScript()->registerScript($id, "var {$id}; {$id} = new SWFUpload($config);");

		$listView = $this->listView ? $this->listView : self::LIST_VIEW;
		$imageView = $this->imageView ? $this->imageView : self::IMAGE_VIEW;

		$items= array();

		if($this->photos){
			$photos = $this->photos();

			$fullPath = Yii::getPathOfAlias('webroot').'/';

			$photo = null;

			foreach ($photos as $image) {
				if($photo == null) $photo = $image;

				if( ! is_file($fullPath . $image->{$this->attribute})) continue;
				// thumb
				$src = Yii::app()->image->load($fullPath.$image->pic)
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

		$this->render($listView,array(
			'id' => $id,
			'items' => $items,
		));

    }

    protected function photos(){
    	$photos = array();

    	if(is_array($this->photos)){
    		$photos = $this->photos;
    	}elseif(is_object($this->photos)){
    		if($this->photos instanceof CActiveRecord){
    			$photos = array($this->photos);
    		}elseif($this->photos instanceof CDbCriteria){
    			// todo
    		}
    	}elseif(is_string($this->photos) && strpos($this->photos, '.')){
    		// As relation
    		list($class, $pk, $relationName) = explode('.', $this->photos);

    		if(class_exists($class) && is_subclass_of($class, CActiveRecord)){
    			$model = $class::model()->findByPk($pk);

    			$relations = $model->relations();

    			if(array_key_exists($relationName, $relations)){
    				$relation = $relations[$relationName];

    				if($relation[0] === CActiveRecord::HAS_ONE || $relation[0] === CActiveRecord::BELONGS_TO){
    					$photos = array($model->{$relationName});
    				}elseif($relation[0] === CActiveRecord::HAS_MANY || $relation[0] === CActiveRecord::MANY_MANY){
    					$photos = $model->{$relationName};
    				}
    			}
    		}
    	}

    	return $photos;
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