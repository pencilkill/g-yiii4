<?php
/**
 * @author Sam@ozchamp.net
 * @copyright www.ozchamp.net
 * @version 1.0
 *
 *
 */
class AjaxUploadWidget extends CInputWidget
{
	const AJAX_FILE_NAME = 'userfile';

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