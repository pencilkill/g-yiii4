<?php

class SettingController extends GxController {

	public function actionIndex() {
		$model = new HCSetting;

		$this->performAjaxValidation($model, 'setting-form');

		if(isset($_POST['HCSetting'])){

			$model = HCSetting::settingValidate(Setting::model()->rules());

			if($model->hasErrors()===false){
				foreach ($_POST['HCSetting'] as $key=>$val) {
					Yii::app()->config->set($key, $val);
				}
			}
		}

		$this->render('index', array(
			'model' => $model,
		));
	}

	protected function performAjaxValidation($model, $form = null){
		if (Yii::app()->getRequest()->getIsAjaxRequest() && (($form === null) || ($_POST['ajax'] == $form))) {
			$model = HCSetting::settingValidate(Setting::model()->rules());

			$result = array();
			foreach($model->getErrors() as $attribute=>$errors){
				$result[CHtml::activeId($model,$attribute)]=$errors;
			}

			echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);

			Yii::app()->end();
		}
	}
}