<?php

Yii::import('backend.models._base.BaseSetting');

class Setting extends BaseSetting
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function __get($name){
		try{
			return parent::__get($name);
		}catch(Exception $e){
			$this->__set($name, null);
			
			return null;
		}
	}
	
	public function __set($name,$value){
		try{
			return parent::__set($name,$value);
		}catch(Exception $e){
			if(preg_match('/\W+/i', $name)){
				throw new Exception('Setting key :' . $name . ' is illegal !');
			}
			
			return $this->$name = $value;
		}
	}
}