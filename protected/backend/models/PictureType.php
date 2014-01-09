<?php

Yii::import('backend.models._base.BasePictureType');

class PictureType extends BasePictureType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
     * Checking relations before the DB fk constraint
     *
     * @return boolean
     */

    public function beforeDelete(){
    	if(!parent::beforeDelete()) return false;

    	if(sizeOf($this->pictures)){
    		Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure Including SubItems'));

    		return false;
    	}

    	return true;
    }
}