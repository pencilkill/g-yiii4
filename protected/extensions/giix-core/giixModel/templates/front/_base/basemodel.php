<?php
/**
 * This is the template for generating the model class of a specified table.
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
<?php echo "<?php\n"; ?>

/**
 * This is the model base class for the table "<?php echo $tableName; ?>".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "<?php echo $modelClass; ?>".
 *
 * Columns in table "<?php echo $tableName; ?>" available as properties of the model,
<?php if(!empty($relations)): ?>
 * followed by relations of table "<?php echo $tableName; ?>" available as properties of the model.
<?php else: ?>
 * and there are no model relations.
<?php endif; ?>
 *
<?php foreach($columns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
 *
<?php foreach(array_keys($relations) as $name): ?>
 * @property <?php
	$relationData = $this->getRelationData($modelClass, $name);
	$relationType = $relationData[0];
	$relationModel = $relationData[1];

	switch($relationType) {
		case GxActiveRecord::BELONGS_TO:
		case GxActiveRecord::HAS_ONE:
			echo $relationModel;
			break;
		case GxActiveRecord::HAS_MANY:
		case GxActiveRecord::MANY_MANY:
			echo $relationModel . '[]';
			break;
		default:
			echo 'mixed';
	}
	echo ' $' . $name . "\n";
	?>
<?php endforeach; ?>
 */
abstract class <?php echo $this->baseModelClass; ?> extends <?php echo $this->baseClass; ?> {

<?php if($i18n):?>
	public $searchI18n;
<?php endif;?>

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '<?php echo $tableName; ?>';
	}

	public static function label($n = 1) {
		return Yii::t('M/<?php echo strtolower($modelClass)?>', '<?php echo $modelClass; ?>|<?php echo $this->pluralize($modelClass); ?>', $n);
	}

	public static function representingColumn() {
<?php if (is_array($representingColumn)): ?>
		return array(
<?php foreach($representingColumn as $representingColumn_item): ?>
			'<?php echo $representingColumn_item; ?>',
<?php endforeach; ?>
		);
<?php else: ?>
		return '<?php echo $representingColumn; ?>';
<?php endif; ?>
	}

	public function rules() {
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
<?php $pattern = "/^\s*array\(\s*self::HAS_MANY\s*,\s*'{$i18nClassName}',\s*/i";?>
<?php foreach($relations as $name=>$relation): ?>
<?php
	if(preg_match($pattern, $relation)) {
		$i18nRelationName = $name;
		$relation = preg_replace('/(^\s*)array\(\s*self::HAS_MANY\s*/', '\\1array(self::HAS_ONE', $relation);
	}?>
			<?php echo "'{$name}' => {$relation},\n"; ?>
<?php endforeach; ?>
		);
	}

	public function pivotModels() {
		return array(
<?php foreach($pivotModels as $relationName=>$pivotModel): ?>
			<?php echo "'{$relationName}' => '{$pivotModel}',\n"; ?>
<?php endforeach; ?>
		);
	}

	public function attributeLabels() {
		return array(
<?php foreach($labels as $name=>$label): ?>
<?php if($label === null): ?>
			<?php echo "'{$name}' => null,\n"; ?>
<?php else: ?>
			<?php echo "'{$name}' => {$label},\n"; ?>
<?php endif; ?>
<?php endforeach; ?>
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

<?php foreach($columns as $name=>$column): ?>
<?php $partial = ($column->type==='string' and !$column->isForeignKey); ?>
<?php if($column->isPrimaryKey) $compareGroupId = $name;?>
		$criteria->compare('<?php echo $name; ?>', $this-><?php echo $name; ?><?php echo $partial ? ', true' : ''; ?>);
<?php endforeach; ?>

<?php if($i18n):?>
		$criteria->with = array('<?php echo $i18nRelationName?>');
		$criteria->group = 't.<?php echo $compareGroupId?>';
		$criteria->together = true;

<?php foreach($i18n->columns as $name=>$column):?>
<?php if($column->autoIncrement) continue;?>
<?php if($column->isForeignKey && isset($columns[$name]) && $columns[$name]->isPrimaryKey) continue;?>
<?php $partial = ($column->type==='string' and !$column->isForeignKey); ?>
<?php if(strcasecmp($name, 'language_id')===0 && $column->isForeignKey):?>
		$criteria->compare('<?php echo $i18nRelationName.'.'.$name; ?>', Yii::app()->params->languageId);
<?php continue; ?>
<?php endif;?>
		$criteria->compare('<?php echo $i18nRelationName.'.'.$name; ?>', $this->searchI18n-><?php echo $name; ?><?php echo $partial ? ', true' : ''; ?>);
<?php endforeach;?>
<?php endif;?>

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
				'attributes'=>array(
<?php if(in_array('sort_id', array_keys($columns))):?>
					'sort_id'=>array(
						'desc'=>'sort_id DESC',
						'asc'=>'sort_id',
					),
<?php endif;?>
					'*',
				),
			),
		));
	}

	public function behaviors() {
		return array(
			'CTimestampBehavior'=>array(
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
        );
	}
}