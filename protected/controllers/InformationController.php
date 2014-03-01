<?php


class InformationController extends GxController {

	public function actionView($id) {
		$model = $this->loadModel($id, 'Information');

		//Yii::app()->clientScript->registerMetaTag($model->informationI18ns->keywords, 'keywords', null, null, 'keywords');
    	//Yii::app()->clientScript->registerMetaTag($model->informationI18ns->description, 'description', null, null, 'description');

		$this->render('view', array(
			'model' => $model,
		));
	}

}