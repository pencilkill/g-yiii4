<?php

class SettingController extends GxController {



	public function actionIndex($group = 'meta') {
		if(isset($_POST['Setting'])){
			foreach ($_POST['Setting'] as $key=>$val) {
				Yii::app()->config->set($key, $val);
			}
			
			$this->redirect(array('index', 'group'=>$group));
		}

		$this->render('index', array(
			'group' => $group,
		));
	}
	
	
}