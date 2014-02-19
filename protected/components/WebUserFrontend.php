<?php
class WebUserFrontend extends CWebUser{
	//
	public function logout($destroySession=false){
		parent::logout($destroySession);
	}
}
?>