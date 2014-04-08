<?php
/**
 * Site helper class.
 *
 * @author     Sam@ozchamp.net
 * @copyright  www.ozchamp.net
 */
class HCSite {
	/**
	 * Internal called by superFish
	 *
	 * @param Sting $pk,
	 * @param CActiveRecord $model,
	 * @param MANYRelation $relationName, CHASMANY or CMANYMANY
	 * @param Attribure $textAttribute,
	 * @param String $url,
	 * @param Char $amp, URL query string separator
	 * @param String $path, default '',
	 * @return String, ul,li code
	 */
	private static function superFishNode($pk, $model, $relationName, $textAttribute, $url, $path = ''){
		$path = $path . ($path ? '_' : '') . $model->$pk;
		$models = $model->$relationName;

		$url = CMap::mergeArray($url, array('path' => $path, 'id' => $model->$pk));

		$link = CHtml::normalizeUrl($url);

		$html = '';
		$html .= '<li><a href="' . $link . '">' . CHtml::value($model, $textAttribute) . '</a>';
		if($models){
			$html .= '<ul>';
		}
		foreach($models as $model){
			$html .= self::superFishNode($pk, $model, $relationName, $textAttribute, $url, $path);
		}
		if($models){
			$html .= '</ul>';
		}
		$html .= '</li>';

		return $html;
	}

	/**
	 *
	 * @param CActiveRecord $model,
	 * @param MANYRelation $relationName, CHASMANY or CMANYMANY
	 * @param Attribure $textAttribute,
	 * @param String $url,
	 * @param String $path, default '',
	 * @return String, ul,li code
	 */
	public static function superFish($models, $relationName, $textAttribute, $url, $path = ''){
		$html = '';

		$model = is_array($models) ? end($models) : $models;

		if($model && array_key_exists($relationName, $model->relations())){
			// pk
			$pk = $model->tableSchema->primaryKey;
			// parse url
			$url = is_array($url) ? $url : array(Yii::app()->controller->route, $_GET);


			if(is_array($models)){
				$html .= '<ul>';
				foreach($models as $model){
					$html .= self::superFishNode($pk, $model, $relationName, $textAttribute, $url, $path = '');
				}
				$html .= '</ul>';
			}else{
				$html .= self::superFishNode($pk, $models, $relationName, $textAttribute, $url, $path = '');
			}
		}

		return $html;
	}
}//End of CSite