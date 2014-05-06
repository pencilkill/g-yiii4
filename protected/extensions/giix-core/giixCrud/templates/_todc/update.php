<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n
\$this->breadcrumbs = array(
	\$model->label(2) => array('index'),
	Yii::t('app', 'Update'),
);\n";
?>
?>

<?php echo "<?php\n"; ?>
<?php if($this->i18n):?>
$this->renderPartial(
	'_formI18n',
	array(
<?php ;else:?>
$this->renderPartial(
	'_form',
	array(
<?php endif;?>
		'model' => $model,
<?php if($this->i18n):?>
		'i18ns' => $i18ns,
<?php endif;?>
	)
);
?>