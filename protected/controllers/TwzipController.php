<?php


class TwzipController extends GxController {

	public function actionCity() {
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data = TwzipCity::model()->findAll(array('order' => 'sort_order DESC, twzip_city_id ASC'));

			echo CJSON::encode(CHtml::listData($data, 'twzip_city_id', 'name'));

			Yii::app()->end();
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	public function actionCounty($id) {
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$data = TwzipCounty::model()->findAllByAttributes(array('twzip_city_id' => $id), array('order' => 'sort_order DESC, twzip_county_id ASC'));

			echo CJSON::encode(CHtml::listData($data, 'name', 'postcode'));

			Yii::app()->end();
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

}