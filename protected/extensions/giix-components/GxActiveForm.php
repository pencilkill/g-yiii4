<?php

/**
 * GxActiveForm class file.
 *
 * @author Rodrigo Coelho <rodrigo@giix.org>
 * @link http://giix.org/
 * @copyright Copyright &copy; 2010-2011 Rodrigo Coelho
 * @license http://giix.org/license/ New BSD License
 */

/**
 * GxActiveForm provides forms with additional features.
 *
 * @author Rodrigo Coelho <rodrigo@giix.org>
 */
class GxActiveForm extends CActiveForm {

	/**
	 * Renders a checkbox list for a model attribute.
	 * This method is a wrapper of {@link GxHtml::activeCheckBoxList}.
	 * #MethodTracker
	 * This method is based on {@link CActiveForm::checkBoxList}, from version 1.1.7 (r3135). Changes:
	 * <ul>
	 * <li>Uses GxHtml.</li>
	 * </ul>
	 * @see CActiveForm::checkBoxList
	 * @param CModel $model The data model.
	 * @param string $attribute The attribute.
	 * @param array $data Value-label pairs used to generate the check box list.
	 * @param array $htmlOptions Addtional HTML options.
	 * @return string The generated check box list.
	 */
	public function checkBoxList($model, $attribute, $data, $htmlOptions = array()) {
		return GxHtml::activeCheckBoxList($model, $attribute, $data, $htmlOptions);
	}

	/**
	 * conbine validate(), validateTabular()
	 * @author sam@ozchamp.net
	 * @see validate()
	 * @see validateTabular()
	 * @return string the JSON representation of the validation error messages.
	 */
	public static function validateEx($models, $loadInput=true)
	{
		$result=array();

		if(!is_array($models))
			$models=array($models);

		foreach($models as $model){
			if(! isset($model['model'])) continue;
			$mods = $model['model'];
			$attributes = isset($model['attributes']) ? $model['attributes'] : null;
			$many = isset($model['many']) ? $model['many'] : false;

			if($many){
				foreach($mods as $i=>$mod)
				{
					if($loadInput && isset($_POST[get_class($mod)][$i]))
						$mod->attributes=$_POST[get_class($mod)][$i];
					$mod->validate($attributes);
					foreach($mod->getErrors() as $attribute=>$errors)
						$result[CHtml::activeId($mod,'['.$i.']'.$attribute)]=$errors;
				}
			}else{
				if($loadInput && isset($_POST[get_class($mods)]))
				$mods->attributes=$_POST[get_class($mods)];
				$mods->validate($attributes);
				foreach($mods->getErrors() as $attribute=>$errors)
					$result[CHtml::activeId($mods,$attribute)]=$errors;
			}
		}

		return function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
	}
}