<?php
class WebUser extends RWebUser{	// RWebUser for rights module
	/**
	 * @see Check loginUrl
	 */
	public $logoutUrl=array('/site/logout');
	/**
	 * @see Check loginUrl
	 */
	public $profileUrl=array('/site/profile');
	//
	public function logout($destroySession=false){
		parent::logout($destroySession);
	}
}
?>