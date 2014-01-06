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
 *
 *
 * @property i18nStyle, String, horizontal = 1 or verticality = 2
 */
class SettingController extends GxController {
	const I18N_HORIZONTAL_STYLE = 1;
	const I18N_VERTICAL_STYLE = 2;

	public $i18nStyle = self::I18N_HORIZONTAL_STYLE;

	public function actionIndex() {
		$model = Setting::model();

		// parse data using unserialize, compatible with Yii::app()->config->get()
		$settings = CHtml::listData($model->findAll(), 'key', function($row){return unserialize($row->value);});

		// merge post without checking key
		if(isset($_POST['Setting'])){
			$settings = CMap::mergeArray($settings, $_POST['Setting']);
		}
		
		foreach($settings as $name => $value){
			$model->$name = $value;
		}

		$this->performAjaxValidation($model, 'setting-form');
		// Update
		if(isset($_POST['Setting'])){
			if($model->validate()){
				foreach($settings as $pk => $value){
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
						Setting::model()->deleteByPk($pk);
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