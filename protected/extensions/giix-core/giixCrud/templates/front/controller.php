<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

<?php
	/**
	 * try to set i18nRelation
	 */
	$this->getRelations($this->modelClass)
?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass; ?> {

<?php
	$authpath = 'ext.giix-core.giixCrud.templates.front.auth.';
	Yii::app()->controller->renderPartial($authpath . $this->authtype);
?>

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			/*
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'testLimit'=>1,
			),
			*/
		);
	}

	public function actionIndex() {
		$model = new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();
<?php if($this->manyRelation){?>

		$model->filterInstance();
<?php }?>
<?php if($this->i18n):?>

		$model->filter-><?php echo $this->i18n->relationName?> = new <?php echo $this->i18n->className?>('search');
		$model->filter-><?php echo $this->i18n->relationName?>->unsetAttributes();
<?php endif;?>

		if (isset($_GET['<?php echo $this->modelClass; ?>'])){
			$model->setAttributes($_GET['<?php echo $this->modelClass; ?>']);
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionView($id) {
		$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');

<?php if($this->i18n){?>
		//Yii::app()->clientScript->registerMetaTag($model-><?php echo $this->i18n->relationName?>->keywords, 'keywords', null, null, 'keywords');
    	//Yii::app()->clientScript->registerMetaTag($model-><?php echo $this->i18n->relationName?>->description, 'description', null, null, 'description');
<?php }?>

		$this->render('view', array(
			'model' => $model,
		));
	}

}