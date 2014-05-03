<?php
/**
 * @author Sam <mail.song.de.qiang@gmail.com>
 */
class HCSite {
	/**
	 * Internal called by superFish
	 *
	 * @param Sting $pk,
	 * @param CActiveRecord $model,
	 * @param MANYRelation $relationName, CHASMANY or CMANYMANY
	 * @param Attribure $textAttribute,
	 * @param Array $url, it is used as parameter for CHtml::normalizeUrl()
	 * @param Char $amp, URL query string separator
	 * @param String $path, default '',
	 * @return String, ul,li code
	 */
	private static function superFishNode($pk, $model, $relationName, $textAttribute, $url, $path = ''){
		$path = $path . ($path ? '_' : '') . $model->$pk;
		$models = $model->$relationName;

		$url = CMap::mergeArray($url, array('path' => $path, 'id' => $model->$pk));

		$link = CHtml::normalizeUrl($url);

		$html = CHtml::openTag('li');
		$html .= CHtml::link(CHtml::value($model, $textAttribute), $link);
		if($models){
			$html .= CHtml::openTag('ul');
		}
		foreach($models as $model){
			$html .= self::superFishNode($pk, $model, $relationName, $textAttribute, $url, $path);
		}
		if($models){
			$html .= CHtml::closeTag('ul');
		}
		$html .= CHtml::closeTag('li');

		return $html;
	}

	/**
	 *
	 * @param CActiveRecord $model,
	 * @param MANYRelation $relationName, CHASMANY or CMANYMANY
	 * @param Attribure $textAttribute,
	 * @param Array $url, it is used as parameter for CHtml::normalizeUrl()
	 * @param String $path, default '',
	 * @return String, ul,li code
	 */
	public static function superFish($models, $relationName, $textAttribute, $url, $path = ''){
		$html = '';

		$model = is_array($models) ? end($models) : $models;

		if($model && array_key_exists($relationName, $model->relations())){
			// pk
			$pk = $model->tableSchema->primaryKey;

			if(is_array($models)){
				$html .= CHtml::openTag('ul');
				foreach($models as $model){
					$html .= self::superFishNode($pk, $model, $relationName, $textAttribute, $url, $path = '');
				}
				$html .= CHtml::closeTag('ul');
			}else{
				$html .= self::superFishNode($pk, $models, $relationName, $textAttribute, $url, $path = '');
			}
		}

		return $html;
	}
}//End of CSite