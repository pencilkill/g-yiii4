<?php
/**
 * CActiveRecordI18nBehavior class file.
 *
 * actually, only for scenario 'insert', cause the afterConstruct event of a active record only be invoked for scenario 'insert'
  * support rewrite relations
 *
 * @author sam@ozchamp.net <sam@ozchamp.net>
 */

class CActiveRecordI18nBehavior extends CActiveRecordBehavior {
	/**
	 * @var, mixed, String or Array
	 *
	 * The relations to initialized data
	 */
	public $relations;
	/**
	 *
	 * @param CModelEvent $event event parameter
	 */
	public function afterConstruct($event) {
		// format relations
		$_relations = is_string($this->relations) ? array($this->relations => array()) : (is_array($this->relations) ? $this->relations : array());
		$_definations = $this->getOwner()->relations();

		$relations = array();
		foreach($_relations as $key => $val){
			if(is_numeric($key) && is_string($val)){
				// without rewrite
				$key = $val;
				$val = array();
			}else if(is_string($key) && is_array($val)){
				// with rewrite, allow to rewrite string key only, cause relation type, model, foreignkey index is integer
				$val = array_filter($val, function($k, $v){return is_numeric($k);});
			}else{
				// relation can not be found correctly
				continue;
			}

			// rewrite
			if(array_key_exists($key, $_definations)){
				$relations[$key] = CMap::mergeArray($_definations[$key], $val);
			}
		}

		foreach($relations as $name => $relation){
			$_owner = $this->getOwner();

			$relationClass = $relation[1];

			switch ($relation[0]) {
				case CActiveRecord::BELONGS_TO:
				case CActiveRecord::HAS_ONE:
					$_owner->$name = new $relationClass;	// as default scenario
				break;

				case CActiveRecord::HAS_MANY:
				case CActiveRecord::MANY_MANY:
					/**
					 *  check indexs to get how much instances should be created for this many relation
					 *  otherwise, nothing intresting happen
					 */
					if(isset($relation['indexs']) && ($indexs = $relation['indexs']) && is_array($indexs)){
						foreach($indexs as $index){
							if(is_scalar($index)){
								$_owner->$name[$index] = new $relationClass;
							}
						}
					}
				break;

				default:
					;
				break;
			}
		}
	}
}
