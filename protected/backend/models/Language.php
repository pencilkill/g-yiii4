<?php

Yii::import('backend.models._base.BaseLanguage');

class Language extends BaseLanguage
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}


	public function rules(){
		$rules = array(
			array('code', 'unique', 'className' => 'Language', 'attributeName' => 'code'),
			array('code', 'match' , 'pattern'=>'/^[a-z][a-z_]+[a-z]$/', 'message'=>Yii::t('m/language', '{attribute} can be allowed a-z or \'_\' only, and \'_\' can not be first char and last char.')),
		);

		return CMap::mergeArray(parent::rules(), $rules);
	}
}