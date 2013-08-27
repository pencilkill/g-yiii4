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
<?php if($this->i18nRelation):?>

		$i18n = new <?php echo $this->i18nRelation[3]?>('search');
		$i18n->unsetAttributes();

		$model->searchI18n = $i18n;
<?php endif;?>

		if (isset($_GET['<?php echo $this->modelClass; ?>'])){
			$model->setAttributes($_GET['<?php echo $this->modelClass; ?>']);
		}
<?php if($this->i18nRelation):?>

		if (isset($_GET['<?php echo $this->i18nRelation[3]?>'])){
			$i18n->setAttributes($_GET['<?php echo $this->i18nRelation[3]?>']);
		}
<?php endif;?>

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionView($id) {
		$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');

		//Yii::app()->clientScript->registerMetaTag($model-><?php echo $this->i18nRelation[0]?>->keywords, 'keywords', null, null, 'keywords');
    	//Yii::app()->clientScript->registerMetaTag($model-><?php echo $this->i18nRelation[0]?>->description, 'description', null, null, 'description');

		$this->render('view', array(
			'model' => $model,
		));
	}

}