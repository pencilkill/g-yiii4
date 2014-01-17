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
	private $_relations;
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
	public function afterConstruct() {
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
				$val = array_diff_key($val, array_flip(array_filter(array_keys($val), 'is_numeric')));
			}else{
				// relation can not be found correctly
				continue;
			}

			// rewrite
			if(array_key_exists($key, $_definations)){
				$relations[$key] = CMap::mergeArray($_definations[$key], $val);
			}
		}

		return $this->_relations = $relations;
	}

	public function getNewRelatedData($name){
		if(array_key_exists($name, $this->_relations)){
			$relation = $this->_relations[$name];

			$relationClass = $relation[1];

			switch ($relation[0]) {
				case CActiveRecord::BELONGS_TO:
				case CActiveRecord::HAS_ONE:
					$_data = new $relationClass;	// as default scenario
				break;

				case CActiveRecord::HAS_MANY:
				case CActiveRecord::MANY_MANY:
					/**
					 *  check indexs to get how much instances should be created for this many relation
					 *  otherwise, nothing intresting happen
					 */
					if(isset($relation['indexes']) && ($indexes = $relation['indexes']) && is_array($indexes)){
						foreach($indexes as $index){
							if(is_scalar($index)){
								$va = new $relationClass;
								if(isset($relation['index']) && $va->hasAttribute($relation['index'])){
									$va->{$relation['index']} = $index;
								}
								$_data[$index] = $va;
							}
						}
					}
				break;

				default:
					$_data = null;
				break;
			}

			return isset($_data) ? $_data : null;
		}else{
			throw new Exception('Relation: ' . $name . ' has no defination!');
		}
	}
}
