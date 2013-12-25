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
	$primaryKey = NULL;
	foreach($columns as $name => $column){
		if($column->isPrimaryKey){
			$primaryKey = $name;
			break;
		}
	}
	
	$defaultScopes = array('status' => '1');
	$defaultScopeCondition = array();
	if($defaultScopes = array_intersect_key($defaultScopes, $columns)){
		foreach($defaultScopes as $key => $val){
			$defaultScopeCondition[] = "{\$alias}.{$key} = '{$val}'";
		}
	}
	$defaultScopeCondition = implode(', ', $defaultScopeCondition);
	
	$defaultScopes = array('sort_id' => 'DESC');
	$defaultScopeSort = array();
	if($defaultScopes = array_intersect_key($defaultScopes, $columns)){
		foreach($defaultScopes as $key => $val){
			$defaultScopeSort[] = "{\$alias}.{$key} {$val}";
		}
	}
	$defaultScopeSort[] = "{\$alias}.{$primaryKey} DESC";
	$defaultScopeSort = implode(', ', $defaultScopeSort);
?>
<?php echo "<?php\n"; ?>

Yii::import('<?php echo "{$this->baseModelPath}.{$this->baseModelClass}"; ?>');

class <?php echo $modelClass; ?> extends <?php echo $this->baseModelClass."\n"; ?>
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
<?php if($defaultScopeCondition || $defaultScopeSort):?>

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);
		
		return CMap::mergeArray(parent::defaultScope(), array(
<?php if($defaultScopeCondition):?>
			'condition' => "<?php echo $defaultScopeCondition?>",
<?php endif;?>
<?php if($defaultScopeSort):?>
			'order' => "<?php echo $defaultScopeSort?>"
<?php endif;?>
		));
	}
<?php endif;?>
<?php if(substr(strtolower($modelClass), -4) == 'i18n'):?>

	public function t($languageId=null){
		if(empty($languageId)){
			$languageId = Yii::app()->params->languageId;
		}

		$this->getDbCriteria()->mergeWith(array(
			'condition' => "{$this->tableAlias}.language_id = '{$languageId}'",
		));

		return $this;
	}
<?php endif;?>
}