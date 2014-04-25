<?php
/**
 * @author Sam@ozchamp.net
 *
 */
class StaticController extends GxController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/static'
			// They can be accessed via: index.php?r=static/page&view=FileName
			'page'=>array(
				'class' => 'CViewAction',
				'basePath' => false,
			),
		);
	}
}