<?php

Yii::import('backend.models._base.BaseCategory');

class Category extends BaseCategory
{
	
	public function rules() {
		return array_merge(
			parent::rules(),
			array(
				array('parent_id', 'validParentId'),
			)
		);
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 *  Get all child node base on $parent
	 *  category level will be added on for each node
	 *  please note that default level is custom variable, you can set it as zero while the root node is not zero
	 * @return array
	 * @param $parent, root node
	 * @param $level
	 */
	public static function getCategories($parent=0, $level=0) {
		$storage = array();
		$language_id = Yii::app()->getController()->language_id;
		$callback = null;
		
		$callback = function($parent, $level, $language_id) use ($storage, &$callback){
	        $criteria = new CDbCriteria;
	        $criteria->addCondition(array("parent_id='{$parent}'"));
	        
	        $criteria->with = array('categoryI18ns'=>array('condition'=>"language_id='{$language_id}'"));
			$criteria->group = 't.category_id';
			$criteria->together = true;
			
	        $model = Category::model()->findAll($criteria);
	        
	        foreach ($model as $key) {
	        	$subCategories = call_user_func($callback, $key->category_id, $level+1, $language_id);
	        	$storage[] = array(
	        		'category_id' => $key->category_id,
	        		'parent_id' => $key->parent_id,
	        		'level' => $level,
	        		'title' => $key->categoryI18ns[$language_id]->title,
	        		'totalSubCategories' => sizeOf($subCategories),
	        	);
	        	$storage = array_merge($storage, $subCategories);
	        }

	        return $storage;
		};
		
		return $callback($parent, $level, $language_id);
    }
    
	/**
	 *  Get all child node id base on $parent
	 * @return array
	 * @param $parent, root node
	 */
	public static function getCategoryIds($parent=0, $self=false) {
		$storage = array();
		$callback = null;
		
		$callback = function($parent, $self) use ($storage, &$callback){
	        $criteria = new CDbCriteria;
	        $criteria->addCondition(array("parent_id='{$parent}'"));
	        
	        $model = Category::model()->findAll($criteria);
	        
	        foreach ($model as $key) {
	        	$storage[] = $key->category_id;
	        	$storage = array_merge($storage, call_user_func($callback, $key->category_id, $self));
	        }

	        return $storage;
		};
		
		$categoryIds = $callback($parent, $self);

		$self && array_unshift($categoryIds, $parent);
		
		return $categoryIds;
    }
    
    public function validParentId(){
    	$categoryIds = Category::getCategoryIds($this->category_id, true);

    	if(in_array($this->parent_id, $categoryIds)){
    		$this->addError('parent_id', Yii::t('M/category', 'Parent_id can not be self or children'));
    	}
    }

}