<?php
/**
 * @author Sam@ozchamp.net
 * @copyright www.ozchamp.net
 * @version 1.0
 *
 *
 */

Yii::import('frontend.extensions.ajaxupload.AjaxUploadWidget');

class AjaxImageUploadWidget extends AjaxUploadWidget
{
	const IAS_API = 'imgAreaSelect';	// imgAreaSelect plugin default value
	const IAS_IMAGE_CLASS = 'fancybox-image';
	const IAS_POST_FORM__CLASS = 'fancybox-image-ias-form';

	public $jsHandlerUrl;

	public $settings=array();

	/**
	 * image cache parameters
	 * @see ext.image
	 * @var Array
	 */
	public $imageCache=array();

	/**
	 * image fancybox, it should be compatiable with fancybox widget (frontend.extensions.fancybox.EFancyBox)
	 */
	public $fancyBox = false;

	/**
	 * image imageselect, it should be compatiable with imageselect widget (frontend.extensions.imageselect.EImageSelect)
	 */
	public $imageSelect = false;

	public function init()
	{
    	parent::init();
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
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/ajaxuploadHandler.js', CClientScript::POS_HEAD);
		}

		// default thumb setting
		$imageCache = array('resize'=>array('width' => 120, 'height' => 120));
		$imageCache = CMap::mergeArray($imageCache, $this->imageCache);

		// thumb
		$preview = HCImage::cache($this->value, $imageCache);
		// thumb no image
		$previewX = HCImage::cache(null, $imageCache);

		// fancyBox
		$fancyBox = $this->fancyBox();

		// imageSelect
		$imageSelect = $this->imageSelect($fancyBox);

		//
		$settings = array(
            'action' => CHtml::normalizeUrl(Yii::app()->createUrl('site/ajaxUpload')),
            'name' => self::AJAX_FILE_NAME,
            'data' => array(
				'instanceName' => 'userfile',	// specified parameter name of getInstanceByName()
				'baseUrl' => $baseUrl,
				'loginRequiredAjaxResponse' => Yii::app()->user->loginRequiredAjaxResponse,
            	'loginRequiredReturnUrl' => CHtml::normalizeUrl(array('site/index')),
            	'params' => $this->params,
			),
			//'autoSubmit'=>true,
			//'responseType'=>'json',
		   	//'hoverClass'=>'hover',
		   	//'disabledClass'=>'disabled',
		   	//'onChange'=>'js:function(file, extension){}',
		   	//'onSubmit'=>'js:function(file, extension){}',
		   	//'onComplete'=>'js:function(file, extension){}',
		);


		$settings = CMap::mergeArray($settings, $this->settings);
		$settings = CJavaScript::encode($settings);

		// register id append $prefix to make sure unique
		Yii::app()->getClientScript()->registerScript(__CLASS__.$this->htmlOptions['id'], "jQuery('#{$this->htmlOptions['id']}').ajaxUploadHandler($settings);");

		$this->render('image', array(
			'name' => $this->name,
			'value' => $this->value,
			'htmlOptions' => $this->htmlOptions,
			'preview' => $preview,
			'previewX' => $previewX,
			'resize' => $imageCache['resize'],
			'fancyBox' => $fancyBox,
			'imageSelect' => $imageSelect,
		));
    }

    protected function fancyBox(){
    	$fancyBox = array();

    	if($this->fancyBox !== false){
    		$fancyBox = is_array($this->fancyBox) ? $this->fancyBox : array();

    		if(empty($fancyBox['target'])){
    			$fancyBox['target'] = '#' . $this->htmlOptions['id'] . '_fancybox';
    		}

    		if(empty($fancyBox['config'])){
    			$fancyBox['config'] = array();
    		}

    		$fancyBox['config'] = CMap::mergeArray((array)$fancyBox['config'], array(
    			'type' => 'image',
    			'beforeLoad' => "js:function(){
    				this.href = $('#{$this->htmlOptions['id']}').attr('value');
    			}",
    		));
    	}

    	return $fancyBox;
    }

    protected function imageSelect(&$fancyBox){
    	$imageSelect = array();

    	if($this->imageSelect !== false){
    		$imageSelect = is_array($this->imageSelect) ? $this->imageSelect : array();

    		$imageSelect['target'] = NULL;

    		if(empty($imageSelect['ajaxUrl'])){
    			$imageSelect['ajaxUrl'] = CHtml::normalizeUrl(array('site/ajaxCrop'));
    		}

    		if(empty($imageSelect['config']) || is_array($imageSelect['config']) == false){
    			$imageSelect['config'] = array();
    		}

    		$imageSelectConfig = $imageSelect['config'];

    		$imageSelectConfig = CMap::mergeArray($imageSelectConfig, array(
    			'instance' => true,
    			'handles' => true,
    			'onSelectChange' => "js:function(img, selection){
					var iasApi = $(img).data('" . self::IAS_API . "');

					iasApi.selectChangeUpdate(img, selection);
				}",
    			'onSelectEnd' => "js:function(img, selection){
					var iasApi = $(img).data('" . self::IAS_API . "');

					iasApi.selectEndUpdate(img, selection);
				}",
    		));

    		// required to enable fancybox
    		if($this->fancyBox === false){
    			$this->fancyBox = true;
    		}

    		$fancyBox = $this->fancyBox();

    		$fancyBox = CMap::mergeArray($fancyBox, array(
    			'config' => array(
    				'afterShow' => "js:function(){
						$('.fancybox-overlay').off('click');

						var iasApi = $('." . self::IAS_IMAGE_CLASS . "').imgAreaSelect(". CJavaScript::encode($imageSelectConfig) .");

						//
						iasApi.image = $('." . self::IAS_IMAGE_CLASS . "')[0];

						// extend for fancybox callback
						iasApi.selectChangeUpdate = function(img, selection){
							var iasClassPrefix = '" . self::IAS_POST_FORM__CLASS . "';

							$.each(selection, function(k, v){
								$('.' + iasClassPrefix + '-' + k).html(v);
							});
						}

						// extend for fancybox callback
						iasApi.selectEndUpdate = function(img, selection){
							var iasClassPrefix = '" . self::IAS_POST_FORM__CLASS . "';

							$('.' + iasClassPrefix + '-data-source').val(img.src);
							$('.' + iasClassPrefix + '-data-scale-width').val(img.width);
							$('.' + iasClassPrefix + '-data-scale-height').val(img.height);

							$.each(selection, function(k, v){
								$('.' + iasClassPrefix + '-data-' + k).val(v);
							});

							var w = parseInt($('.' + iasClassPrefix + '-data-width').val());
							var h = parseInt($('.' + iasClassPrefix + '-data-height').val());

							if(w && h){
								$('.' + iasClassPrefix + '-submit').removeAttr('disabled');
							}else{
								$('.' + iasClassPrefix + '-submit').attr({'disabled':'disabled'});
							}
						}

						$('." . self::IAS_POST_FORM__CLASS . "-submit').on('click', function(e){
							e.preventDefault();

							var postData = $('form' + '." . self::IAS_POST_FORM__CLASS . "' + '-data').serializeArray();
							/**
							 * we do not check the width and height at here,
							 * if width(or height) is 0,
							 * we will disabled the submit button by callback(imageAreaSelect.onSelectEnd())
							 */
							$.ajax({
								'url':'" . $imageSelect['ajaxUrl'] . "',
			    				'type':'POST',
			    				'dataType':'json',
			    				'data':postData,
			    				'beforeSend':function(x, s){
			    					$.fancybox.showLoading();
			    				},
			    				'success':function(r, s, x){
				    				if(!r.error){
					    				if(r.src && r.thumb){
					    					$('#{$this->htmlOptions['id']}').val(r.src);
					    					$('#{$this->htmlOptions['id']}_preview').attr({'src':r.thumb});
								    	}else{
								    		alert(x.status);
							    		}

							    		$.fancybox.close();
							    	}else{
							    		alert(r.error);
							    	}

						    	},
						    	'complete':function(x, s){
						    		$.fancybox.hideLoading();

						    		$.fancybox.close();
						    	},
						    	'error':function(x, s, e){
						    		$.fancybox.hideLoading();

						    		alert(x.status);

						    		$.fancybox.close();
						    	},
					    	});
				    	});
			    	}",
			    	'onUpdate' => "js:function(){
			    		$('." . self::IAS_POST_FORM__CLASS . "' + '-submit').attr({'disabled':'disabled'});

		    			var iasApi = $('." . self::IAS_IMAGE_CLASS . "').data('" . self::IAS_API . "');

	    				if(iasApi){
		    				iasApi.cancelSelection();

		    				iasApi.setSelection(0, 0, 0, 0);
							iasApi.update();

		    				iasApi.selectChangeUpdate(iasApi.image, iasApi.getSelection());
							iasApi.selectEndUpdate(iasApi.image, iasApi.getSelection());
						}
					}",
					'beforeClose' => "js:function(){
						$('." . self::IAS_POST_FORM__CLASS . "' + '-submit').attr({'disabled':'disabled'});

						var iasApi = $('." . self::IAS_IMAGE_CLASS . "').data('" . self::IAS_API . "');

						if(iasApi){
							iasApi.cancelSelection();

							iasApi.setSelection(0, 0, 0, 0);
							iasApi.update();

							iasApi.selectChangeUpdate(iasApi.image, iasApi.getSelection());
							iasApi.selectEndUpdate(iasApi.image, iasApi.getSelection());
						}

						iasApi = null;
					}",
					'title' => $this->render('iasTpl', array('iasClassPrefix' => self::IAS_POST_FORM__CLASS), true),
				),
			));
		}

		return $imageSelect;
    }
}