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
<?php if($this->manyRelation){?>

		$model->filterInstance();
<?php }?>

		if (isset($_GET['<?php echo $this->modelClass; ?>'])){
			$model->setAttributes($_GET['<?php echo $this->modelClass; ?>']);
		}
<?php ?>
<?php if($this->selfRelation){?>

		if(empty($_GET['<?php echo $this->modelClass; ?>']['<?php echo $this->selfRelation->columnName?>'])){
			$model->setAttribute('<?php echo $this->selfRelation->columnName?>', array(NULL));
		}
<?php }?>
<?php if($this->i18n):?>

		if (isset($_GET['<?php echo $this->i18n->className?>'])){
			$model->filter-><?php echo $this->i18n->relationNamePluralized?>->setAttributes($_GET['<?php echo $this->i18n->className?>']);
		}
<?php endif;?>

		Yii::app()->user->setState('<?php echo $this->class2id($this->modelClass)?>-grid-url', Yii::app()->request->url);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new <?php echo $this->modelClass; ?>;
<?php if($this->i18n):?>

		$i18ns = array();

		foreach($this->languages as $val){
			$va = new <?php echo $this->i18n->className?>;
			$i18ns[$val['<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?>']] = $va;
		}
<?php endif;?>

<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
<?php if($this->i18n):?>
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

			$valid = $model->validate();
<?php if($this->i18n):?>

			$i18ns = array();
			foreach($_POST['<?php echo $this->i18n->className?>'] as $val){
				$va = new <?php echo $this->i18n->className?>;
				$va->setAttributes($val);
				$va-><?php echo $this->tableSchema->primaryKey?> = 0;

				$valid = $va->validate() && $valid;

				$i18ns[$val['<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?>']] = $va;
			}
<?php endif;?>

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);
<?php if($this->i18n):?>

					foreach($i18ns as $va){
						$va-><?php echo $this->getTableSchema()->primaryKey?> = $model-><?php echo $this->getTableSchema()->primaryKey?>;
						$va->save(false);
					}
<?php endif; ?>

					$transaction->commit();

					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));
						Yii::app()->end();
					}else{
						$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') : array('index'));
					}
				}catch(CDbException $e){
					$transaction->rollback();

					Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
				}
			}else{
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Validation Failure'));
			}
		}

		$this->render('create', array(
			'model' => $model,
<?php if($this->i18n):?>
			'i18ns' => $i18ns,
<?php endif; ?>
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');
<?php if($this->i18n):?>

		$i18ns = $model-><?php echo $this->i18n->relationNamePluralized?>;
<?php endif; ?>

<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidationEx(array(
				array(
					'model' => $model,
				),
<?php if($this->i18n):?>
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

			$valid = $model->validate();
<?php if($this->i18n):?>

			$i18ns = array();
			foreach($_POST['<?php echo $this->i18n->className?>'] as $val){
				$va = new <?php echo $this->i18n->className?>;
				$va->setAttributes($val);
				$va-><?php echo $this->getTableSchema()->primaryKey?> = $model-><?php echo $this->getTableSchema()->primaryKey?>;

				$valid = $va->validate() && $valid;

				$i18ns[$val['<?php echo GiixModelCode::I18N_LANGUAGE_COLUMN_NAME?>']] = $va;
			}
<?php endif; ?>

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try{
					$model->save(false);
<?php if($this->i18n):?>

					$criteria = new CDbCriteria;
					$criteria->compare('<?php echo $this->getTableSchema()->primaryKey?>', $model-><?php echo $this->getTableSchema()->primaryKey?>);

					<?php echo $this->i18n->className?>::model()->deleteAll($criteria);
					foreach($i18ns as $va){
						$va->save(false);
					}
<?php endif; ?>

					$transaction->commit();

					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));
						Yii::app()->end();
					}else{
						$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') : array('index'));
					}
				}catch(CDbException $e){
					$transaction->rollback();

					Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
				}
			}else{
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Validation Failure'));
			}
		}

		$this->render('update', array(
			'model' => $model,
<?php if($this->i18n):?>
			'i18ns' => $i18ns,
<?php endif; ?>
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');

			if(!$model->delete()){
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure.'));
			}

			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));
				Yii::app()->end();
			}else{
				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') :  $this->createUrl('index'));
			}
		} else {
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	}


	public function action<?php echo ucfirst(strtolower($this->gridViewDeleteAction))?>() {
		if (Yii::app()->getRequest()->getIsPostRequest()){
			$selected = Yii::app()->getRequest()->getPost('selected');

			$criteria= new CDbCriteria;
			$criteria->compare('<?php echo $this->tableSchema->primaryKey; ?>', $selected);

			$models = Category::model()->findAll($criteria);

			$errorModel = null;

			$transaction = Yii::app()->db->beginTransaction();

			try{
				foreach ($models as $model){
					if(!$model->delete()) {
						$errorModel = $model;

						Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure.'));

						break;
					}
				}

				$transaction->commit();

			}catch(CDbException $e){
				$transaction->rollback();

				Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
			}

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));
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
				if(!$model->validate()) {
					$errorModel = $model;
					break;
				}
			}

			if(!$errorModel){
				$transaction = Yii::app()->db->beginTransaction();

				try{
					foreach ($models as $model){
						$model->save(false);
					}

					$transaction->commit();

				}catch(CDbException $e){
					$transaction->rollback();

					Yii::app()->user->setFlash('warning', Yii::t('app', 'Commition Failure'));
				}
			}else{
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure.'));
			}

			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CJSON::encode(Yii::app()->user->getFlashes(false) ? Yii::app()->user->getFlashes(true) : array('success' => true));
				Yii::app()->end();
			} else{
				$this->redirect(Yii::app()->getRequest()->getPost('returnUrl') ? Yii::app()->getRequest()->getPost('returnUrl') :  $this->create('index'));
			}
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

}