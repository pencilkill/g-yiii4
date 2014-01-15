<?php
/**
 * update by Sam@ozchamp.net
 * @todo multi instance, more example : https://code.google.com/p/swfupload/
 * @author yii extension
 */
class CSwfUpload extends CWidget
{
	public $jsHandlerUrl;
	public $postParams=array();
	public $customSettings=array();
	public $config=array();

	public $galleries;

	public static function actions(){
		return array(
			'upload' => 'upload',
		);
	}

    public function run()
    {
		$assets = dirname(__FILE__).'/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
		Yii::app()->clientScript->registerScriptFile($baseUrl . '/swfupload.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerCssFile($baseUrl . '/default.css');
		if(isset($this->jsHandlerUrl))
		{
			Yii::app()->clientScript->registerScriptFile($this->jsHandlerUrl);
			unset($this->jsHandlerUrl);
		}else{
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/handlers.js', CClientScript::POS_HEAD);
		}

		$config = array(
            'upload_url' => CHtml::normalizeUrl(Yii::app()->createUrl('site/swfUpload')),
            'post_params' => array(),
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
		   	'custom_settings'=>array('upload_target'=>'divFileProgressContainer'),
		   	'button_placeholder_id'=>'swfupload',
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

		$postParams = array(
			'PHPSESSID'=>session_id()
		);
		if(isset($this->postParams))
		{
			$postParams = CMap::mergeArray(
				CMap::mergeArray(
					isset($config['post_params']) ? $config['post_params'] : array(),
					$postParams
				),
				$this->postParams
			);
		}

		$customSettings=array(
			'assets'=>$baseUrl,
			'loginRequiredAjaxResponse' => Yii::app()->user->loginRequiredAjaxResponse,
		);
		if(isset($this->customSettings))
		{
			$customSettings = CMap::mergeArray(
				CMap::mergeArray(
					isset($config['custom_settings']) ? $config['custom_settings'] : array(),
					$customSettings
				),
				$this->customSettings
			);
		}

		$config['post_params'] = $postParams;
		$config['flash_url'] = $baseUrl. '/swfupload.swf';
		$config['custom_settings'] = $customSettings;

		$config = CMap::mergeArray($config, $this->config);
		$config = CJavaScript::encode($config);

		Yii::app()->getClientScript()->registerScript(__CLASS__, "var swfu;swfu = new SWFUpload($config);");

		$galleryView = isset($postParams['galleryView']) ? $postParams['galleryView'] : 'galleryView';
		$imageView = isset($postParams['imageView']) ? $postParams['imageView'] : 'imageView';

		$galleries = $items= array();
		if($this->galleries){
			$galleries = is_array($this->galleries) ? $this->galleries : array($this->galleries);
			$fullPath = Yii::getPathOfAlias('webroot').'/';
			$resize = CMap::mergeArray(array('width'=>120, 'height'=>120, 'master'=>2), isset($postParams['resize']) ? $postParams['resize'] : array());
			foreach ($galleries as $image) {
				if( ! is_file($fullPath.$image->pic)) continue;
				// thumb
				$src = Yii::app()->image->load($fullPath.$image->pic)
						->resize($resize['width'], $resize['height'], $resize['master'])
						->cache();
				$index = uniqid();
				$items["gallery_item_{$index}"] = $this->render($imageView, array('src'=>$src, 'image'=>$image, 'index'=>$index, 'resize' => $resize), true);
			}
		}

		$this->render($galleryView,array(
			'items' => $items,
		));

    }
}