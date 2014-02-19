<?php
class WebUser extends CWebUser{
	//
	public function logout($destroySession=false){
		parent::logout($destroySession);
	}
}
?>