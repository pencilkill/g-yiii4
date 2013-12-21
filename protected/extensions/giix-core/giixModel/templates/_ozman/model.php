<?php
/**
 * This is the template for generating the model class of a specified table.
 * In addition to the default model Code, this adds the CSaveRelationsBehavior
 * to the model class definition.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 * - $representingColumn: the name of the representing column for the table (string) or
 *   the names of the representing columns (array)
 */
?>
<?php
	$selfRelation = false;
	$selfRelationColumn = '';
	$i18nRelationName = '';
	$primaryKey = '';

	foreach(array_keys($relations) as $name){
		$relationData = $this->getRelationData($modelClass, $name);
		$relationType = $relationData[0];
		$relationModel = $relationData[1];

		if($relationModel == $modelClass){
			$pattern = "/^\s*array\(\s*self::BELONGS_TO\s*,\s*'{$modelClass}',\s*'(\w+)'/i";

			preg_match($pattern, $relations[$name], $relationColumn);

			if($relationColumn){
				$selfRelation = true;
				$selfRelationColumn = $relationColumn[1];
			}
		}

		if($i18n && $relationModel == $i18nClassName){
			$i18nRelationName = $name;
		}
	}

	foreach($columns as $name => $column){
		if($column->isPrimaryKey){
			$primaryKey = $name;
			break;
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
<?php if($selfRelation && $primaryKey):?>

	public static function getCategories($parent=NULL, $level=0) {
		$storage = array();
		$language_id = Yii::app()->getController()->language_id;
		$callback = null;

		$callback = function($parent, $level, $language_id) use ($storage, &$callback){
			$criteria = new CDbCriteria;
			if($parent === NULL){
				$criteria->addCondition('<?php echo $selfRelationColumn?> IS NULL');
			}else{
				$criteria->compare('<?php echo $selfRelationColumn?>', $parent);
			}
<?php if($i18n):?>

			$criteria->with = array(
				'<?php echo $i18nRelationName?>'=>array(
					'condition'=>'language_id=:language_id',
					'params' => array(':language_id' => $language_id)
				)
			);
			$criteria->group = 't.<?php echo $primaryKey?>';
			$criteria->together = true;
<?php endif;?>

			$categories = <?php echo $modelClass?>::model()->findAll($criteria);

			foreach ($categories as $category) {
				$subCategories = call_user_func($callback, $category-><?php echo $primaryKey?>, $level+1, $language_id);
				$storage[] = array(
					'<?php echo $primaryKey?>' => $category-><?php echo $primaryKey?>,
					'<?php echo $selfRelationColumn?>' => $category-><?php echo $selfRelationColumn?>,
					'level' => $level,
					'title' => $category-><?php echo $i18nRelationName?>[$language_id]->title,
					'totalSubCategories' => sizeOf($subCategories),
				);
				$storage = array_merge($storage, $subCategories);
			}

			return $storage;
		};

		return $callback($parent, $level, $language_id);
	}

	public static function getCategoryIds($parent=NULL, $self=false) {
		$storage = array();
		$callback = null;

		$callback = function($parent, $self) use ($storage, &$callback){
	        $criteria = new CDbCriteria;
        	if($parent === NULL){
				$criteria->addCondition('<?php echo $selfRelationColumn?> IS NULL');
			}else{
				$criteria->compare('<?php echo $selfRelationColumn?>', $parent);
			}

	        $categories = <?php echo $modelClass?>::model()->findAll($criteria);

	        foreach ($categories as $category) {
	        	$storage[] = $category-><?php echo $primaryKey?>;
	        	$storage = array_merge($storage, call_user_func($callback, $category-><?php echo $primaryKey?>, $self));
	        }

	        return $storage;
		};

		$categoryIds = $callback($parent, $self);

		$self && array_unshift($categoryIds, $parent);

		return $categoryIds;
    }
<?php endif;?>
}