<?php


class TwzipController extends GxController {

	public function actionCity() {
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$results = TwzipCity::model()->findAll(array('order' => 'sort_order DESC, twzip_city_id ASC'));

			$data = array();
			foreach($results as $model){
				$data[] = $model->getAttributes();
			}

			echo CJSON::encode($data);

			Yii::app()->end();
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	public function actionCounty($id) {
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$results = TwzipCounty::model()->findAllByAttributes(array('twzip_city_id' => $id), array('order' => 'sort_order DESC, twzip_county_id ASC'));

			$data = array();
			foreach($results as $model){
				$data[] = $model->getAttributes();
			}

			echo CJSON::encode($data);

			Yii::app()->end();
		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

}