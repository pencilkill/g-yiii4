<?php

class SettingController extends GxController {



	public function actionIndex() {
		if(isset($_POST['Setting'])){
			foreach ($_POST['Setting'] as $key=>$val) {
				Yii::app()->config->set($key, $val);
			}
		}

		$this->render('index', array(
			//
		));
	}


}