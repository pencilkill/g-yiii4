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

	public function init(){
		parent::init();

		Yii::import('frontend.behaviors.CActiveFormBehavior');

		$this->attachBehavior('CActiveFormBehavior', 'CActiveFormBehavior');
	}
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
			if(empty($model['model'])) continue;

			$attributes = isset($model['attributes']) ? $model['attributes'] : null;
			$many = isset($model['many']) ? $model['many'] : false;

			if($many){
					$model['model'] = is_array($model['model']) ? $model['model'][key($model['model'])] : $model['model'];

					$modelName = CHtml::modelName($model['model']);

					$posts = array();
					if($loadInput && isset($_POST[$modelName])){
						$posts = HCArray::flatten($_POST[$modelName]);
					}

					foreach($posts as $keyPrefix=>$values)
					{
						$model['model']->setAttributes($values);
						$model['model']->validate($attributes);

						foreach($model['model']->getErrors() as $attribute=>$errors){
							$result[CHtml::activeId($model['model'], $keyPrefix . $attribute)]=$errors;
						}
					}
			}else{
				$modelName = CHtml::modelName($model['model']);

				if($loadInput && isset($_POST[$modelName])){
					$model['model']->setAttributes($_POST[$modelName]);
				}
				$model['model']->validate($attributes);
				foreach($model['model']->getErrors() as $attribute=>$errors){
					$result[CHtml::activeId($model['model'],$attribute)]=$errors;
				}
			}
		}

		return function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
	}
}