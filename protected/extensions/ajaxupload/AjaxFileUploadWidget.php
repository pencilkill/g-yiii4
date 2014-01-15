<?php
/**
 * @author Sam@ozchamp.net
 * @copyright www.ozchamp.net
 * @version 1.0
 *
 *
 */
class AjaxFileUploadWidget extends CInputWidget
{
	public $jsHandlerUrl;

	public $settings=array();

	/**
	 * force download url
	 * using target="_blank" link instead of force download if it is empty
	 * @var String
	 */
	public $previewUrl;

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

		// preview , value
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

		$preview = $value;

		if(isset($this->previewUrl) && is_array($this->previewUrl)){
			$previewUrlParam = array('file' => $value);
			if(isset($this->previewUrl[1])){
				$previewUrlParam = CMap::mergeArray($previewUrlParam, $this->previewUrl[1]);
			}

			$preview = Yii::app()->getUrlManager()->createUrl($this->previewUrl[0], $previewUrlParam);
		}


		$prefix = $this->htmlOptions['id'];

		$settings = array(
            'action' => CHtml::normalizeUrl(Yii::app()->createUrl('site/ajaxUpload')),
            'name' => 'userfile',
            'data' => array(
				//'instanceName' => 'userfile',	// specified parameter name of getInstanceByName()
			   	'baseUrl' => $baseUrl,
				'loginRequiredAjaxResponse' => Yii::app()->user->loginRequiredAjaxResponse,
			),
			//'autoSubmit' => true,
			//'responseType' => 'json',
		   	//'hoverClass' => 'hover',
		   	//'disabledClass' => 'disabled',
		   	//'onChange' => 'js:function(file, extension){}',
		   	//'onSubmit' => 'js:function(file, extension){}',
		   	//'onComplete' => 'js:function(file, extension){}',
		);


		$settings = CMap::mergeArray($settings, $this->settings);
		$settings = CJavaScript::encode($settings);

		// register id append $prefix to make sure unique
		Yii::app()->getClientScript()->registerScript(__CLASS__.$prefix, "jQuery('#{$prefix}').ajaxUploadHandler($settings);");

		$this->render('file', array(
			'name' => $name,
			'value' => $value,
			'htmlOptions' => $this->htmlOptions,
			'prefix' => $prefix,
			'preview' => $preview,
		));
    }

}