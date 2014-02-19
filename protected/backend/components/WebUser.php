<?php
class WebUser extends RWebUser{
	//
	public function logout($destroySession=false){
		parent::logout($destroySession);
	}
}
?>