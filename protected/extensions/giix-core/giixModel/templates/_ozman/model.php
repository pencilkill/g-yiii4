<?php
/**
 * This is the template for generating the model class of a specified table.
 * In addition to the default model Code, this adds the CSaveRelationsBehavior
 * to the model class definition.
 * - $this: the ModelCode object
 * - $table: the table object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 * - $representingColumn: the name of the representing column for the table (string) or
 *   the names of the representing columns (array)
 * - $i18n: the i18n object
 */
?>
<?php
	$selfRelationName = $this->generateRelationName($table->name, $table->name, true);
	$selfRelation = false;
	$selfRelationColumn = '';

	$beforeDelete = array();

	foreach($relations as $name => $relation){
		if($name == $selfRelationName && preg_match("/^\s*array\s*\(\s*self::HAS_MANY\s*,\s*'{$modelClass}'\s*,\s*'(\w+)'\s*,?/i", $relation, $relationColumn)){
			$selfRelation = true;
			$selfRelationColumn = $relationColumn[1];
		}
		// beforeDelete
		if(preg_match("/^\s*array\s*\(\s*self::(HAS|MANY)_MANY\s*,.*/i", $relation)){
			if(empty($i18n) || ($name != $i18n->relationNamePluralized)){
				$beforeDelete[] = 'sizeOf($this->' . $name . ')';
			}
		}

	}
?>
<?php echo "<?php\n"; ?>

Yii::import('<?php echo "{$this->baseModelPath}.{$this->baseModelClass}"; ?>');

class <?php echo $modelClass; ?> extends <?php echo $this->baseModelClass."\n"; ?>
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
<?php if(substr($tableName, -5) == GiixModelCode::I18N_TABLE_SUFFIX){?>

	public function t($<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?> = null){
		$<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?> = empty($<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?>) ? Yii::app()->controller->language_id : $<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?>;

		$this->getDbCriteria()->mergeWith(array(
			'condition' => "{$this->tableAlias}.<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?>= '{$<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?>}'",
		));

		return $this;
	}
<?php }?>
<?php if($selfRelation):?>

	public function rules() {
		return CMap::mergeArray(
			parent::rules(),
			array(
				array('<?php echo "{$selfRelationColumn}"?>', 'validParentId', 'on' => 'update'),
			)
		);
	}


	/**
	 * Validate parent_id
	 */

	public function validParentId(){
    	$categoryIds = self::getCategoryIds(__CLASS__, $this-><?php echo $table->primaryKey?>, true);

    	if(in_array($this-><?php echo $selfRelationColumn?>, $categoryIds)){
    		$this->addError('<?php echo $selfRelationColumn?>', Yii::t('m/<?php echo strtolower($modelClass)?>', 'Parent_id can not be self or children'));
    	}
    }

	/**
	 * Get all child node base on $parent
	 * category level will be added on for each node
	 * please note that default level is custom variable, you can set it as zero while the root node is not zero
	 *
	 * @param $modelName, the model class name
	 * @param $parent, root node
	 * @param $textAttribute, attribute to show
	 * @param $level
	 * @return array
	 */

	public static function getCategories($modelName = __CLASS__, $parent = NULL, $textAttribute = '<?php echo $i18n ? "{$i18n->relationName}.title" : ''?>', $level=0) {
		if(is_array($modelName)){	// models
			$modelName = array_shift($modelName);	// model
		}

		$modelName = CHtml::modelName($modelName);	// modelName

		$primaryKey = $modelName::model()->tableSchema->primaryKey;

		$storage = array();
		$callback = null;

		$callback = function($parent, $level) use ($storage, &$callback, $modelName, $primaryKey, $textAttribute){
			$criteria = new CDbCriteria;
			$criteria->compare('<?php echo "t.{$selfRelationColumn}"?>', is_array($parent) ? $parent : array($parent));
			$criteria->order = '<?php echo array_key_exists('sort_order', $columns) ? 't.sort_order DESC, ' : ''?>t.<?php echo $table->primaryKey?> ASC';

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
	 * @param $modelName, the model class name
	 * @param $parent
	 * @param $textAttribute, attribute to show
	 * @param $level
	 * @return array
	 */

	public static function getDropListData($modelName = __CLASS__, $parent = NULL, $textAttribute = '<?php echo $i18n ? "{$i18n->relationName}.title" : ''?>', $level=0) {
		if(is_array($modelName)){	// models
			$modelName = array_shift($modelName);	// model
		}

		$modelName = CHtml::modelName($modelName);	// modelName

		$primaryKey = $modelName::model()->tableSchema->primaryKey;

		$storage = array();
		$callback = null;

		$callback = function($parent, $level) use ($storage, &$callback, $modelName, $primaryKey, $textAttribute){
			$criteria = new CDbCriteria;
			$criteria->compare('<?php echo "t.{$selfRelationColumn}"?>', is_array($parent) ? $parent : array($parent));
			$criteria->order = '<?php echo array_key_exists('sort_order', $columns) ? 't.sort_order DESC, ' : ''?>t.<?php echo $table->primaryKey?> ASC';

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
	 * @param $modelName, the model class name
	 * @param $parent, root node
	 * @param $self, whether the return value includes the $parend or not
	 * @return array
	 */

	public static function getCategoryIds($modelName = __CLASS__, $parent = NULL, $self = false) {
		if(is_array($modelName)){	// models
			$modelName = array_shift($modelName);	// model
		}

		$modelName = CHtml::modelName($modelName);	// modelName

		$primaryKey = $modelName::model()->tableSchema->primaryKey;

		$storage = array();
		$callback = null;

		$callback = function($parent, $self) use ($storage, &$callback, $modelName, $primaryKey){
	        $criteria = new CDbCriteria;
			$criteria->compare('<?php echo "t.{$selfRelationColumn}"?>', is_array($parent) ? $parent : array($parent));
			$criteria->order = '<?php echo array_key_exists('sort_order', $columns) ? 't.sort_order DESC, ' : ''?>t.<?php echo $table->primaryKey?> ASC';

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

	/**
     * The zii.behavior.CTimestampBehavior has been enabled in baseModel already
     *
     * @return boolean
     */

    public function beforeSave(){
    	if(!parent::beforeSave()) return false;

    	$this-><?php echo $selfRelationColumn?> = $this-><?php echo $selfRelationColumn?> ? $this-><?php echo $selfRelationColumn?> : new CDbExpression('NULL');

    	return true;
    }
<?php endif;?>
<?php if($beforeDelete){?>

	/**
     * Checking relations before the DB fk constraint
     *
     * @return boolean
     */

    public function beforeDelete(){
    	if(!parent::beforeDelete()) return false;

    	if(<?php echo implode(' || ', $beforeDelete)?>){
    		Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure Including SubItems'));

    		return false;
    	}

    	return true;
    }
<?php }?>
}