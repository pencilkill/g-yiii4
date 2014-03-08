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
	private static function superFishNode($pk, $model, $relationName, $textAttribute, $url, $amp, $path = ''){
		$path = $path . ($path ? '_' : '') . $model->$pk;
		$models = $model->$relationName;

		$u = array('path' => $path, 'id' => $model->$pk);

		$link = $url . $amp . http_build_query($u);

		$html = '';
		$html .= '<li><a href="' . $link . '">' . CHtml::value($model, $textAttribute) . '</a>';
		if($models){
			$html .= '<ul>';
		}
		foreach($models as $model){
			$html .= self::superFishNode($pk, $model, $relationName, $textAttribute, $url, $amp , $path);
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
			$url = is_array($url) ? CHtml::normalizeUrl($url) : $url;
			// url amp
			$amp = ($url && strpos($url, '?')===false) ? '?' : '&';


			if(is_array($models)){
				$html .= '<ul>';
				foreach($models as $model){
					$html .= self::superFishNode($pk, $model, $relationName, $textAttribute, $url, $amp, $path = '');
				}
				$html .= '</ul>';
			}else{
				$html .= self::superFishNode($pk, $models, $relationName, $textAttribute, $url, $amp, $path = '');
			}
		}

		return $html;
	}
}//End of CSite