<?php

Yii::import('backend.models._base.BaseInformation');

class Information extends BaseInformation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return CMap::mergeArray(
			parent::rules(),
			array(
				array('parent_id', 'validParentId', 'on' => 'update'),
			)
		);
	}

	public function validParentId(){
    	$categoryIds = self::getCategoryIds($this->information_id, true);

    	if(in_array($this->parent_id, $categoryIds)){
    		$this->addError('parent_id', Yii::t('m/information', 'Parent_id can not be self or children'));
    	}
    }

	/**
	 * Get all child node base on $parent
	 * category level will be added on for each node
	 * please note that default level is custom variable, you can set it as zero while the root node is not zero
	 *
	 * @param $parent, root node
	 * @param $textAttribute, attribute to show
	 * @param $level
	 * @return array
	 */

	public static function getCategories($modelName = __CLASS__, $parent = NULL, $textAttribute = 'informationI18n.title', $level=0) {
		if(is_array($modelName)){	// models
			$modelName = array_shift($modelName);	// model or modelName
		}

		if(is_object($modelName)){	// model
			$modelName = CHtml::modelName($modelName);	// modelName
		}

		$primaryKey = $modelName::model()->tableSchema->primaryKey;

		$storage = array();
		$callback = null;

		$callback = function($parent, $level) use ($storage, &$callback, $modelName, $primaryKey, $textAttribute){
			$criteria = new CDbCriteria;
			$criteria->compare('t.parent_id', is_array($parent) ? $parent : array($parent));
			$criteria->order = 't.sort_order DESC, t.information_id ASC';

			$categories = $modelName::model()->findAll($criteria);

			foreach ($categories as $category) {
				$subCategories = call_user_func($callback, $category->$primaryKey, $level+1);
				$storage[] = array(
					$primaryKey => $category->$primaryKey,
					'parent_id' => $category->parent_id,
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
	 * @see self::getCategories()
	 *
	 * @param $parent
	 * @param $textAttribute, attribute to show
	 * @param $level
	 */
	public static function getDropListData($modelName = __CLASS__, $parent = NULL, $textAttribute = 'informationI18n.title', $level=0) {
		if(is_array($modelName)){	// models
			$modelName = array_shift($modelName);	// model or modelName
		}

		if(is_object($modelName)){	// model
			$modelName = CHtml::modelName($modelName);	// modelName
		}

		$primaryKey = $modelName::model()->tableSchema->primaryKey;

		$storage = array();
		$callback = null;

		$callback = function($parent, $level) use ($storage, &$callback, $modelName, $primaryKey, $textAttribute){
			$criteria = new CDbCriteria;
			$criteria->compare('t.parent_id', is_array($parent) ? $parent : array($parent));
			$criteria->order = 't.sort_order DESC, t.information_id ASC';

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
	 * @return array
	 * @param $parent, root node
	 */
	public static function getCategoryIds($modelName = __CLASS__, $parent = NULL, $self = false) {
		if(is_array($modelName)){	// models
			$modelName = array_shift($modelName);	// model or modelName
		}

		if(is_object($modelName)){	// model
			$modelName = CHtml::modelName($modelName);	// modelName
		}

		$primaryKey = $modelName::model()->tableSchema->primaryKey;

		$storage = array();
		$callback = null;

		$callback = function($parent, $self) use ($storage, &$callback, $modelName, $primaryKey){
	        $criteria = new CDbCriteria;
			$criteria->compare('t.parent_id', is_array($parent) ? $parent : array($parent));
			$criteria->order = 't.sort_order DESC, t.information_id ASC';

	        $categories = $modelName::model()->findAll($criteria);

	        foreach ($categories as $category) {
	        	$storage[] = $category->$primaryKey;
	        	$storage = CMap::mergeArray($storage, call_user_func($callback, $category->$primaryKey, $self));
	        }

	        return $storage;
		};

		$categoryIds = $callback($parent, $self);

		$self && array_unshift($categoryIds, $parent);

		return $categoryIds;
    }

    public function beforeSave(){
    	if(! parent::beforeSave()) return false;

    	$this->parent_id = $this->parent_id ? $this->parent_id : new CDbExpression('NULL');

    	return true;
    }

    public function beforeDelete(){
    	if(! parent::beforeDelete()) return false;

    	if(sizeOf($this->informations)){
    		Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure Including SubItems'));

    		return false;
    	}

    	return true;
    }
}