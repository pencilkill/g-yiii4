<?php
/**
 * @todo the js callback function will thrown undefined error
 * @author Sam@ozchamp.net
 * @copyright www.ozchamp.net
 * @version 1.0
 *
 *
 */
class AjaxImageUploadWidget extends CInputWidget
{
	public $jsHandlerUrl;

	public $settings=array();

	/**
	 * image cache parameters
	 * @see ext.image
	 * @var Array
	 */
	public $imageCache=array();

	public function init()
	{
    	parent::init();

		if(!isset($this->htmlOptions['id'])){
			if(!isset($this->model)){
				throw new CHttpException(500,'"model" have to be set!');
			}
			if(!isset($this->attribute)){
				throw new CHttpException(500,'"attribute" have to be set!');
			}
			$this->htmlOptions['id']=CHtml::activeId($this->model, $this->attribute);
    	}
	}

    public function run()
    {
		$assets = dirname(__FILE__).'/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
		Yii::app()->clientScript->registerScriptFile($baseUrl . '/ajaxupload.js', CClientScript::POS_HEAD);
		if(isset($this->jsHandlerUrl))
		{
			Yii::app()->clientScript->registerScriptFile($this->jsHandlerUrl, CClientScript::POS_HEAD);
			unset($this->jsHandlerUrl);
		}else{
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/handler.js', CClientScript::POS_HEAD);
		}

		// default thumb setting
		$imageCache = array('resize'=>array('width' => 120, 'height' => 120));
		$imageCache = CMap::mergeArray($imageCache, $this->imageCache);

		if(isset($this->htmlOptions['value'])){
			$value = $this->htmlOptions['value'];
			unset($this->htmlOptions['value']);
		}else if(isset($this->value)){
			$value = $this->value;
		}else if(isset($this->model, $this->attribute)){
			$value = CHtml::resolveValue($this->model, $this->attribute);
		}else{
			$value = '';
		}

		if(isset($this->htmlOptions['name'])){
			$name = $this->htmlOptions['name'];
			unset($this->htmlOptions['name']);
		}else if(isset($this->name)){
			$name = $this->name;
		}else if(isset($this->model, $this->attribute)){
			$name = CHtml::activeName($this->model, $this->attribute);
		}else{
			$name = '';
		}

		// thumb
		$preview = HCSite::cache($value, $imageCache);
		// thumb no image
		$previewX = HCSite::cache(null, $imageCache);

		$prefix = $this->htmlOptions['id'];

		$settings = array(
            'action'=>CHtml::normalizeUrl(Yii::app()->createUrl('site/ajaxUpload')),
            //'name'=>'userfile',
            'data'=>array(),
			//'autoSubmit'=>true,
			//'responseType'=>'json',
		   	//'hoverClass'=>'hover',
		   	//'disabledClass'=>'disabled',
		   	//'onChange'=>'js:function(file, extension){imageChange(file, extension);}',	// thrown undefined
		   	//'onSubmit'=>'js:function(file, extension){imageSubmit(file, extension);}',	// thrown undefined
		   	//'onComplete'=>'js:function(file, extension){imageComplete(file, json);}',		// thrown undefined
		   	'baseUrl'=>$baseUrl
		);


		$settings = CMap::mergeArray($settings, $this->settings);
		$settings = CJavaScript::encode($settings);

		// register id append $prefix to make sure unique
		Yii::app()->getClientScript()->registerScript(__CLASS__.$prefix, "jQuery('#{$prefix}').ajaxUploadHandler($settings);");

		$this->render('image', array(
			'name' => $name,
			'value' => $value,
			'htmlOptions' => $this->htmlOptions,
			'prefix' => $prefix,
			'preview' => $preview,
			'previewX' => $previewX,
			'resize' => $imageCache['resize'],
		));
    }

}