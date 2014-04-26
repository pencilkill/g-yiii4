<?php
/**
 * @author @author Sam <mail.song.de.qiang@gmail.com> <mail.song.de.qiang@gmail.com>
 *
 */
class WikiController extends GxController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/wiki'
			// They can be accessed via: index.php?r=wiki/page&id=viewFileName
			'page'=>array(
				'class' => 'CViewAction',
				'basePath' => false,
				'viewParam' => 'id',
			),
		);
	}
}