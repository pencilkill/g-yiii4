<?php
/**
 * @author Sam, sam@ozchamp.net
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
	public $CKBasePath;
    public $config;

    public function init() {
		if(empty($this->CKBasePath)){
			$this->CKBasePath = Yii::app()->getBaseUrl().'/ckeditor/';
		}
        if(($this->value)){
			$this->value = '';
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
		Yii::app()->clientScript->registerScriptFile($this->CKBasePath . 'ckeditor.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile($this->CKBasePath . 'adapters/jquery.js', CClientScript::POS_HEAD);
		//
		$adapter = '';
		if(isset($this->htmlOptions['class'])){
			$adapter = '.' . $this->htmlOptions['class'];
		}elseif(isset($this->htmlOptions['id'])){
			$adapter = '#' . $this->htmlOptions['id'];
		}elseif(isset($this->htmlOptions['name'])){
			$adapter = '[name="' . $this->htmlOptions['class'] . '"]';
		}

		if($adapter){
			Yii::app()->clientScript->registerScript(__CLASS__ . uniqid(), "$('{$adapter}').ckeditor();");
		}
	}
}
?>