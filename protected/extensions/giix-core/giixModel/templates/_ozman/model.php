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

	$relationMany = false;

	foreach($relations as $name => $relation){
		if($name == $selfRelationName && preg_match("/^\s*array\s*\(\s*self::(HAS|MANY)_MANY\s*,\s*'{$modelClass}'\s*,\s*'(\w+)'\s*,?/i", $relation, $relationColumn)){
			$selfRelation = true;
			$selfRelationColumn = $relationColumn[2];
		}

		if(preg_match("/^\s*array\s*\(\s*self::(HAS|MANY)_MANY\s*,/i", $relation)){
			$relationMany = true;
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
<?php if($relationMany){?>

	public $filter;
<?php }?>

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function behaviors() {
		return CMap::mergeArray(parent::behaviors(), array(
<?php if($relationMany){?>
			'CActiveRecordFilterBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordFilterBehavior',
			),
<?php }?>
<?php if(array_key_exists('create_time', $columns) || array_key_exists('create_time', $columns)){?>
			'CTimestampBehavior'=> array(
				'class' => 'zii.behaviors.CTimestampBehavior',
<?php if(array_key_exists('create_time', $columns)){?>
				'updateAttribute' => 'update_time',
<?php }else{?>
				'updateAttribute' => null,
<?php }?>
<?php if(array_key_exists('create_time', $columns)){?>
				'createAttribute' => 'create_time',
<?php }else{?>
                'createAttribute' => null,
<?php }?>
				'setUpdateOnCreate' => true,
			),
<?php }?>
<?php if($selfRelation){?>
			'CActiveRecordNullBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordNullBehavior',
				'attributes' => array(
					'<?php echo $selfRelationColumn?>',
				),
			),
			'CTreeBehavior' => array(
				'class' => 'backend.behaviors.CTreeBehavior',
<?php if($i18n){?>
				'textAttribute' => '<?php echo $i18n->relationName?>.title',
<?php }else{?>
				'textAttribute' => '<?php echo $table->primaryKey?>',
<?php }?>
			),
<?php }?>
<?php if($i18n){?>
			'CActiveRecordI18nBehavior' => array(
				'class' => 'backend.behaviors.CActiveRecordI18nBehavior',
				'relations' => array(
					'categoryI18ns' => array(
						'indexes' => CHtml::listData(Language::model()->findAll(), 'language_id', 'language_id'),
					),
				)
			),
<?php }?>
        ));
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(), array(
<?php if($selfRelation){?>
			array('<?php echo "{$selfRelationColumn}"?>', 'validParentId', 'on' => 'update'),
<?php }?>
		));
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
<?php foreach($labels as $name=>$label){ ?>
<?php if($label === null){ ?>
			<?php echo "'{$name}' => null,\n"; ?>
<?php } ?>
<?php } ?>
		));
	}

	public function search() {
		$_provider = parent::search();
		$alias = $this->tableAlias;
		$criteria = $_provider->getCriteria();

		$criteria->group = "{$alias}.<?php echo $table->primaryKey?>";
		$criteria->together = true;
<?php if($i18n):?>

		$criteria->with = array('<?php echo $i18n->relationNamePluralized?>');
<?php foreach($i18n->table->columns as $name=>$column):?>
<?php if($column->autoIncrement) continue;?>
<?php if($column->isForeignKey && isset($columns[$name]) && $columns[$name]->isPrimaryKey) continue;?>
<?php if($name == GiixModelCode::I18N_LANGUAGE_COLUMN_NAME && $column->isForeignKey) continue;?>
		$criteria->compare('<?php echo $i18n->relationNamePluralized . '.' . $name; ?>', $this->filter-><?php echo $i18n->relationNamePluralized?>-><?php echo $name; ?><?php echo ($column->type==='string' and !$column->isForeignKey) ? ', true' : ''; ?>);
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

	public function validParentId(){
    	$categoryIds = $this->subNodes($this-><?php echo $table->primaryKey?>, true);

    	if(in_array($this-><?php echo $selfRelationColumn?>, $categoryIds)){
    		$this->addError('<?php echo $selfRelationColumn?>', Yii::t('app', 'Parent_id can not be self or children'));
    	}
    }

<?php endif;?>
<?php if($beforeDelete){?>

    public function beforeDelete(){
    	// Raise event
    	if(!parent::beforeDelete()) return false;

    	if(<?php echo implode(' || ', $beforeDelete)?>){
    		Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure Including SubItems'));

    		return false;
    	}

    	return true;
    }
<?php }?>
}