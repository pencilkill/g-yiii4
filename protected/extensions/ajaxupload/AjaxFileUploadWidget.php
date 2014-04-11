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

    	$this->name = $this->resolveName();

    	$this->value = $this->resolveValue();

		if(!isset($this->htmlOptions['placeholder'])){
			$this->htmlOptions['placeholder'] = 'http://';
		}

		if(!isset($this->htmlOptions['title'])){
			$this->htmlOptions['title'] = 'Place your completed link here to override upload file ...';
		}

		if(!isset($this->htmlOptions['size'])){
			$this->htmlOptions['size'] = 50;
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
		}else{
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/handler.js', CClientScript::POS_HEAD);
		}

		// preview
		$preview = $this->value;

		if(isset($this->previewUrl) && is_array($this->previewUrl)){
			$previewUrlParam = array('file' => $this->value);
			if(isset($this->previewUrl[1])){
				$previewUrlParam = CMap::mergeArray($this->previewUrl[1], $previewUrlParam);
			}

			$preview = Yii::app()->getUrlManager()->createUrl($this->previewUrl[0], $previewUrlParam);
		}


		$settings = array(
            'action' => CHtml::normalizeUrl(Yii::app()->createUrl('site/ajaxUpload')),
            'name' => 'userfile',
            'data' => array(
				//'instanceName' => 'userfile',	// specified parameter name of getInstanceByName()
			   	'baseUrl' => $baseUrl,
				'loginRequiredAjaxResponse' => Yii::app()->user->loginRequiredAjaxResponse,
            	'loginRequiredReturnUrl' => CHtml::normalizeUrl(array('site/index')),
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
		Yii::app()->getClientScript()->registerScript(__CLASS__.$this->htmlOptions['id'], "jQuery('#{$this->htmlOptions['id']}').ajaxUploadHandler($settings);");

		$this->render('file', array(
			'name' => $this->name,
			'value' => $this->value,
			'htmlOptions' => $this->htmlOptions,
			'preview' => $preview,
		));
    }

    protected function resolveName(){
    	if(isset($this->htmlOptions['name'])){
    		$name = $this->htmlOptions['name'];
    	}else if(isset($this->name)){
    		$name = $this->name;
    	}else if(isset($this->model, $this->attribute)){
    		$name = CHtml::activeName($this->model, $this->attribute);
    	}else{
    		$name = '';
    	}

    	return $name;
    }

    protected function resolveValue(){
    	if(isset($this->htmlOptions['value'])){
    		$value = $this->htmlOptions['value'];
    	}else if(isset($this->value)){
    		$value = $this->value;
    	}else if(isset($this->model, $this->attribute)){
    		$value = CHtml::resolveValue($this->model, $this->attribute);
    	}else{
    		$value = '';
    	}

    	return $value;
    }
}