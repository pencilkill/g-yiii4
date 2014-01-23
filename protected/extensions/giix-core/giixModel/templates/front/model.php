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
	$defaultScopes = array('status' => '1');
	$defaultScopeCondition = array();
	$defaultScopeParams = array();
	if($defaultScopes = array_intersect_key($defaultScopes, $columns)){
		foreach($defaultScopes as $key => $val){
			$defaultScopeCondition[] = "{\$alias}.{$key}=:{$key}";
			$defaultScopeParams[] = "':{$key}' => $val";
		}
	}
	$defaultScopeCondition = implode(', ', $defaultScopeCondition);
	$defaultScopeParams = 'array(' . implode(', ', $defaultScopeParams) . ')';

	$defaultScopes = array('sort_order' => 'DESC');
	$defaultScopeSort = array();
	if($defaultScopes = array_intersect_key($defaultScopes, $columns)){
		foreach($defaultScopes as $key => $val){
			$defaultScopeSort[] = "{\$alias}.{$key} {$val}";
		}
	}
	$defaultScopeSort[] = "{\$alias}.{$table->primaryKey} DESC";
	$defaultScopeSort = implode(', ', $defaultScopeSort);

	$relationMany = false;

	foreach($relations as $name => $relation){
		if(preg_match("/^\s*array\s*\(\s*self::(HAS|MANY)_MANY\s*,/i", $relation)){
			$relationMany = true;
		}
	}
?>
<?php echo "<?php\n"; ?>

Yii::import('<?php echo "{$this->baseModelPath}.{$this->baseModelClass}"; ?>');

class <?php echo $modelClass; ?> extends <?php echo $this->baseModelClass."\n"; ?>
{
<?php if($relationMany){?>

	public $filter;
<?php }?>

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
<?php if($defaultScopeCondition || $defaultScopeSort):?>

	public function defaultScope(){
		$alias = $this->getTableAlias(false, false);

		return CMap::mergeArray(parent::defaultScope(), array(
<?php if($i18n && ($a = $i18n->table->getColumn('status')) && $a->type == 'integer'):?>
			'with' => array(
				'<?php echo $i18n->relationName?>',
			),
<?php endif?>
<?php if($defaultScopeCondition):?>
			'condition' => "<?php echo $defaultScopeCondition?>",
			'params' => <?php echo $defaultScopeParams?>,
<?php endif;?>
<?php if($defaultScopeSort):?>
			'order' => "<?php echo $defaultScopeSort?>",
<?php endif;?>
		));
	}
<?php endif;?>
<?php if($relationMany){?>

	public function behaviors() {
		return CMap::mergeArray(parent::behaviors(), array(
			'CActiveRecordFilterBehavior' => array(
				'class' => 'frontend.behaviors.CActiveRecordFilterBehavior',
			),
        ));
	}
<?php }?>
<?php if(substr(strtolower($modelClass), -4) == 'i18n'):?>

	public function t($languageId=null){
		if(empty($languageId)){
			$languageId = Yii::app()->params->languageId;
		}

		$this->getDbCriteria()->mergeWith(array(
			'condition' => "{$this->tableAlias}.language_id=:language_id",
			'params' => array(':language_id' => $languageId),
 		));

		return $this;
	}
<?php endif;?>

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.<?php echo $table->primaryKey?>";
		$criteria->together = true;
<?php if($i18n):?>

		$criteria->with[] = '<?php echo $i18n->relationName?>';
<?php foreach($i18n->table->columns as $name=>$column):?>
<?php if($column->autoIncrement) continue;?>
<?php if($column->isForeignKey && isset($columns[$name]) && $columns[$name]->isPrimaryKey) continue;?>
<?php if($name == GiixModelCode::I18N_LANGUAGE_COLUMN_NAME && $column->isForeignKey) continue;?>
		$criteria->compare('<?php echo $i18n->relationName . '.' . $name; ?>', $this->filter-><?php echo $i18n->relationName?>-><?php echo $name; ?><?php echo ($column->type==='string' and !$column->isForeignKey) ? ', true' : ''; ?>);
<?php endforeach;?>
<?php endif;?>

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'defaultOrder' => array(
<?php if(array_key_exists('sort_order', $columns)):?>
					"{$alias}.sort_order" => CSort::SORT_DESC,
<?php endif;?>
					"{$alias}.<?php echo $table->primaryKey?>" => CSort::SORT_ASC,
				),
				'multiSort'=>true,
				'attributes'=>array(
<?php if(array_key_exists('sort_order', $columns)):?>
					'sort_order'=>array(
						'desc'=>"{$alias}.sort_order DESC",
						'asc'=>"{$alias}.sort_order ASC",
					),
<?php endif;?>
					'*',
				),
			),
<?php if(substr($tableName, -5) !== GiixModelCode::I18N_TABLE_SUFFIX && strpos($tableName, '2') === false):?>
			'pagination' => array(
				'pageSize' => Yii::app()->request->getParam('pageSize', 10),
				'pageVar' => 'page',
			),
<?php ;else:?>
			'pagination' => false,
<?php endif;?>
		));
	}
}