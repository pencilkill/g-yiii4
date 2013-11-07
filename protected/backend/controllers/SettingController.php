<?php
/**
 *
 * @author Sam@ozchamp.net
 * SettingController
 * Notice setting is like key=>value, so we can not use normal rules to validate the model
 * It will create a dynamic behavior to valiate the model without further changing
 *
 * A setting can be added from view file directly
 * It will delete the setting which is not posted from view file while exists in db already
 */
class SettingController extends GxController {

	public function actionIndex() {
		$model = Setting::model();

		// parse data using unserialize, compatible with Yii::app()->config->get()
		$settings = CHtml::listData($model->findAll(), 'key', function($row){return unserialize($row->value);});

		// merge post without checking key
		if(isset($_POST['Setting'])){
			$settings = CMap::mergeArray($settings, $_POST['Setting']);
		}

		$values = array();

		// create class string dynamicly
		$behaviorClassName = 'SettingBehavior';

		$behaviorClassString = 'class '.$behaviorClassName.' extends CActiveRecordBehavior {';
		foreach ($settings as $key => $value){
			// Key should be compatibel with PHP variable : A-Z,a-z,0-9,_
			if(preg_match('/[^a-z_0-9]/i', $key)){
				throw new Exception('Setting key :'.$key.' is illegal !');

				Yii::app()->end();
			}
			$behaviorClassString .= 'public $'. $key . ';';		// Seeing model save

			$values[$key] = $value;
		}
		$behaviorClassString .= '}';

		// Defined class
		eval($behaviorClassString);

		// attach behavior
		$model->attachBehavior($behaviorClassName, new $behaviorClassName);

		// set value(set attribute)
		foreach($values as $name => $value){
			$model->$behaviorClassName->$name = $value;
		}

		$this->performAjaxValidation($model, 'setting-form');
		// Update
		if(isset($_POST['Setting'])){
			if($model->validate()){
				foreach($values as $pk => $value){
					if(isset($_POST['Setting'][$pk])){
						// Update setting
						$row = $model->findByPk($pk);

						if(!$row){
							// Add setting
							$row = new Setting;
							$row->key = $pk;
						}

						$row->value = serialize($value);

						$row->save(false);
					}else{
						// Delete setting
						$model->deleteByPk($pk);
					}
				}
				Yii::app()->user->setFlash('success', Yii::t('app', 'Operation Success'));
			}else{
				Yii::app()->user->setFlash('warning', Yii::t('app', 'Operation Failure'));
			}
		}


		$this->render('index', array(
			'model' => $model,
		));

	}

}