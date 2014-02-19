<?php
class WebUserBackend extends RWebUser{
	//
	public function logout($destroySession=false){
		parent::logout($destroySession);
	}
}
?>