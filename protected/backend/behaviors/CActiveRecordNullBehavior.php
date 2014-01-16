<?php
/**
 * CActiveRecordNullBehavior class file.
 * Save a DB NULL value,
 * @example
 * e.g
 * parent_id,
 * we defined a self relation,
 * the constraint defination is "SET NULL" on delete
 * (we can not use '0' as default value cause the value '0' is not a fk value)
 *
 * @author sam@ozchamp.net <sam@ozchamp.net>
 * @see zii.behaviors.CTimestampBehavior
 */

class CActiveRecordNullBehavior extends CActiveRecordBehavior {
	/**
	 * @var The attributes to store the null value.  Set to null to not
	 */
	public $attributes;
	/**
	 * Responds to {@link CModel::onBeforeSave} event.
	 * Sets the values of the creation or modified attributes as configured
	 *
	 * @param CModelEvent $event event parameter
	 */
	public function beforeSave($event) {
		if(!empty($this->attributes)){
			 $attributes = is_string($this->attributes) ? array($this->attributes) : $this->attributes;

			 foreach($attributes as $attribute){
			 	if(empty($this->getOwner()->{$attribute})){
			 		// using NULL instead of new CDbExpression('NULL')
			 		$this->getOwner()->{$attribute} = NULL;
			 	}
			 }
		}
	}
}
