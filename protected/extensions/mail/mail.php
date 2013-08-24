<?php
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'class.phpmailer.php';

class Mail extends PHPMailer{
	public function init(){
		parent::init();

		$this->Host = Yii::app()->config->get('mail_smtp_host');
		$this->Username = Yii::app()->config->get('mail_smtp_user');
		$this->Password = Yii::app()->config->get('mail_smtp_password');
		$this->Port = Yii::app()->config->get('mail_smtp_port');
		$this->Mailer = 'smtp';
		//...
	}
}