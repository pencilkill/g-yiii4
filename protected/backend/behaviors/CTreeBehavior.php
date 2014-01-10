<?php
/**
 * CCategoryBehavior class file.
 * Self relation category helper
 *
 * @author sam@ozchamp.net <sam@ozchamp.net>
 */

class CTreeBehavior extends CActiveRecordBehavior {

	public $modelName;

	public $primaryKey;

	public $ancestorName = 'parent_id';

	public $parent = NULL;

	public $textAttribute;
	// CDbCriteria construct data
	public $criteriaData;

	public $level = 0;

	public function afterConstruct($event) {
		parent::afterConstruct($event);
		if(empty($this->modelName)){
			if($this->getOwner() instanceOf CActiveRecord){
				$this->modelName = CHtml::modelName($this->getOwner());
			}
		}

		$modelName = $this->modelName;

		if(($modelName::model() instanceOf CActiveRecord) !== true){
			return $this->modelName = null;
		}else{
			if(empty($this->ancestorName) && $modelName::model()->tableSchema->getColumn($this->ancestorName) == null){
				return $this->modelName = null;
			}

			if(empty($this->primaryKey)){
				$this->primaryKey = $modelName::model()->tableSchema->primaryKey;
			}

			if(empty($this->criteriaData['order'])){
				$this->criteriaData['order'] = "t.{$this->primaryKey} ASC";
			}
		}
	}

	/**
	 * Get all child node base on $parent
	 * category level will be added on for each node
	 *
	 * @param $textAttribute, attribute to show
	 * @param $parent, root node
	 * @param $level
	 * @return array
	 */

	public function Trees($textAttribute = NULL, $parent = NULL, $level = 0) {
		$storage = array();

		if(empty($this->modelName)){
			return $storage;
		}

		$modelName = $this->modelName;

		$primaryKey = $this->primaryKey;

		$ancestorName = $this->ancestorName;

		$criteriaData = $this->criteriaData;

		if($textAttribute == null){
			$textAttribute = $this->textAttribute;
		}

		$callback = null;

		$callback = function($parent, $level) use ($storage, &$callback, $modelName, $primaryKey, $textAttribute, $ancestorName, $criteriaData){
			$criteria = new CDbCriteria($criteriaData);
			$criteria->compare("t.{$ancestorName}", is_array($parent) ? $parent : array($parent));

			$categories = $modelName::model()->findAll($criteria);

			foreach ($categories as $category) {
				$subCategories = call_user_func($callback, $category->$primaryKey, $level+1);
				$storage[] = array(
					$primaryKey => $category->$primaryKey,
					$ancestorName => $category->$ancestorName,
					'level' => $level,
					'title' => CHtml::value($category, $textAttribute),
					'totalSubCategories' => sizeOf($subCategories),
				);
				$storage = CMap::mergeArray($storage, $subCategories);
			}

			return $storage;
		};

		return $callback($parent, $level);
	}

	/**
	 *
	 * @param $textAttribute, attribute to show
	 * @param $parent, root node
	 * @param $level
	 * @return array
	 */

	public function dropListData($textAttribute = NULL, $parent = NULL, $level = 0) {
		$storage = array();

		if(empty($this->modelName)){
			return $storage;
		}

		$modelName = $this->modelName;

		$primaryKey = $this->primaryKey;

		$ancestorName = $this->ancestorName;

		$criteriaData = $this->criteriaData;

		if($textAttribute == null){
			$textAttribute = $this->textAttribute;
		}

		$callback = null;

		$callback = function($parent, $level) use ($storage, &$callback, $modelName, $primaryKey, $textAttribute, $ancestorName, $criteriaData){
			$criteria = new CDbCriteria($criteriaData);
			$criteria->compare("t.{$ancestorName}", is_array($parent) ? $parent : array($parent));

			$categories = $modelName::model()->findAll($criteria);

			foreach ($categories as $category) {
				$storage[$category->$primaryKey] = str_repeat('　', $level) . (CHtml::value($category, $textAttribute));

				$storage = CMap::mergeArray($storage, call_user_func($callback, $category->$primaryKey, $level+1));
			}

			return $storage;
		};

		return $callback($parent, $level);
	}

	/**
	 *  Get all child node id base on $parent
	 *
	 * @param $parent, root node
	 * @param $self, whether the return value includes the $parend or not
	 * @return array
	 */

	public function nodeIds($parent = NULL, $self = false) {
		$storage = array();

		if(empty($this->modelName)){
			return $storage;
		}

		$modelName = $this->modelName;

		$primaryKey = $this->primaryKey;

		$ancestorName = $this->ancestorName;

		$criteriaData = $this->criteriaData;

		$callback = null;

		$callback = function($parent) use ($storage, &$callback, $modelName, $primaryKey, $ancestorName, $criteriaData){
	        $criteria = new CDbCriteria($criteriaData);
			$criteria->compare("t.{$ancestorName}", is_array($parent) ? $parent : array($parent));

	        $categories = $modelName::model()->findAll($criteria);

	        foreach ($categories as $category) {
	        	$storage[] = $category->$primaryKey;
	        	$storage = CMap::mergeArray($storage, call_user_func($callback, $category->$primaryKey));
	        }

	        return $storage;
		};

		$nodeIds = $callback($parent);

		$self && array_unshift($nodeIds, $parent);

		return $nodeIds;
    }
}
