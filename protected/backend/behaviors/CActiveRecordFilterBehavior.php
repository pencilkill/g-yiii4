<?php
/**
 * CActiveRecordFilterBehavior class file.
 * Initialize filter data
 *
 * @author sam@ozchamp.net <sam@ozchamp.net>
 */

class CActiveRecordFilterBehavior extends CActiveRecordBehavior {

	/**
	 * @var mixed
	 *
	 * The relations used to search, which is/are blong to model relations
	 * only support the relation key
	 * do not support to merge the relationData
	 */
	public $relations;

	/**
	 * @var boolean
	 *
	 * whether to call setAttributes() to set the model value from $_GET
	 * check filterInstance()
	 */
	public $setAttributes = false;

	public function afterConstruct($event) {
		parent::afterConstruct($event);

		if(empty($this->relations)){
			$this->relations = array_keys($this->getOwner()->relations());
		}else{
			if(is_string($this->relations)){
				$this->relations = array($this->relations);
			}
		}
	}

	/**
	 * initialize the model filter property
	 * @param $instanceData
	 */

	public function filterInstance($instanceData = null){
		$this->getOwner()->filter = new stdClass;

		$relations = array_intersect_key($this->getOwner()->relations(), array_flip($this->relations));

		foreach($relations as $name => $relation){
			$modelName = $relation[1];

			$model = new $modelName('search');

			$model->unsetAttributes();

			if($this->setAttributes && isset($instanceData[$modelName])){
				$model->setAttributes($instanceData[$modelName], true);
			}

			$this->getOwner()->filter->{$name} = $model;
		}
	}
}
