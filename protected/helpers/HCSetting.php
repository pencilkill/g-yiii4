<?php
/**
 *
 * @author Sam@ozchamp.net
 *	Validator class for key=>value, e.g. setting
 */
class HCSetting extends CFormModel {
	// model class name
	const MCN = 'Setting';

	public function __get($name) {
		$modelClass = __CLASS__;
		return isset($_POST[$modelClass][$name])? $_POST[$modelClass][$name] : Yii::app()->config->get($name);
	}

	public function attributeLabels(){
		$modelClass = self::MCN;
		return $modelClass::model()->attributeLabels();
	}

	public static function settingValidate( Array $rules = array()) {
		$class = __CLASS__;

		$dummy = new $class();

		foreach($rules as $rule) {
			if( isset($rule[0],$rule[1]) ) {
				$validator = CValidator::createValidator(
				$rule[1],
				$dummy,
				$rule[0],
				array_slice($rule,2)
				);
				$validator->validate($dummy);
			}
			else { /* throw error; */ }
		}

//		print_r($dummy->getErrors());
		return $dummy;
	}
}
?>