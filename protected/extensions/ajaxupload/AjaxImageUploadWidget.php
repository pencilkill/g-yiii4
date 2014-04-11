<?php
/**
 * @author Sam@ozchamp.net
 * @copyright www.ozchamp.net
 * @version 1.0
 *
 *
 */
class AjaxImageUploadWidget extends CInputWidget
{
	const IAS_CLASS_PREFIX = 'fancybox-image-ias';

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
		$preview = HCImage::cache($value, $imageCache);
		// thumb no image
		$previewX = HCImage::cache(null, $imageCache);

		$prefix = $this->htmlOptions['id'];

		//
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
					var iasApi = $(img).data('iasApi');

					iasApi.selectChangeUpdate(img, selection);
				}",
				'onSelectEnd' => "js:function(img, selection){
					var iasApi = $(img).data('iasApi');

					iasApi.selectEndUpdate(img, selection);
				}",
			));

			// required to enable fancybox
			$this->fancyBox = is_array($this->fancyBox) ? $this->fancyBox : array();

			$fancyOverlay = '.fancybox-overlay';
			$fancyImage = '.fancybox-image';

			$this->fancyBox = CMap::mergeArray($this->fancyBox, array(
				'config' => array(
// 					'autoSize' => false,
// 					'autoResize' => false,
// 					'fitToView' => false,
					'afterShow' => "js:function(){
						$('{$fancyOverlay}').off('click');

						var iasApi = $('{$fancyImage}').imgAreaSelect(". CJavaScript::encode($imageSelectConfig) .");

						$('{$fancyImage}').data('iasApi', iasApi);

						// extend for fancybox callback
						iasApi.selectChangeUpdate = function(img, selection){
							var iasClassPrefix = '" . self::IAS_CLASS_PREFIX . "';

							$.each(selection, function(k, v){
								$('.' + iasClassPrefix + '-' + k).html(v);
							});
						}

						// extend for fancybox callback
						iasApi.selectEndUpdate = function(img, selection){
							var iasClassPrefix = '" . self::IAS_CLASS_PREFIX . "';

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

						$('." . self::IAS_CLASS_PREFIX . "-submit').on('click', function(e){
							//var iasApi = $('{$fancyImage}').data('iasApi');

							e.preventDefault();

							var postData = $('form' + '." . self::IAS_CLASS_PREFIX . "' + '-data').serializeArray();
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
											$('#{$prefix}').val(r.src);
											$('#{$prefix}_preview').attr({'src':r.thumb});
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
						$('." . self::IAS_CLASS_PREFIX . "' + '-submit').attr({'disabled':'disabled'});

						var iasApi = $('{$fancyImage}').data('iasApi');

						if(iasApi){
							iasApi.cancelSelection();

							iasApi.setSelection(0, 0, 0, 0);
							iasApi.update();

							iasApi.selectChangeUpdate($('{$fancyImage}')[0], iasApi.getSelection());
							iasApi.selectEndUpdate($('{$fancyImage}')[0], iasApi.getSelection());
						}
					}",
					'beforeClose' => "js:function(){
						$('." . self::IAS_CLASS_PREFIX . "' + '-submit').attr({'disabled':'disabled'});

						var iasApi = $('{$fancyImage}').data('iasApi');

						if(iasApi){
							iasApi.cancelSelection();

							iasApi.setSelection(0, 0, 0, 0);
							iasApi.update();

							iasApi.selectChangeUpdate($('{$fancyImage}')[0], iasApi.getSelection());
							iasApi.selectEndUpdate($('{$fancyImage}')[0], iasApi.getSelection());
						}

						iasApi = null;
					}",
					'title' => $this->render('iasTpl', array('iasClassPrefix' => self::IAS_CLASS_PREFIX), true),
				),
			));
		}

		// fancyBox
		$fancyBox = array();

		if($this->fancyBox !== false){
			$fancyBox = is_array($this->fancyBox) ? $this->fancyBox : array();

			if(empty($fancyBox['target'])){
				$fancyBox['target'] = '#' . $prefix . '_fancybox';
			}

			if(empty($fancyBox['config'])){
				$fancyBox['config'] = array();
			}

			$fancyBox['config'] = CMap::mergeArray((array)$fancyBox['config'], array(
				'type' => 'image',
				'beforeLoad' => "js:function(){
					this.href = $('#{$prefix}').attr('value');
				}",
			));
		}

		$settings = array(
            'action'=>CHtml::normalizeUrl(Yii::app()->createUrl('site/ajaxUpload')),
            'name'=>'userfile',
            'data' => array(
				//'instanceName' => 'userfile',	// specified parameter name of getInstanceByName()
				'baseUrl' => $baseUrl,
				'loginRequiredAjaxResponse' => Yii::app()->user->loginRequiredAjaxResponse,
            	'loginRequiredReturnUrl' => Yii::app()->createUrl('site/index'),
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
		Yii::app()->getClientScript()->registerScript(__CLASS__.$prefix, "jQuery('#{$prefix}').ajaxUploadHandler($settings);");

		$this->render('image', array(
			'name' => $name,
			'value' => $value,
			'htmlOptions' => $this->htmlOptions,
			'prefix' => $prefix,
			'preview' => $preview,
			'previewX' => $previewX,
			'resize' => $imageCache['resize'],
			//
			'fancyBox' => $fancyBox,
			//
			'imageSelect' => $imageSelect,
		));
    }

}