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
	$authpath = 'ext.giix-core.giixCrud.templates.default.auth.';
	Yii::app()->controller->renderPartial($authpath . $this->authtype);
?>


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
<?php if($this->i18nRelation):?>
			'i18n' => $i18n,
<?php endif;?>
		));
	}

	public function actionCreate() {
		$model = new <?php echo $this->modelClass; ?>;
<?php if($this->i18nRelation):?>

		$i18ns = array();

		foreach($this->languages as $val){
			$i18n = new <?php echo $this->i18nRelation[3]?>;
			$i18ns[$val['language_id']] = $i18n;
		}
<?php endif;?>

<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
<?php if($this->i18nRelation):?>
				array(
					'model' => $i18ns,
					'many' => true,
				),
<?php endif;?>
			),
			'<?php echo $this->class2id($this->modelClass)?>-form'
		);
<?php endif; ?>

		if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
			$model->setAttributes($_POST['<?php echo $this->modelClass; ?>']);
<?php if($this->i18nRelation):?>

			$valid = true;

			foreach($this->languages as $val){
				$i18ns[$val['language_id']]->setAttributes($_POST['<?php echo $this->i18nRelation[3]?>'][$val['language_id']]);
				$i18ns[$val['language_id']]->language_id = $val['language_id'];
				$i18ns[$val['language_id']]-><?php echo $this->getTableSchema()->primaryKey?> = 0;

				$valid = $i18ns[$val['language_id']]->validate() && $valid;
			}
<?php endif;?>


<?php if($this->i18nRelation):?>
			if ($valid && $model->validate()) {
<?php else: ?>
			if ($model->validate()) {
<?php endif; ?>
				$model->save(false);
<?php if($this->i18nRelation):?>

				foreach($this->languages as $val){
					$i18ns[$val['language_id']]-><?php echo $this->getTableSchema()->primaryKey?> = $model-><?php echo $this->getTableSchema()->primaryKey?>;
					$i18ns[$val['language_id']]->save();
				}
<?php endif; ?>
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					Yii::app()->end();
				}else{
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('create', array(
			'model' => $model,
<?php if($this->i18nRelation):?>
			'i18ns' => $i18ns,
<?php endif; ?>
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');
<?php if($this->i18nRelation):?>

		$i18ns = $model-><?php echo $this->i18nRelation[0]?>;
<?php endif; ?>

<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
<?php if($this->i18nRelation):?>
				array(
					'model' => $i18ns,
					'many' => true,
				),
<?php endif; ?>
			),
			'<?php echo $this->class2id($this->modelClass)?>-form'
		);
<?php endif; ?>

		if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
			$model->setAttributes($_POST['<?php echo $this->modelClass; ?>']);
<?php if($this->i18nRelation):?>
			$valid = true;

			foreach($this->languages as $val){
				$i18ns[$val['language_id']]->setAttributes($_POST['<?php echo $this->i18nRelation[3]?>'][$val['language_id']]);
				$i18ns[$val['language_id']]->language_id = $val['language_id'];
				$i18ns[$val['language_id']]-><?php echo $this->getTableSchema()->primaryKey?> = $model-><?php echo $this->getTableSchema()->primaryKey?>;

				$valid = $i18ns[$val['language_id']]->validate() && $valid;
			}
<?php endif; ?>

<?php if($this->i18nRelation):?>
			if ($valid && $model->validate()) {
<?php ;else: ?>
			if ($model->validate()) {
<?php endif; ?>
				$model->save(false);
<?php if($this->i18nRelation):?>

				foreach($this->languages as $val){
					$i18ns[$val['language_id']]->save();
				}
<?php endif; ?>
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					Yii::app()->end();
				}else{
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('update', array(
			'model' => $model,
<?php if($this->i18nRelation):?>
			'i18ns' => $i18ns,
<?php endif; ?>
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, '<?php echo $this->modelClass; ?>')->delete();

			if (! Yii::app()->getRequest()->getIsAjaxRequest()){
				$this->redirect(array('index'));
			}
		} else {
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	}


	public function action<?php echo ucfirst(strtolower($this->gridViewDeleteAction))?>() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$model = new <?php echo $this->modelClass; ?>;

			$criteria= new CDbCriteria;
			$criteria->compare('<?php echo $this->tableSchema->primaryKey; ?>', Yii::app()->getRequest()->getPost('selected'));

			<?php echo $this->modelClass; ?>::model()->deleteAll($criteria);

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(array('success' => true));
				Yii::app()->end();
			} else{
				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') : $this->createUrl('index'));
			}
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}


	public function action<?php echo ucfirst(strtolower($this->gridViewEditAction))?>() {
		if (Yii::app()->getRequest()->getIsPostRequest()){

			$<?php echo $this->gridViewEditName?>Posts = Yii::app()->getRequest()->getPost('<?php echo $this->gridViewEditName?>');
			$<?php echo $this->gridViewEditName?>Ids = array_keys($<?php echo $this->gridViewEditName?>Posts);

			$errorModel = null;

			$model = new <?php echo $this->modelClass; ?>;

			$criteria= new CDbCriteria;
			$criteria->compare('<?php echo $this->tableSchema->primaryKey; ?>', $<?php echo $this->gridViewEditName?>Ids);

			$models = <?php echo $this->modelClass; ?>::model()->findAll($criteria);

			foreach ($models as $model){
				$model->setAttributes($<?php echo $this->gridViewEditName?>Posts[$model-><?php echo $this->tableSchema->primaryKey; ?>]);
				if(! $model->validate()) {
					$errorModel = $model;
					break;
				}
			}

			if(! $errorModel){
				foreach ($models as $model){
					$model->save(false);
				}
			}

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(array('success' => true));
				Yii::app()->end();
			} else{
				$errorModel && Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure'));

				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') :  $this->create('index'));
			}
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

}