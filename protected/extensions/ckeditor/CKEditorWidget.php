<?php
/**
 * @author Sam <mail.song.de.qiang@gmail.com>
 * @example
 * for basic:
 * <?php $this->widget('ext.ckeditor.CKEditorWidget',array('model'=>$model, 'attribute'=>'content', 'value'=>$model->content)); ?>
 * @example
 * for single: in this case, textarea tag is not included
 * <?php $this->widget('ext.ckeditor.CKEditorWidget',array('htmlOptions'=>array('id'=>'textarea_id'))); ?>
 * @example
 * for name and value: in this case, value is not requried:
 * <?php $this->widget('ext.ckeditor.CKEditorWidget',array('htmlOptions'=>array('name'=>CHtml::activeName($model, 'content'))), 'value'=>$model->content); ?>
 * @example
 * for multiple: in this case, textarea tag is not included
 * <?php $this->widget('ext.ckeditor.CKEditorWidget',array('htmlOptions'=>array('class'=>'textarea_class'))); ?>
 */

class CKEditorWidget extends CInputWidget
{
	const CKEDITOR_INSTANCE_CLASS = 'ckeditor';
	const CKEDITOR_CLASS = 'editor';
	/**
	 * using as ckfinder instance id to identify different application
	 */
	public $app;

	public $CKBasePath;
    public $config;

    /**
     * using this ckeditor configuration as CKEditor.config
     * in this case, we can use $('editor').ckeditor() without extra config on fly
     */
    public $useAsGlobal = false;

    public function init() {
    	if($this->app === null){
    		$this->app = Yii::app()->id;
    	}

		if(empty($this->CKBasePath)){
			$this->CKBasePath = Yii::app()->getBaseUrl().'/ckeditor/';
		}

        if(($this->value)){
			$this->value = '';
		}

		/**
		 * class 'ckeditor' is the default selector
		 * IE will trigger uncaught exception for a already ckeditor instance
		 */
		if(isset($this->htmlOptions['class']) && $this->htmlOptions['class'] === self::CKEDITOR_INSTANCE_CLASS){
			$this->htmlOptions['class'] = self::CKEDITOR_CLASS;
		}

    	if(!(isset($this->htmlOptions['class']) || isset($this->htmlOptions['id']) || isset($this->htmlOptions['name']))){
			if(isset($this->model, $this->attribute)){
				$this->htmlOptions['id']=CHtml::activeId($this->model, $this->attribute);
			}
    	}
    }

	public function run()
	{
		//
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerScriptFile($this->CKBasePath . 'ckeditor.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile($this->CKBasePath . 'adapters/jquery.js', CClientScript::POS_HEAD);
		//
		$adapter = '.' . self::CKEDITOR_CLASS;
		if(isset($this->htmlOptions['class'])){
			$adapter = '.' . $this->htmlOptions['class'];
		}elseif(isset($this->htmlOptions['id'])){
			$adapter = '#' . $this->htmlOptions['id'];
		}elseif(isset($this->htmlOptions['name'])){
			$adapter = '[name="' . $this->htmlOptions['class'] . '"]';
		}

		$config = array(
			'customConfig' => $this->CKBasePath . 'config.js.php?id=' . md5($this->app),
		);

		if(isset($this->config)){
			$config = CMap::mergeArray($config, $this->config);
		}

		if($this->useAsGlobal){
			Yii::app()->clientScript->registerScript(__CLASS__, "jQuery.extend(true, CKEDITOR.config, ".CJavaScript::encode($config)." || {});");
		}

		if($adapter){
			Yii::app()->clientScript->registerScript(__CLASS__ . uniqid(), "$('{$adapter}').ckeditor(".CJavaScript::encode($config).");");
		}
	}
}
?>