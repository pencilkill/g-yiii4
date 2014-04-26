<?php
/**
 * @author @author Sam <mail.song.de.qiang@gmail.com> <mail.song.de.qiang@gmail.com>
 *
 */
class SiteController extends GxController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array();
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('//site/index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
			echo $error['message'];
			else
			$this->render('error', $error);
		}
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionMessage()
	{
		$this->render('message');
	}
	/**
	 * Notice: the parameters url and name should be type of HCUrl::encode separator from each other
	 * @param $url, fileurl
	 * @param $name, download name
	 */
	public function actionDownload($url, $name = NULL){
		return HCOutput::file($url, $name);
	}
}