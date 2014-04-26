<?php
/**
 * @author @author Sam <mail.song.de.qiang@gmail.com> <mail.song.de.qiang@gmail.com>
 * @copyright www.ozchamp.net
 * @version 1.0
 *
 *
 */
class AjaxUploadWidget extends CInputWidget
{
	const AJAX_FILE_NAME = 'userfile';

	const AJAX_SCENARIO = __CLASS__;

	const AJAX_BUTTION_SUFFIX = '_button';
	const AJAX_PREVIEW_SUFFIX = '_preview';

	// model information for validate file, no required
	public $params = array();

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

    	$this->params = $this->params();
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

    protected function params(){
    	$params = array(
			'model' => CHtml::modelName($this->model),
			'attribute' => CHtml::modelName($this->attribute),
			'id' => CHtml::modelName($this->model->primaryKey),
			'scenario' => self::AJAX_SCENARIO,
		);

    	return CMap::mergeArray($params, $this->params);
    }
}