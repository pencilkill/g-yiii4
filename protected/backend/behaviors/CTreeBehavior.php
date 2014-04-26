<?php
/**
 * CTreeBehavior class file.
 * Class for self-relation category helper
 *
 * TODO Maybe cache solution is required(cache or class private property $_data)
 *
 * @author @author Sam <mail.song.de.qiang@gmail.com> <mail.song.de.qiang@gmail.com>
 */

class CTreeBehavior extends CActiveRecordBehavior {
	private $_instance = false;

	public $modelName;

	public $primaryKey;

	public $ancestorName = 'parent_id';

	public $textAttribute;
	// CDbCriteria construct data
	public $criteriaData;

	// To avoid the fucking scenario
	public function attach($owner){
		parent::attach($owner);

		$this->instance();
	}

	public function instance() {
		if($this->_instance) return true;

		if($this->modelName === null){
			$this->modelName = CHtml::modelName($this->getOwner());
		}

		$modelName = $this->modelName;

		if(empty($this->ancestorName) || $modelName::model()->tableSchema->getColumn($this->ancestorName) == null){
			$this->modelName = null;
		}else{
			if(empty($this->primaryKey)){
				$this->primaryKey = $modelName::model()->tableSchema->primaryKey;
			}

			if(empty($this->criteriaData['order'])){
				$this->criteriaData['order'] = "t.{$this->primaryKey} ASC";
			}
		}

		return $this->_instance = true;
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

	public function treeList($textAttribute = NULL, $parent = NULL, $level = 0) {
		$storage = array();

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
					'totalSubCategories' => sizeof($subCategories),
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

	public function dropList($textAttribute = NULL, $parent = NULL, $level = 0) {
		$storage = array();

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

	public function subNodes($parent = NULL, $self = false) {
		$storage = array();

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
